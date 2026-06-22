<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReferenceResource\Pages;

use App\Filament\Resources\ReferenceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Override;

final class EditReference extends EditRecord
{
    protected static string $resource = ReferenceResource::class;

    #[Override]
    public function getTitle(): string
    {
        return 'Referencia szerkesztése';
    }

    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Törlés'),
        ];
    }

    #[Override]
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
