<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Reporters extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Reporters';

    protected static ?int $navigationSort = 10;

    protected static ?string $title = 'Reporters';

    protected static string $view = 'filament.pages.placeholder';
}
