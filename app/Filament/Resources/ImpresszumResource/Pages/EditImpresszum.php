<?php

declare(strict_types=1);

namespace App\Filament\Resources\ImpresszumResource\Pages;

use App\Filament\Resources\ImpresszumResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditImpresszum extends EditRecord
{
    protected static string $resource = ImpresszumResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
