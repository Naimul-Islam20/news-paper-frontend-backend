<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\SiteMeta;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
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
                    $footerIds  = Setting::getJson('footer_categories', []);

                    // Preserve admin-selected order by sorting in PHP after fetch
                    $headerCategories = $headerIds
                        ? Category::whereIn('id', $headerIds)->get()->sortBy(fn($c) => array_search($c->id, $headerIds))->values()
                        : collect();

                    $footerCategories = $footerIds
                        ? Category::whereIn('id', $footerIds)->get()->sortBy(fn($c) => array_search($c->id, $footerIds))->values()
                        : collect();
                } catch (\Throwable) {
                    $headerCategories = collect();
                    $footerCategories = collect();
                }

                try {
                    $siteMeta = SiteMeta::first();
                } catch (\Throwable) {
                    $siteMeta = null;
                }

                $view->with(compact('headerCategories', 'footerCategories', 'siteMeta'));
            }
        );
    }
}
