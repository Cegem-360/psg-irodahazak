<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReferenceResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\ReferenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditReference extends EditRecord
{
    protected static string $resource = ReferenceResource::class;

    public function getTitle(): string
    {
        return 'Referencia szerkesztése';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Törlés'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
