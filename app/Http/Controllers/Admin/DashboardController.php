<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\VisitorDailyVisitor;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // Weekly (last 7 days, including today)
        $weeklyVisitors = $this->buildDailyVisitorsSeries(6);

        // Monthly (last 12 months, including current month) – 12 dots, 12 month labels
        $monthlyVisitors = $this->buildMonthlyVisitorsSeries(11);

        // Stat cards: real counts from database
        $totalPublishedPosts = Post::where('status', 'published')->count();
        $todayPosts = Post::where('status', 'published')->whereDate('created_at', Carbon::today())->count();
        $yesterdayPosts = Post::where('status', 'published')->whereDate('created_at', Carbon::yesterday())->count();
        $draftPendingCount = Post::whereIn('status', ['draft', 'pending'])->count();
        $todayVisitors = (int) VisitorDailyVisitor::whereDate('date', Carbon::today())
            ->selectRaw('COUNT(DISTINCT visitor_id) as c')
            ->value('c');
        $yesterdayVisitors = (int) VisitorDailyVisitor::whereDate('date', Carbon::yesterday())
            ->selectRaw('COUNT(DISTINCT visitor_id) as c')
            ->value('c');

        // Last 10 days window
        $tenDaysAgo = Carbon::today()->subDays(9)->startOfDay();
        $todayEnd   = Carbon::today()->endOfDay();

        // Top 5 categories by views in last 10 days
        $topCategories = Category::query()
            ->select([
                'categories.id',
                'categories.name',
                DB::raw('COUNT(DISTINCT posts.id) as posts_count'),
                DB::raw('SUM(posts.views) as views_sum'),
            ])
            ->join('category_post', 'categories.id', '=', 'category_post.category_id')
            ->join('posts', 'posts.id', '=', 'category_post.post_id')
            ->where('posts.status', 'published')
            ->whereBetween('posts.created_at', [$tenDaysAgo, $todayEnd])
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('views_sum')
            ->limit(5)
            ->get();

        // Top 5 viewed posts in last 10 days (for "Top 5 viewed Posts" card)
        $topPosts = Post::query()
            ->with(['categories.parent', 'reporter'])
            ->where('status', 'published')
            ->whereBetween('created_at', [$tenDaysAgo, $todayEnd])
            ->orderByDesc('views')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Latest posts (post-type only) for Newsroom Activity
        $recentPosts = Post::query()
            ->with(['categories.parent', 'reporter'])
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'weeklyVisitors'       => $weeklyVisitors,
            'monthlyVisitors'      => $monthlyVisitors,
            'totalPublishedPosts'  => $totalPublishedPosts,
            'todayPosts'           => $todayPosts,
            'yesterdayPosts'       => $yesterdayPosts,
            'draftPendingCount'    => $draftPendingCount,
            'todayVisitors'        => $todayVisitors,
            'yesterdayVisitors'    => $yesterdayVisitors,
            'topCategories'        => $topCategories,
            'topPosts'             => $topPosts,
            'recentPosts'          => $recentPosts,
        ]);
    }

    /**
     * Build a daily site-wide unique visitors series for the last N days.
     *
     * @return array<array{label:string,value:int}>
     */
    protected function buildDailyVisitorsSeries(int $daysBack): array
    {
        $end = Carbon::today();
        $start = (clone $end)->subDays($daysBack);

        $raw = VisitorDailyVisitor::query()
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('date, COUNT(DISTINCT visitor_id) as unique_visitors')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy(fn($r) => $r->date->format('Y-m-d'));

        $series = collect();
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $key = $cursor->format('Y-m-d');
            $series->push([
                'label' => $cursor->format('d M'),
                'value' => (int) ($raw->get($key)->unique_visitors ?? 0),
            ]);
            $cursor->addDay();
        }

        return $series->all();
    }

    /**
     * Build a monthly visitors series for the last N months (including current month).
     *
     * এখানে প্রতি মাসের value হচ্ছে:
     * ঐ মাসের প্রতিদিনের site-wide unique_visitors এর যোগফল
     * (sum of daily uniques), range-wide DISTINCT না।
     *
     * @return array<array{label:string,value:int}>
     */
    protected function buildMonthlyVisitorsSeries(int $monthsBack): array
    {
        $end = Carbon::today()->endOfMonth();
        $start = (clone $end)->subMonths($monthsBack)->startOfMonth();

        // প্রতিদিনের site-wide unique visitors (একই visitor এক দিনে একবার)
        $raw = VisitorDailyVisitor::query()
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('date, COUNT(DISTINCT visitor_id) as unique_visitors')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $series = collect();
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $monthStart = $cursor->copy()->startOfMonth();
            $monthEnd   = $cursor->copy()->endOfMonth();

            // এই মাসের সব দিনের unique_visitors sum করছি
            $monthlyTotal = (int) $raw
                ->filter(function ($row) use ($monthStart, $monthEnd) {
                    return $row->date->betweenIncluded($monthStart, $monthEnd);
                })
                ->sum('unique_visitors');

            $series->push([
                'label' => $cursor->format('F'),
                'value' => $monthlyTotal,
            ]);
            $cursor->addMonthNoOverflow()->startOfMonth();
        }

        return $series->all();
    }
}
