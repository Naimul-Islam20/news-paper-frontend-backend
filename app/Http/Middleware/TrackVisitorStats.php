<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackVisitorStats
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! config('app.visitor_tracking', false)) {
            return $response;
        }

        if (! $this->shouldTrack($request)) {
            return $response;
        }

        $this->recordVisit(
            now()->toDateString(),
            $this->normalizePath($request),
            $this->resolveVisitorId($request),
        );

        return $response;
    }

    private function shouldTrack(Request $request): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($request->is('admin*')) {
            return false;
        }

        if ($request->ajax() || $request->wantsJson()) {
            return false;
        }

        if ($this->isStaticAssetRequest($request)) {
            return false;
        }

        $secFetchDest = $request->header('Sec-Fetch-Dest');
        if ($secFetchDest !== null && $secFetchDest !== 'document') {
            return false;
        }

        $accept = (string) $request->header('Accept', '');
        if ($accept !== '' && str_contains($accept, 'image/') && ! str_contains($accept, 'text/html')) {
            return false;
        }

        $pathForCheck = $request->path();

        return ! in_array($pathForCheck, ['favicon.ico', 'robots.txt', 'sitemap.xml'], true);
    }

    private function isStaticAssetRequest(Request $request): bool
    {
        $path = strtolower($request->path());

        foreach (['build/', 'storage/', 'public/build/', 'public/storage/'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return in_array($extension, [
            'webp', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico', 'avif',
            'css', 'js', 'map', 'woff', 'woff2', 'ttf', 'eot',
            'mp4', 'webm', 'mp3', 'pdf', 'zip',
        ], true);
    }

    private function normalizePath(Request $request): string
    {
        $path = rawurldecode('/' . ltrim($request->path(), '/'));

        return mb_strlen($path) > 255 ? mb_substr($path, 0, 255) : $path;
    }

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
     * Never throws — a stats failure must not affect the site.
     */
    private function recordVisit(string $date, string $path, string $visitorId): void
    {
        $attempts = 0;

        while ($attempts < 5) {
            try {
                $this->performRecordVisit($date, $path, $visitorId);

                return;
            } catch (Throwable $e) {
                $attempts++;

                if ($attempts >= 5 || ! $this->isRetryableDbError($e)) {
                    return;
                }

                usleep(random_int(10_000, 50_000) * $attempts);
            }
        }
    }

    private function performRecordVisit(string $date, string $path, string $visitorId): void
    {
        $now = now()->toDateTimeString();

        DB::table('visitor_daily_visitors')->insertOrIgnore([
            'date'       => $date,
            'path'       => $path,
            'visitor_id' => $visitorId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::statement(
            'INSERT INTO visitor_stats (`date`, `path`, page_views, unique_visitors, created_at, updated_at)
             VALUES (?, ?, 1, 0, ?, ?)
             ON DUPLICATE KEY UPDATE page_views = page_views + 1, updated_at = VALUES(updated_at)',
            [$date, $path, $now, $now],
        );
    }

    private function isRetryableDbError(Throwable $e): bool
    {
        if (! $e instanceof QueryException) {
            return false;
        }

        $code = (string) $e->getCode();
        $message = $e->getMessage();

        return in_array($code, ['1213', '1205'], true)
            || str_contains($message, 'Deadlock')
            || str_contains($message, 'Lock wait timeout');
    }
}
