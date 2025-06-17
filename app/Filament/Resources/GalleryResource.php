<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('path')
                    ->required()
                    ->maxLength(255)
                    ->helperText('pl.: ./uploads/property/43/gallery/2_160x160.jpg'),
                Forms\Components\Select::make('target_table_id')
                    ->label('Property')
                    ->options(Property::all()->pluck('title', 'id'))
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('size')
                    ->maxLength(20)
                    ->placeholder('pl.: 800x600'),
                Forms\Components\DateTimePicker::make('date'),
                Forms\Components\TextInput::make('target_table')
                    ->default('property')
                    ->maxLength(150),
                Forms\Components\TextInput::make('path_without_size_and_ext')
                    ->maxLength(255)
                    ->helperText('pl.: ./uploads/property/43/gallery/2'),
                Forms\Components\TextInput::make('alt')
                    ->label('Alt text')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gallery_category_id')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('video_url')
                    ->url()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Kép')
                    ->getStateUsing(fn (Gallery $record): string => $record->image_url)
                    ->height(60)
                    ->width(80),
                Tables\Columns\TextColumn::make('property.title')
                    ->label('Ingatlan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('target_table_id')
                    ->label('Property ID')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('size')
                    ->label('Méret')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alt')
                    ->label('Alt text')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('date')
                    ->label('Dátum')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('image_exists')
                    ->label('Létezik')
                    ->getStateUsing(fn (Gallery $record): bool => $record->imageExists())
                    ->boolean(),
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
