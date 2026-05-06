<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TranslateResource\Pages\CreateTranslate;
use App\Filament\Resources\TranslateResource\Pages\EditTranslate;
use App\Filament\Resources\TranslateResource\Pages\ListTranslates;
use App\Filament\Resources\TranslateResource\Pages\ViewTranslate;
use App\Models\Translate;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

final class TranslateResource extends Resource
{
    protected static ?string $model = Translate::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Fordítások';

    protected static ?string $modelLabel = 'Fordítás';

    protected static ?string $pluralModelLabel = 'Fordítások';

    protected static string|UnitEnum|null $navigationGroup = 'Fordítások';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('translated')
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('date'),
                TextInput::make('lang')
                    ->maxLength(2)
                    ->default('EN'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderableColumns()
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('translated')
                    ->searchable(),
                TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('lang')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
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
            'index' => ListTranslates::route('/'),
            'create' => CreateTranslate::route('/create'),
            'view' => ViewTranslate::route('/{record}'),
            'edit' => EditTranslate::route('/{record}/edit'),
        ];
    }
}
