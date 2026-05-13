<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'track.visitors' => \App\Http\Middleware\TrackVisitorStats::class,
            'feature' => \App\Http\Middleware\EnsureUserCanFeature::class,
        ]);

        // Track visitors on all web routes (frontend only; middleware itself skips /admin)
        $middleware->appendToGroup('web', \App\Http\Middleware\TrackVisitorStats::class);

        // সাইট মেটা (primary_color সহ) প্রতি রিকোয়েস্টে রিফ্রেশ — cPanel/Octane এ boot()-এ share স্টেল হলে রঙ আপডেট দেখা যায় না
        $middleware->prependToGroup('web', \App\Http\Middleware\ShareSiteMeta::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
