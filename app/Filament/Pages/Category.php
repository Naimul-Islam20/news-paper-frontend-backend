<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Category extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'All Category';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'All Category';

    protected static string $view = 'filament.pages.placeholder';
}
