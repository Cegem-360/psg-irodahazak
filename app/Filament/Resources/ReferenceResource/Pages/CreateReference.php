<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReferenceResource\Pages;

use App\Filament\Resources\ReferenceResource;
use Filament\Resources\Pages\CreateRecord;
use Override;

final class CreateReference extends CreateRecord
{
    protected static string $resource = ReferenceResource::class;

    #[Override]
    public function getTitle(): string
    {
        return 'Referencia létrehozása';
    }

    #[Override]
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
