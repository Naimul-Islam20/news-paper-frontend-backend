<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorStat;
use App\Models\VisitorDailyVisitor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    public function visitors(Request $request): View
    {
        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');

        if (!$dateFrom || !$dateTo) {
            $dateTo = now()->toDateString();
            $dateFrom = now()->subDays(6)->toDateString(); // last 7 days
        }

        // Page views per day (from visitor_stats)
        $pageViewsDaily = VisitorStat::query()
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->selectRaw('date, SUM(page_views) as page_views')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->keyBy(fn ($r) => $r->date->format('Y-m-d'));

        // Site-wide unique visitors per day: distinct visitor_id per date (not per path)
        $uniqueDaily = VisitorDailyVisitor::query()
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->selectRaw('date, COUNT(DISTINCT visitor_id) as unique_visitors')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->keyBy(fn ($r) => $r->date->format('Y-m-d'));

        // Merge: each day = page_views + unique_visitors (site-wide)
        $allDates = $pageViewsDaily->keys()->merge($uniqueDaily->keys())->unique()->sortDesc()->values();
        $daily = $allDates->map(function ($date) use ($pageViewsDaily, $uniqueDaily) {
            return (object) [
                'date'            => $date,
                'page_views'      => $pageViewsDaily->get($date)?->page_views ?? 0,
                'unique_visitors' => (int) ($uniqueDaily->get($date)?->unique_visitors ?? 0),
            ];
        });

        $totalPageViews      = $daily->sum('page_views');
        // এখানে আমরা এখন range-wide DISTINCT না নিয়ে
        // প্রতিদিনের unique_visitors এর যোগফল নিচ্ছি (sum of daily uniques)
        $totalUniqueVisitors = $daily->sum('unique_visitors');

        return view('admin.statistics.visitors', [
            'dateFrom'            => $dateFrom,
            'dateTo'              => $dateTo,
            'daily'               => $daily,
            'totalPageViews'      => $totalPageViews,
            'totalUniqueVisitors' => $totalUniqueVisitors,
        ]);
    }
}
