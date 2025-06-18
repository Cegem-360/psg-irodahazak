<?php

declare(strict_types=1);

namespace App\Filament\Resources\PropertyResource\RelationManagers;

use App\Models\Gallery;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Galéria képek';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                FileUpload::make('path')
                    ->image()
                    ->label('Kép feltöltése')
                    ->required()
                    ->disk('public')
                    ->directory(function (Gallery $record): string {
                        return 'property/'.$record->target_table_id.'/gallery';
                    })
                    ->preserveFilenames()
                    ->helperText('Max. 10 MB, csak képek'),
                TextInput::make('path_without_size_and_ext')
                    ->label('Alap útvonal (méret és kiterjesztés nélkül)')
                    ->maxLength(255)
                    ->helperText('Automatikusan beállítva a kép feltöltésekor'),
                TextInput::make('size')
                    ->label('Méret')
                    ->maxLength(20)
                    ->placeholder('pl.: 800x600'),
                TextInput::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0),
                TextInput::make('alt')
                    ->label('Alt text')
                    ->maxLength(255),
                Hidden::make('target_table')
                    ->default('property'),
                DateTimePicker::make('date')
                    ->label('Dátum'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('path')
            ->columns([
                ImageColumn::make('path')
                    ->label('Kép')
                    ->getStateUsing(fn (Gallery $record): string => $record->image_url)
                    ->height(60)
                    ->width(80),
                TextColumn::make('size')
                    ->label('Méret'),
                TextColumn::make('ord')
                    ->label('Sorrend')
                    ->sortable(),
                TextColumn::make('alt')
                    ->label('Alt text')
                    ->limit(30),
                IconColumn::make('image_exists')
                    ->label('Létezik')
                    ->getStateUsing(fn (Gallery $record): bool => $record->imageExists())
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['target_table'] = 'property';

                        return $data;
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                Action::make('view_image')
                    ->label('Megtekintés')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Gallery $record): string => $record->image_url)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('ord');
    }
}
