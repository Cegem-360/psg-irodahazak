<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages\CreateGallery;
use App\Filament\Resources\GalleryResource\Pages\EditGallery;
use App\Filament\Resources\GalleryResource\Pages\ListGalleries;
use App\Models\Gallery;
use App\Models\Property;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Galéria';

    protected static ?string $modelLabel = 'Kép';

    protected static ?string $pluralModelLabel = 'Képek';

    protected static ?string $navigationGroup = 'Média';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('path')
                    ->image()
                    ->imageEditor()
                    ->label('Kép feltöltése')
                    ->required()
                    ->disk('public')
                    ->directory(function (Get $get): string {
                        return 'property/'.$get('target_table_id').'/gallery';
                    })
                    ->preserveFilenames()
                    ->helperText('Max. 10 MB, csak képek')
                    ->visible(
                        fn (Get $get): bool => $get('target_table_id') !== null
                    ),
                Select::make('target_table_id')
                    ->label('Property')
                    ->options(Property::all()->pluck('title', 'id'))
                    ->live()
                    ->required()
                    ->searchable(),
                TextInput::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0),
                TextInput::make('size')
                    ->maxLength(20)
                    ->placeholder('pl.: 800x600'),
                DateTimePicker::make('date'),
                TextInput::make('target_table')
                    ->default('property')
                    ->maxLength(150),
                TextInput::make('path_without_size_and_ext')
                    ->maxLength(255)
                    ->helperText('Automatikusan beállítva a kép feltöltésekor'),
                TextInput::make('alt')
                    ->label('Alt text')
                    ->maxLength(255),
                TextInput::make('gallery_category_id')
                    ->numeric()
                    ->default(0),
                TextInput::make('video_url')
                    ->url()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('path')
                    ->label('Kép')
                    ->disk('public')
                    ->visibility('public')
                    ->height(60)
                    ->width(80),
                TextColumn::make('property.title')
                    ->label('Ingatlan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('target_table_id')
                    ->label('Property ID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('size')
                    ->label('Méret')
                    ->searchable(),
                TextColumn::make('alt')
                    ->label('Alt text')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('date')
                    ->label('Dátum')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('image_exists')
                    ->label('Létezik')
                    ->getStateUsing(fn (Gallery $record): bool => $record->imageExists())
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => ListGalleries::route('/'),
            'create' => CreateGallery::route('/create'),
            'edit' => EditGallery::route('/{record}/edit'),
        ];
    }
}
