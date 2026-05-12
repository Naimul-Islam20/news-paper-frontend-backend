<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\SiteMeta;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->configureForcedRootUrl();

        // Share site meta (SEO/Meta settings) with ALL views so frontend always gets it
        try {
            View::share('siteMeta', SiteMeta::first());
        } catch (\Throwable) {
            View::share('siteMeta', null);
        }

        // Share header/footer categories with all frontend layout views
        View::composer(
            ['components.header', 'components.footer', 'components.layout'],
            function ($view) {
                try {
                    $headerIds = Setting::getJson('header_categories', []);
                    $col2Ids = Setting::getJson('footer_col2_categories', []);
                    $col3Ids = Setting::getJson('footer_col3_categories', []);

                    // Preserve admin-order for each section
                    $headerCategories = $headerIds
                        ? Category::whereIn('id', $headerIds)->get()->sortBy(fn ($c) => array_search($c->id, $headerIds))->values()
                        : collect();

                    $footerCol2 = $col2Ids
                        ? Category::whereIn('id', $col2Ids)->get()->sortBy(fn ($c) => array_search($c->id, $col2Ids))->values()
                        : collect();

                    $footerCol3 = $col3Ids
                        ? Category::whereIn('id', $col3Ids)->get()->sortBy(fn ($c) => array_search($c->id, $col3Ids))->values()
                        : collect();

                    // Combined categories for the side menu drawer (Header -> Footer2 -> Footer3)
                    $sideMenuCategories = $headerCategories->merge($footerCol2)->merge($footerCol3)->unique('id');

                } catch (\Throwable) {
                    $headerCategories = collect();
                    $footerCol2 = collect();
                    $footerCol3 = collect();
                    $sideMenuCategories = collect();
                }

                try {
                    $siteMeta = SiteMeta::first();
                } catch (\Throwable) {
                    $siteMeta = null;
                }

                $view->with(compact(
                    'headerCategories',
                    'footerCol2',
                    'footerCol3',
                    'sideMenuCategories',
                    'siteMeta'
                ));
            }
        );
    }

    /**
     * URL জেনারেশন: APP_URL এর হোস্ট আর ব্রাউজারের হোস্ট আলাদা হলে request()->root() ব্যবহার করুন।
     * নইলে @vite / asset() লিংক localhost বা ভুল ডোমেইনে যায় — ডেস্কটপ/মোবাইলে CSS একদম লোড হয় না।
     * কনসোল/কিউতে APP_URL ই ব্যবহার হয়।
     */
    private function configureForcedRootUrl(): void
    {
        $configured = rtrim((string) config('app.url', ''), '/');
        if ($configured === '') {
            return;
        }

        if ($this->app->runningInConsole()) {
            URL::forceRootUrl($configured);

            return;
        }

        try {
            $request = request();
            if (! $request) {
                URL::forceRootUrl($configured);

                return;
            }

            $requestRoot = rtrim((string) $request->root(), '/');
            $configHost = parse_url($configured, PHP_URL_HOST);
            $requestHost = parse_url($requestRoot, PHP_URL_HOST) ?: $request->getHost();

            if (
                $requestRoot !== ''
                && is_string($configHost) && $configHost !== ''
                && is_string($requestHost) && $requestHost !== ''
                && strcasecmp($configHost, $requestHost) !== 0
            ) {
                URL::forceRootUrl($requestRoot);

                return;
            }
        } catch (\Throwable) {
            // keep configured URL
        }

        URL::forceRootUrl($configured);
    }
}
