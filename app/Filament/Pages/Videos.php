<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Videos extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Videos';

    protected static ?int $navigationSort = 6;

    protected static ?string $title = 'Videos';

    protected static string $view = 'filament.pages.placeholder';
}
