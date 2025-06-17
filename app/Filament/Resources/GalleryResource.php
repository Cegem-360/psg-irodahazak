<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('path')
                    ->maxLength(255),
                Forms\Components\TextInput::make('target_table_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('ord')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('size')
                    ->maxLength(20),
                Forms\Components\DateTimePicker::make('date'),
                Forms\Components\TextInput::make('target_table')
                    ->maxLength(150),
                Forms\Components\TextInput::make('path_without_size_and_ext')
                    ->maxLength(255),
                Forms\Components\TextInput::make('alt')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gallery_category_id')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('video_url')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('target_table_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ord')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_table')
                    ->searchable(),
                Tables\Columns\TextColumn::make('path_without_size_and_ext')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gallery_category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('video_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
