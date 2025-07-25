<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactPageResource\Pages;

use App\Filament\Resources\ContactPageResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateContactPage extends CreateRecord
{
    protected static string $resource = ContactPageResource::class;
}
