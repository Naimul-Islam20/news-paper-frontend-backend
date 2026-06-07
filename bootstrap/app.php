<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;

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
        $exceptions->render(function (PostTooLargeException $e, Request $request) {
            if (! $request->is('admin/*')) {
                return null;
            }

            $message = 'আপলোড ব্যর্থ: ফাইল বা ফর্ম ডেটা সার্ভারের সীমা (post_max_size) ছাড়িয়ে গেছে। '
                .'২৪MB+ ভিডিওর জন্য হোস্টিং/cPanel এ upload_max_filesize ও post_max_size কমপক্ষে 64M সেট করুন। '
                .'(Nginx হলে client_max_body_size 64M)';

            return redirect()->back()
                ->withInput($request->except(['image', 'image_mobile', 'video', 'video_mobile', '_token']))
                ->withErrors(['video' => $message]);
        });

        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if (! $request->is('admin/login') || ! $request->isMethod('POST')) {
                return null;
            }

            $retryAfter = (int) ($e->getHeaders()['Retry-After'] ?? 60);

            return redirect()->route('admin.login')
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => "অনেকবার ভুল লগইন চেষ্টা হয়েছে। {$retryAfter} সেকেন্ড পর আবার চেষ্টা করুন।",
                ]);
        });
    })->create();
