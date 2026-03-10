<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class LayoutSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Layout Settings';

    protected static ?int $navigationSort = 7;

    protected static ?string $title = 'Layout Settings';

    protected static string $view = 'filament.pages.placeholder';
}
