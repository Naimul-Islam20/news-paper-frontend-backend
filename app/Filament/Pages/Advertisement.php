<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Advertisement extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Marketing';

    protected static ?string $navigationLabel = 'Advertisement';

    protected static ?int $navigationSort = 11;

    protected static ?string $title = 'Advertisement';

    protected static string $view = 'filament.pages.placeholder';
}
