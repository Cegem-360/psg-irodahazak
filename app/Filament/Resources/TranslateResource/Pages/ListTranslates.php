<?php

namespace App\Filament\Resources\TranslateResource\Pages;

use App\Filament\Resources\TranslateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTranslates extends ListRecords
{
    protected static string $resource = TranslateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
