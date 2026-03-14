<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorDailyVisitor;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // Weekly (last 7 days, including today)
        $weeklyVisitors = $this->buildDailyVisitorsSeries(6);

        // Monthly (last 30 days, including today)
        $monthlyVisitors = $this->buildDailyVisitorsSeries(29);

        return view('admin.dashboard', [
            'weeklyVisitors'  => $weeklyVisitors,
            'monthlyVisitors' => $monthlyVisitors,
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
}

