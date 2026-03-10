<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Menu extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Menu';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Menu';

    protected static string $view = 'filament.pages.placeholder';
}
