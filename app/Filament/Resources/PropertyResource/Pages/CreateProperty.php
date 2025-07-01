<?php

declare(strict_types=1);

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateProperty extends CreateRecord
{
    protected static string $resource = PropertyResource::class;
}
