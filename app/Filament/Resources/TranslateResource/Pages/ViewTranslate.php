<?php

namespace App\Filament\Resources\TranslateResource\Pages;

use App\Filament\Resources\TranslateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTranslate extends ViewRecord
{
    protected static string $resource = TranslateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
