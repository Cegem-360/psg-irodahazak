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

final class ListRentProperties extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'filament.pages.properties.rent';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $modelLabel = 'Ingatlan';

    protected static ?string $pluralModelLabel = 'Ingatlanok';

    protected static ?string $navigationGroup = 'Ingatlanok';

    protected static ?string $title = 'Kiadó ingatlanok';

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return Property::query()->rent();
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
                    ->url(fn (Property $record) => \Illuminate\Support\Facades\URL::temporarySignedRoute(
                        'property.pdf',
                        now()->addDays(21),
                        ['property' => $record->id]
                    ))
                    ->openUrlInNewTab()
                    ->requiresConfirmation()
                    ->modalHeading('PDF Generálás')
                    ->modalDescription('Biztosan szeretnéd generálni az ingatlan PDF adatlapját?')
                    ->modalSubmitActionLabel('PDF Megnyitás'),
            ], position: ActionsPosition::BeforeCells);
    }
}
