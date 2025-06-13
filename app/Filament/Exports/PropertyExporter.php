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
            ExportColumn::make('title'),
            ExportColumn::make('status'),
            ExportColumn::make('content'),
            ExportColumn::make('date'),
            ExportColumn::make('meta_title'),
            ExportColumn::make('meta_title_en'),
            ExportColumn::make('meta_keywords'),
            ExportColumn::make('meta_keywords_en'),
            ExportColumn::make('meta_description'),
            ExportColumn::make('meta_description_en'),
            ExportColumn::make('epites_eve'),
            ExportColumn::make('osszterulet'),
            ExportColumn::make('jelenleg_kiado'),
            ExportColumn::make('max_berleti_dij'),
            ExportColumn::make('uzemeletetesi_dij'),
            ExportColumn::make('raktar_terulet'),
            ExportColumn::make('raktar_berleti_dij'),
            ExportColumn::make('parkolas'),
            ExportColumn::make('cim_irsz'),
            ExportColumn::make('cim_varos'),
            ExportColumn::make('cim_utca'),
            ExportColumn::make('cim_hazszam'),
            ExportColumn::make('cimke_json')
                ->formatStateUsing(fn (string $state): string => json_encode(json_decode($state), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)),
            ExportColumn::make('service_json')
                ->formatStateUsing(fn (string $state): string => json_encode(json_decode($state), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)),
            ExportColumn::make('maps_lat'),
            ExportColumn::make('maps_lng'),
            ExportColumn::make('osszterulet_addons'),
            ExportColumn::make('max_berleti_dij_addons'),
            ExportColumn::make('min_berleti_dij'),
            ExportColumn::make('min_berleti_dij_addons'),
            ExportColumn::make('raktar_terulet_addons'),
            ExportColumn::make('raktar_berleti_dij_addons'),
            ExportColumn::make('uzemeletetesi_dij_addons'),
            ExportColumn::make('min_parkolas_dija'),
            ExportColumn::make('min_parkolas_dija_addons'),
            ExportColumn::make('max_parkolas_dija'),
            ExportColumn::make('max_parkolas_dija_addons'),
            ExportColumn::make('kozos_teruleti_arany_addons'),
            ExportColumn::make('min_kiado'),
            ExportColumn::make('min_kiado_addons'),
            ExportColumn::make('jelenleg_kiado_addons'),
            ExportColumn::make('kodszam'),
            ExportColumn::make('en_content'),
            ExportColumn::make('min_berleti_idoszak'),
            ExportColumn::make('min_berleti_idoszak_addons'),
            ExportColumn::make('cim_utca_addons'),
            ExportColumn::make('lang'),
            ExportColumn::make('maps'),
            ExportColumn::make('elado_v_kiado'),
            ExportColumn::make('updated'),
            ExportColumn::make('test'),
            ExportColumn::make('egyeb'),
            ExportColumn::make('afa'),
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
