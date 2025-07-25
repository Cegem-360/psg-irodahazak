<?php

declare(strict_types=1);

namespace App\Filament\Resources\PostCodeResource\Pages;

use App\Filament\Resources\PostCodeResource;
use Filament\Resources\Pages\CreateRecord;

final class CreatePostCode extends CreateRecord
{
    protected static string $resource = PostCodeResource::class;
}
