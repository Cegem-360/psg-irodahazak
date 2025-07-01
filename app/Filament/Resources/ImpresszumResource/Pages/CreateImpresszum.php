<?php

declare(strict_types=1);

namespace App\Filament\Resources\ImpresszumResource\Pages;

use App\Filament\Resources\ImpresszumResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateImpresszum extends CreateRecord
{
    protected static string $resource = ImpresszumResource::class;
}
