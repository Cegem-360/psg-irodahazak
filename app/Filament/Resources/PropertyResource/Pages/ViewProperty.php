<?php

declare(strict_types=1);

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewProperty extends ViewRecord
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_pdf')
                ->label('PDF Generálás')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->url(fn () => route('property.pdf', $this->record))
                ->openUrlInNewTab()
                ->requiresConfirmation()
                ->modalHeading('PDF Generálás')
                ->modalDescription('Biztosan szeretnéd generálni az ingatlan PDF adatlapját?')
                ->modalSubmitActionLabel('PDF Megnyitás'),
            EditAction::make(),
        ];
    }
}
