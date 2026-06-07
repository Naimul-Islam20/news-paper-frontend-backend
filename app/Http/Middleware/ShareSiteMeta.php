<?php

namespace App\Http\Middleware;

use App\Models\SiteMeta;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * প্রতি HTTP রিকোয়েস্টে সাইট মেটা শেয়ার (Octane/কিছু হোস্টে boot()-এ View::share স্টেল হওয়া এড়ায়)।
 */
class ShareSiteMeta
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            View::share('siteMeta', SiteMeta::first());
        } catch (\Throwable) {
            View::share('siteMeta', null);
        }

        return $next($request);
    }
}
