<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReferenceResource\Pages;

use App\Filament\Resources\ReferenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListReferences extends ListRecords
{
    protected static string $resource = ReferenceResource::class;

    public function getTitle(): string
    {
        return 'Referenciák';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Új referencia'),
        ];
    }
}
