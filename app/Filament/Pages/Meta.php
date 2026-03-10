<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Meta extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Meta';

    protected static ?int $navigationSort = 13;

    protected static ?string $title = 'Meta';

    protected static string $view = 'filament.pages.placeholder';
}
