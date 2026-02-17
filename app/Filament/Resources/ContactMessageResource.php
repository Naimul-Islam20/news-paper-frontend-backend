<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Filament\Resources\ContactMessageResource\RelationManagers;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationGroup = 'Contact';

    protected static ?string $navigationLabel = 'Form Messages';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Message Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label(new HtmlString('<span style="font-weight: 600; font-size: 1.0rem; color: #000;">Name</span>')),
                        Infolists\Components\TextEntry::make('email')
                            ->label(new HtmlString('<span style="font-weight: 600; font-size: 1.0rem; color: #000;">Email</span>')),
                        Infolists\Components\TextEntry::make('subject')
                            ->label(new HtmlString('<span style="font-weight: 600; font-size: 1.0rem; color: #000;">Subject</span>')),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label(new HtmlString('<span style="font-weight: 600; font-size: 1.0rem; color: #000;">Submitted At</span>'))
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('message')
                            ->label(new HtmlString('<span style="font-weight: 600; font-size: 1.0rem; color: #000;">Message</span>'))
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->disabled(fn (string $context): bool => $context !== 'create')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->disabled(fn (string $context): bool => $context !== 'create')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subject')
                    ->disabled(fn (string $context): bool => $context !== 'create')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->disabled(fn (string $context): bool => $context !== 'create')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unread' => 'success',
                        'read' => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'unread' => 'heroicon-m-check-circle',
                        'read' => 'heroicon-m-eye',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
        ];
    }
}
