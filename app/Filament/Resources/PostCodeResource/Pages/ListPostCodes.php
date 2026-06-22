<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostCodeResource\Pages;

use App\Filament\Resources\PostCodeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Override;

final class ListPostCodes extends ListRecords
{
    protected static string $resource = PostCodeResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
