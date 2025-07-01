<?php

declare(strict_types=1);

namespace App\Filament\Resources\TranslateResource\Pages;

use App\Filament\Resources\TranslateResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateTranslate extends CreateRecord
{
    protected static string $resource = TranslateResource::class;
}
