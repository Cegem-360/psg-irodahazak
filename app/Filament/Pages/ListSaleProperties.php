<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Resources\PropertyResource;
use App\Models\Property;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use UnitEnum;

final class ListSaleProperties extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.properties.sale';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string|UnitEnum|null $navigationGroup = 'Ingatlanok';

    protected static ?string $navigationLabel = 'Eladó ingatlanok';

    protected static ?string $title = 'Eladó ingatlanok';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Property::query()->sale())

            ->columns([
                TextColumn::make('status')
                    ->label('Státusz')
                    ->badge()
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
                    ->icon(Heroicon::OutlinedPlus)
                    ->color('primary')
                    ->url(PropertyResource::getUrl('create')),
            ])
            ->recordActions([
                EditAction::make()->url(fn (Property $record): string => PropertyResource::getUrl('edit', ['record' => $record]), shouldOpenInNewTab: true),
                Action::make('generate_pdf')
                    ->label('PDF')
                    ->icon(Heroicon::OutlinedDocumentArrowDown)
                    ->color('success')
                    ->url(fn (Property $record) => URL::temporarySignedRoute(
                        Session::get('locale') === 'en' ? 'en.property.pdf' : 'property.pdf',
                        now()->addDays(21),
                        ['property' => $record->id]
                    ))
                    ->openUrlInNewTab()
                    ->requiresConfirmation()
                    ->modalHeading('PDF Generálás')
                    ->modalDescription('Biztosan szeretnéd generálni az ingatlan PDF adatlapját?')
                    ->modalSubmitActionLabel('PDF Megnyitás'),
            ], position: RecordActionsPosition::BeforeCells);
    }
}
