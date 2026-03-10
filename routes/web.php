<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserSettingsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ReporterController;

// Default redirect to admin dashboard (will go to login if not authenticated)
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Fallback login route name that Laravel's auth middleware expects
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::middleware('guest')->group(function (): void {
            Route::get('login', [AdminAuthController::class, 'showLoginForm'])
                ->name('login');

            Route::post('login', [AdminAuthController::class, 'login'])
                // Simple numeric throttle to avoid custom rate limiter config
                ->middleware('throttle:5,1')
                ->name('login.attempt');
        });

        Route::post('logout', [AdminAuthController::class, 'logout'])
            ->middleware('auth')
            ->name('logout');

        Route::middleware(['auth', 'role:admin,editor,reporter'])->group(function (): void {
            Route::get('/', DashboardController::class)->name('dashboard');

            Route::get('/user-settings', [UserSettingsController::class, 'edit'])
                ->name('user-settings.edit');

            Route::put('/user-settings', [UserSettingsController::class, 'update'])
                ->name('user-settings.update');

            Route::get('/categories', [CategoryController::class, 'index'])
                ->name('categories.index');

            Route::get('/sub-categories', [CategoryController::class, 'subCategoryIndex'])
                ->name('sub-categories.index');

            Route::get('/posts', [PostController::class, 'index'])
                ->name('posts.index');
            Route::get('/posts/create', [PostController::class, 'create'])
                ->name('posts.create');

            // Pages
            Route::get('/pages', [PageController::class, 'index'])
                ->name('pages.index');
            Route::get('/pages/create', [PageController::class, 'create'])
                ->name('pages.create');

            // Galleries
            Route::get('/galleries', [GalleryController::class, 'index'])
                ->name('galleries.index');
            Route::get('/galleries/create', [GalleryController::class, 'create'])
                ->name('galleries.create');
            Route::get('/galleries/edit', [GalleryController::class, 'edit'])
                ->name('galleries.edit');

            // Videos
            Route::get('/videos', [VideoController::class, 'index'])
                ->name('videos.index');
            Route::get('/videos/create', [VideoController::class, 'create'])
                ->name('videos.create');
            Route::get('/videos/edit', [VideoController::class, 'edit'])
                ->name('videos.edit');

            // Reporters
            Route::get('/reporters', [ReporterController::class, 'index'])
                ->name('reporters.index');
            Route::get('/reporters/create', [ReporterController::class, 'create'])
                ->name('reporters.create');
            // Advertisement
            Route::get('/advertisements', [App\Http\Controllers\Admin\AdvertisementController::class, 'index'])
                ->name('advertisements.index');
            Route::get('/advertisements/create', [App\Http\Controllers\Admin\AdvertisementController::class, 'create'])
                ->name('advertisements.create');
            Route::get('/advertisements/edit', [App\Http\Controllers\Admin\AdvertisementController::class, 'edit'])
                ->name('advertisements.edit');

            // Statistics
            Route::get('/statistics/visitors', [App\Http\Controllers\Admin\StatisticsController::class, 'visitors'])
                ->name('statistics.visitors');
        });
    });
