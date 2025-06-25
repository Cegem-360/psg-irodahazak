<?php

<<<<<<< HEAD
declare(strict_types=1);

namespace App\Filament\Resources\ReferenceResource\Pages;

use App\Filament\Resources\ReferenceResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateReference extends CreateRecord
{
    protected static string $resource = ReferenceResource::class;

    public function getTitle(): string
    {
        return 'Referencia létrehozása';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
=======
namespace App\Filament\Resources\ReferenceResource\Pages;

use App\Filament\Resources\ReferenceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReference extends CreateRecord
{
    protected static string $resource = ReferenceResource::class;
>>>>>>> 0241347 (feat: Implement Reference resource with CRUD functionality and associated pages)
}
