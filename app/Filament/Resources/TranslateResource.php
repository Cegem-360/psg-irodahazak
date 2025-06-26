<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TranslateResource\Pages;
use App\Models\Translate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class TranslateResource extends Resource
{
    protected static ?string $model = Translate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('translated')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('date'),
                Forms\Components\TextInput::make('lang')
                    ->maxLength(2)
                    ->default('EN'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('translated')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lang')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTranslates::route('/'),
            'create' => Pages\CreateTranslate::route('/create'),
            'view' => Pages\ViewTranslate::route('/{record}'),
            'edit' => Pages\EditTranslate::route('/{record}/edit'),
        ];
    }
}
