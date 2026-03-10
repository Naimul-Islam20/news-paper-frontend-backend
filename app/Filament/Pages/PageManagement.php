<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class PageManagement extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Page';

    protected static ?int $navigationSort = 4;

    protected static ?string $title = 'Page';

    protected static string $view = 'filament.pages.placeholder';
}
