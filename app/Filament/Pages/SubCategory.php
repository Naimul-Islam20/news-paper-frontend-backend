<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SubCategory extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Sub Category';

    protected static ?int $navigationSort = 4;

    protected static ?string $title = 'Sub Category';

    protected static string $view = 'filament.pages.placeholder';
}

