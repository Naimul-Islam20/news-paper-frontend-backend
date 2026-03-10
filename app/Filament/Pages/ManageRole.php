<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ManageRole extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?string $navigationLabel = 'Manage Role';

    protected static ?int $navigationSort = 8;

    protected static ?string $title = 'Manage Role';

    protected static string $view = 'filament.pages.placeholder';
}
