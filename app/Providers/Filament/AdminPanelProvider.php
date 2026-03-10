<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel
            ->default()
            ->id('admin')
            ->path('panel')
            ->brandName('Arop Group')
            ->login()
            ->colors([
                'primary' => Color::Indigo,
                'gray' => Color::Slate,
            ])
            ->font('Poppins')
            ->favicon(asset('favicon.ico'))
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'Content',
                'Settings',
                'User Management',
                'Analytics',
                'Marketing',
                'Contact',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): HtmlString => new HtmlString('
                <style>
                    .fi-sidebar {
                        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.05);
                        border-right: 1px solid rgba(0, 0, 0, 0.05);
                        position: relative !important;
                    }
                    .fi-sidebar-header {
                        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
                    }
                    /* Sidebar Items - Making them big again */
                    .fi-sidebar-item-button {
                        background-color: #f3f4f6 !important; /* Light gray */
                        margin-bottom: 2px !important;
                        border-radius: 0px !important; /* Sharp or default edges for boro feel */
                        margin-left: 0px !important;
                        margin-right: 0px !important;
                        padding-top: 10px !important;
                        padding-bottom: 10px !important;
                    }
                    /* Slide/Collapse Button - Half inside, half outside */
                    .fi-sidebar-collapse-button {
                        position: absolute !important;
                        right: -16px !important;
                        top: 20px !important;
                        z-index: 50 !important;
                        background-color: white !important;
                        border: 1px solid #e5e7eb !important;
                        border-radius: 50% !important;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
                    }
                </style>
            '),
        );

        return $panel;
    }
}
