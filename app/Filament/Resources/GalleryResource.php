<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages\CreateGallery;
use App\Filament\Resources\GalleryResource\Pages\EditGallery;
use App\Filament\Resources\GalleryResource\Pages\ListGalleries;
use App\Models\Gallery;
use App\Models\Property;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Galéria';

    protected static ?string $modelLabel = 'Kép';

    protected static ?string $pluralModelLabel = 'Képek';

    protected static string|UnitEnum|null $navigationGroup = 'Média';

    protected static bool $shouldRegisterNavigation = false;

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                FileUpload::make('path')
                    ->image()
                    ->imageEditor()
                    ->label('Kép feltöltése')
                    ->required()
                    ->disk('public')
                    ->directory(fn (Get $get): string => 'property/'.$get('target_table_id').'/gallery')
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
                FileUpload::make('images')
                    ->label('Több kép feltöltése')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory(fn (Get $get): string => 'property/'.$get('target_table_id').'/gallery')
                    ->helperText('Több kép egyszerre feltöltéséhez')
                    ->visible(
                        fn (Get $get): bool => $get('target_table_id') !== null
                    ),
            ]);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return $table
            ->reorderableColumns()
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListGalleries::route('/'),
            'create' => CreateGallery::route('/create'),
            'edit' => EditGallery::route('/{record}/edit'),
        ];
    }
}
