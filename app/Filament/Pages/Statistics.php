<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Statistics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?string $navigationLabel = 'Statistics';

    protected static ?int $navigationSort = 9;

    protected static ?string $title = 'Statistics';

    protected static string $view = 'filament.pages.placeholder';
}
