<?php

declare(strict_types=1);

namespace App\Filament\Resources\AboutUsResource\Pages;

use App\Filament\Resources\AboutUsResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateAboutUs extends CreateRecord
{
    protected static string $resource = AboutUsResource::class;
}
