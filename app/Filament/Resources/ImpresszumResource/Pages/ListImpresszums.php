<?php

declare(strict_types=1);

namespace App\Filament\Resources\ImpresszumResource\Pages;

use App\Filament\Resources\ImpresszumResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

final class ListImpresszums extends ListRecords
{
    protected static string $resource = ImpresszumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
