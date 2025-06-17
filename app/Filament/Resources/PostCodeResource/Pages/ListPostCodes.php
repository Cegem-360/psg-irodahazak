<?php

namespace App\Filament\Resources\PostCodeResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\PostCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostCodes extends ListRecords
{
    protected static string $resource = PostCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
