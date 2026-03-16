<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\VisitorDailyVisitor;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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

        return view('admin.dashboard', [
            'weeklyVisitors'       => $weeklyVisitors,
            'monthlyVisitors'      => $monthlyVisitors,
            'totalPublishedPosts'  => $totalPublishedPosts,
            'todayPosts'           => $todayPosts,
            'yesterdayPosts'       => $yesterdayPosts,
            'draftPendingCount'    => $draftPendingCount,
            'todayVisitors'        => $todayVisitors,
            'yesterdayVisitors'    => $yesterdayVisitors,
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
            ->keyBy(fn ($r) => $r->date->format('Y-m-d'));

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
     * Build a monthly unique visitors series for the last N months (including current month).
     *
     * @return array<array{label:string,value:int}>
     */
    protected function buildMonthlyVisitorsSeries(int $monthsBack): array
    {
        $end = Carbon::today()->endOfMonth();
        $start = (clone $end)->subMonths($monthsBack)->startOfMonth();

        $raw = VisitorDailyVisitor::query()
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('DATE_FORMAT(date, "%Y-%m-01") as month_start, COUNT(DISTINCT visitor_id) as unique_visitors')
            ->groupBy('month_start')
            ->orderBy('month_start')
            ->get()
            ->keyBy('month_start');

        $series = collect();
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $key = $cursor->format('Y-m-01');
            $series->push([
                'label' => $cursor->format('F'),
                'value' => (int) ($raw->get($key)->unique_visitors ?? 0),
            ]);
            $cursor->addMonthNoOverflow()->startOfMonth();
        }

        return $series->all();
    }
}

