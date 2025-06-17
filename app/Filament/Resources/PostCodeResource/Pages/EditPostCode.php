<?php

namespace App\Filament\Resources\PostCodeResource\Pages;

use App\Filament\Resources\PostCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostCode extends EditRecord
{
    protected static string $resource = PostCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
