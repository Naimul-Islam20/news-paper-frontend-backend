<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Post extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Post';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Post';

    protected static string $view = 'filament.pages.placeholder';
}
