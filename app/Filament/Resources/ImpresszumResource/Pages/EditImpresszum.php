<?php

namespace App\Filament\Resources\ImpresszumResource\Pages;

use App\Filament\Resources\ImpresszumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImpresszum extends EditRecord
{
    protected static string $resource = ImpresszumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
