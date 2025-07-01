<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContentResource\Pages;

use App\Filament\Resources\ContentResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateContent extends CreateRecord
{
    protected static string $resource = ContentResource::class;
}
