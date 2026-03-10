<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Gallery extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Gallery';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'Gallery';

    protected static string $view = 'filament.pages.placeholder';
}
