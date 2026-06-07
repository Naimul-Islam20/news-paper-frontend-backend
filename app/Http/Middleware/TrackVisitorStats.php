<?php

namespace App\Http\Middleware;

use App\Models\VisitorDailyVisitor;
use App\Models\VisitorStat;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorStats
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests on frontend (non-admin) routes
        if (!$request->isMethod('GET')) {
            return $response;
        }

        if ($request->is('admin*')) {
            return $response;
        }

        // Count only real page loads (browser navigation), not AJAX / JSON
        if ($request->ajax() || $request->wantsJson()) {
            return $response;
        }

        // Only count top-level document request (browser address bar / link click)
        $secFetchDest = $request->header('Sec-Fetch-Dest');
        if ($secFetchDest !== null && $secFetchDest !== 'document') {
            return $response;
        }

        // Skip non-page paths (favicon, robots, etc.)
        $pathForCheck = $request->path();
        if (in_array($pathForCheck, ['favicon.ico', 'robots.txt', 'sitemap.xml'], true)) {
            return $response;
        }

        // Determine visitor id (cookie-based, falls back to session id)
        $visitorId = $request->cookie('visitor_id');

        if (!$visitorId) {
            $visitorId = (string) Str::uuid();
            Cookie::queue(cookie('visitor_id', $visitorId, 60 * 24 * 365)); // 1 year
        }

        $date = now()->toDateString();
        $path = '/' . ltrim($request->path(), '/');
        // DB path column is varchar(255); long Bangla/encoded URLs can exceed it
        $path = mb_strlen($path) > 255 ? mb_substr($path, 0, 255) : $path;

        // Page view: every reload / back / new visit = +1. Unique visitor: only first time per path per day.
        DB::transaction(function () use ($date, $path, $visitorId): void {
            $stat = VisitorStat::query()
                ->where('date', $date)
                ->where('path', $path)
                ->lockForUpdate()
                ->first();

            if (!$stat) {
                $stat = new VisitorStat([
                    'date'            => $date,
                    'path'            => $path,
                    'page_views'      => 0,
                    'unique_visitors' => 0,
                ]);
            }

            $stat->page_views++;

            $alreadyCounted = VisitorDailyVisitor::query()
                ->where('date', $date)
                ->where('path', $path)
                ->where('visitor_id', $visitorId)
                ->exists();

            if (!$alreadyCounted) {
                VisitorDailyVisitor::create([
                    'date'       => $date,
                    'path'       => $path,
                    'visitor_id' => $visitorId,
                ]);
                $stat->unique_visitors++;
            }

            $stat->save();
        });

        return $response;
    }
}

