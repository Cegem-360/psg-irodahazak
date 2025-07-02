<?php

declare(strict_types=1);

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Resources\Pages\ListRecords;

final class ListSaleProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getTableQuery(): ?\Illuminate\Database\Eloquent\Builder
    {
        return self::getResource()::getEloquentQuery()->where('elado_v_kiado', 'elado-iroda');
    }
}
