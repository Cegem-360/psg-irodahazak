<?php

namespace App\Filament\Resources\ImpresszumResource\Pages;

use App\Filament\Resources\ImpresszumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImpresszums extends ListRecords
{
    protected static string $resource = ImpresszumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
