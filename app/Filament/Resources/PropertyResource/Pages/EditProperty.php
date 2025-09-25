<?php

declare(strict_types=1);

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

final class EditProperty extends EditRecord
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_pdf')
                ->label('PDF Generálás')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->url(fn () => URL::temporarySignedRoute(
                    Session::get('locale') === 'en' ? 'en.property.pdf' : 'property.pdf',
                    now()->addDays(21),
                    ['property' => $this->record->id]
                ))
                ->openUrlInNewTab()
                ->requiresConfirmation()
                ->modalHeading('PDF Generálás')
                ->modalDescription('Biztosan szeretnéd generálni az ingatlan PDF adatlapját?')
                ->modalSubmitActionLabel('PDF Megnyitás'),
            DeleteAction::make(),
        ];
    }
}
