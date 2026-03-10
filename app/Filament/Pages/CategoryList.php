<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CategoryList extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Category';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Category';

    protected static string $view = 'filament.pages.placeholder';
}

