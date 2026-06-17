<?php

namespace App\Http\Middleware;

use App\Models\VisitorStat;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;
use Throwable;

class TrackVisitorStats
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests on frontend (non-admin) routes
        if (! $request->isMethod('GET')) {
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

        $visitorId = $this->resolveVisitorId($request);

        // Asia/Dhaka — রাত ১২টার পর নতুন date, নতুন দিনের unique শুরু
        $date = now()->toDateString();
        $path = '/' . ltrim($request->path(), '/');
        // DB path column is varchar(255); long Bangla/encoded URLs can exceed it
        $path = mb_strlen($path) > 255 ? mb_substr($path, 0, 255) : $path;

        try {
            $this->recordVisit($date, $path, $visitorId);
        } catch (Throwable $e) {
            // Visitor stats must never block page delivery.
            report($e);
        }

        return $response;
    }

    /**
     * Cookie + session fallback — একই ব্রাউজারে একই visitor_id বজায় থাকে।
     */
    private function resolveVisitorId(Request $request): string
    {
        $visitorId = $request->cookie('visitor_id') ?? $request->session()->get('visitor_id');

        if (is_string($visitorId) && $visitorId !== '' && strlen($visitorId) <= 191) {
            $request->session()->put('visitor_id', $visitorId);
            $this->queueVisitorCookie($request, $visitorId);

            return $visitorId;
        }

        $visitorId = (string) Str::uuid();
        $request->session()->put('visitor_id', $visitorId);
        $this->queueVisitorCookie($request, $visitorId);

        return $visitorId;
    }

    private function queueVisitorCookie(Request $request, string $visitorId): void
    {
        Cookie::queue(new SymfonyCookie(
            name: 'visitor_id',
            value: $visitorId,
            expire: time() + (60 * 60 * 24 * 365),
            path: '/',
            secure: $request->isSecure(),
            httpOnly: true,
            raw: false,
            sameSite: SymfonyCookie::SAMESITE_LAX,
        ));
    }

    /**
     * Atomic upsert/insert — no lockForUpdate, avoids concurrent INSERT deadlocks.
     */
    private function recordVisit(string $date, string $path, string $visitorId): void
    {
        $attempts = 0;

        while (true) {
            try {
                $this->performRecordVisit($date, $path, $visitorId);

                return;
            } catch (QueryException $e) {
                $attempts++;

                if ($attempts >= 3 || ! $this->isRetryableDbError($e)) {
                    throw $e;
                }

                usleep(50_000 * $attempts);
            }
        }
    }

    private function performRecordVisit(string $date, string $path, string $visitorId): void
    {
        $now = now();

        // Site-wide unique: এক visitor প্রতিদিন একবার (ভিন্ন পেজে গেলেও আর count হবে না)।
        $isNewSiteVisitor = DB::table('visitor_daily_visitors')->insertOrIgnore([
            'date'       => $date,
            'path'       => $path,
            'visitor_id' => $visitorId,
            'created_at' => $now,
            'updated_at' => $now,
        ]) === 1;

        // Page view: প্রতিটি পেজ লোডে +1 (unique নয়)।
        VisitorStat::query()->upsert(
            [
                [
                    'date'            => $date,
                    'path'            => $path,
                    'page_views'      => 1,
                    'unique_visitors' => 0,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ],
            ],
            ['date', 'path'],
            [
                'page_views' => DB::raw('page_views + 1'),
                'updated_at' => $now,
            ],
        );

        // Site-wide daily unique summary row (path = *).
        if ($isNewSiteVisitor) {
            VisitorStat::query()->upsert(
                [
                    [
                        'date'            => $date,
                        'path'            => '*',
                        'page_views'      => 0,
                        'unique_visitors' => 1,
                        'created_at'      => $now,
                        'updated_at'      => $now,
                    ],
                ],
                ['date', 'path'],
                [
                    'unique_visitors' => DB::raw('unique_visitors + 1'),
                    'updated_at'      => $now,
                ],
            );
        }
    }

    private function isRetryableDbError(QueryException $e): bool
    {
        $code = (string) $e->getCode();
        $message = $e->getMessage();

        // MySQL deadlock (1213) or lock wait timeout (1205).
        return in_array($code, ['1213', '1205'], true)
            || str_contains($message, 'Deadlock')
            || str_contains($message, 'Lock wait timeout');
    }
}
