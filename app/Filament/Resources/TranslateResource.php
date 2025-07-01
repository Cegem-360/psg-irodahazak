<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TranslateResource\Pages\CreateTranslate;
use App\Filament\Resources\TranslateResource\Pages\EditTranslate;
use App\Filament\Resources\TranslateResource\Pages\ListTranslates;
use App\Filament\Resources\TranslateResource\Pages\ViewTranslate;
use App\Models\Translate;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class TranslateResource extends Resource
{
    protected static ?string $model = Translate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
