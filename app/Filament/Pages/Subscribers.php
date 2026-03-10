<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Subscribers extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    protected static ?string $navigationGroup = 'Marketing';

    protected static ?string $navigationLabel = 'Subscribers';

    protected static ?int $navigationSort = 12;

    protected static ?string $title = 'Subscribers';

    protected static string $view = 'filament.pages.placeholder';
}
