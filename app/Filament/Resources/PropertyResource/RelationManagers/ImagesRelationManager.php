<?php

declare(strict_types=1);

namespace App\Filament\Resources\PropertyResource\RelationManagers;

use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

final class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Galéria képek';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('path')
                    ->label('Kép útvonal')
                    ->required()
                    ->maxLength(255)
                    ->helperText('pl.: ./uploads/property/43/gallery/2_160x160.jpg'),
                Forms\Components\TextInput::make('path_without_size_and_ext')
                    ->label('Alap útvonal (méret és kiterjesztés nélkül)')
                    ->maxLength(255)
                    ->helperText('pl.: ./uploads/property/43/gallery/2'),
                Forms\Components\TextInput::make('size')
                    ->label('Méret')
                    ->maxLength(20)
                    ->placeholder('pl.: 800x600'),
                Forms\Components\TextInput::make('ord')
                    ->label('Sorrend')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('alt')
                    ->label('Alt text')
                    ->maxLength(255),
                Forms\Components\Hidden::make('target_table')
                    ->default('property'),
                Forms\Components\DateTimePicker::make('date')
                    ->label('Dátum'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('path')
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Kép')
                    ->getStateUsing(fn (Gallery $record): string => $record->image_url)
                    ->height(60)
                    ->width(80),
                Tables\Columns\TextColumn::make('size')
                    ->label('Méret'),
                Tables\Columns\TextColumn::make('ord')
                    ->label('Sorrend')
                    ->sortable(),
                Tables\Columns\TextColumn::make('alt')
                    ->label('Alt text')
                    ->limit(30),
                Tables\Columns\IconColumn::make('image_exists')
                    ->label('Létezik')
                    ->getStateUsing(fn (Gallery $record): bool => $record->imageExists())
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['target_table'] = 'property';

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('view_image')
                    ->label('Megtekintés')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Gallery $record): string => $record->image_url)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('ord');
    }
}
