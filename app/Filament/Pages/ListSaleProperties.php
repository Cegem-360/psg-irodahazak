<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Resources\PropertyResource;
use App\Models\Property;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;

final class ListSaleProperties extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'filament.pages.properties.sale';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Ingatlanok';

    protected static ?string $navigationLabel = 'Eladó ingatlanok';

    protected static ?string $title = 'Eladó ingatlanok';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {

                return Property::query()->sale();
            })

            ->columns([
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Cím')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kodszam')
                    ->label('Kódszám')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Dátum')
                    ->date('Y-m-d')
                    ->sortable(),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Új ingatlan hozzáadása')
                    ->icon('heroicon-o-plus')
                    ->color('primary')
                    ->url(PropertyResource::getUrl('create')),
            ])
            ->actions([

                EditAction::make()->url(fn (Property $record): string => PropertyResource::getUrl('edit', ['record' => $record])),
                Action::make('generate_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->url(fn (Property $record) => route('property.pdf', $record))
                    ->openUrlInNewTab()
                    ->requiresConfirmation()
                    ->modalHeading('PDF Generálás')
                    ->modalDescription('Biztosan szeretnéd generálni az ingatlan PDF adatlapját?')
                    ->modalSubmitActionLabel('PDF Megnyitás'),
            ], position: ActionsPosition::BeforeCells);
    }
}
