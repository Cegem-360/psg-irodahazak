<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostCodeResource\Pages;

use App\Filament\Resources\PostCodeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

final class EditPostCode extends EditRecord
{
    protected static string $resource = PostCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
