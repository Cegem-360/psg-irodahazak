<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\Property;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

final class PropertyExporter extends Exporter
{
    protected static ?string $model = Property::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('tags'),
            ExportColumn::make('services'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your property export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if (($failedRowsCount = $export->getFailedRowsCount()) !== 0) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
