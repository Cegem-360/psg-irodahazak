<?php

namespace App\Filament\Imports;

use App\Models\Property;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PropertyImporter extends Importer
{
    protected static ?string $model = Property::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('title')
                ->rules(['max:255']),
            ImportColumn::make('status')
                ->rules(['max:255']),
            ImportColumn::make('content'),
            ImportColumn::make('date')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('meta_title')
                ->rules(['max:255']),
            ImportColumn::make('meta_title_en'),
            ImportColumn::make('meta_keywords'),
            ImportColumn::make('meta_keywords_en'),
            ImportColumn::make('meta_description'),
            ImportColumn::make('meta_description_en'),
            ImportColumn::make('epites_eve')
                ->rules(['max:255']),
            ImportColumn::make('osszterulet')
                ->rules(['max:255']),
            ImportColumn::make('jelenleg_kiado')
                ->rules(['max:255']),
            ImportColumn::make('max_berleti_dij')
                ->rules(['max:255']),
            ImportColumn::make('uzemeletetesi_dij')
                ->rules(['max:255']),
            ImportColumn::make('raktar_terulet')
                ->rules(['max:255']),
            ImportColumn::make('raktar_berleti_dij')
                ->rules(['max:255']),
            ImportColumn::make('parkolas')
                ->rules(['max:255']),
            ImportColumn::make('cim_irsz')
                ->rules(['max:255']),
            ImportColumn::make('cim_varos')
                ->rules(['max:255']),
            ImportColumn::make('cim_utca')
                ->rules(['max:255']),
            ImportColumn::make('cim_hazszam')
                ->rules(['max:255']),
            ImportColumn::make('cimke_json'),
            ImportColumn::make('service_json'),
            ImportColumn::make('maps_lat')
                ->rules(['max:255']),
            ImportColumn::make('maps_lng')
                ->rules(['max:255']),
            ImportColumn::make('osszterulet_addons')
                ->rules(['max:255']),
            ImportColumn::make('max_berleti_dij_addons')
                ->rules(['max:255']),
            ImportColumn::make('min_berleti_dij')
                ->rules(['max:255']),
            ImportColumn::make('min_berleti_dij_addons')
                ->rules(['max:255']),
            ImportColumn::make('raktar_terulet_addons')
                ->rules(['max:255']),
            ImportColumn::make('raktar_berleti_dij_addons')
                ->rules(['max:255']),
            ImportColumn::make('uzemeletetesi_dij_addons')
                ->rules(['max:255']),
            ImportColumn::make('min_parkolas_dija')
                ->rules(['max:255']),
            ImportColumn::make('min_parkolas_dija_addons')
                ->rules(['max:255']),
            ImportColumn::make('max_parkolas_dija')
                ->rules(['max:255']),
            ImportColumn::make('max_parkolas_dija_addons')
                ->rules(['max:255']),
            ImportColumn::make('kozos_teruleti_arany_addons')
                ->rules(['max:255']),
            ImportColumn::make('min_kiado')
                ->rules(['max:255']),
            ImportColumn::make('min_kiado_addons')
                ->rules(['max:255']),
            ImportColumn::make('jelenleg_kiado_addons')
                ->rules(['max:255']),
            ImportColumn::make('kodszam')
                ->rules(['max:255']),
            ImportColumn::make('en_content'),
            ImportColumn::make('min_berleti_idoszak')
                ->rules(['max:255']),
            ImportColumn::make('min_berleti_idoszak_addons')
                ->rules(['max:255']),
            ImportColumn::make('cim_utca_addons')
                ->rules(['max:255']),
            ImportColumn::make('lang')
                ->rules(['max:2']),
            ImportColumn::make('maps')
                ->rules(['max:255']),
            ImportColumn::make('elado_v_kiado')
                ->rules(['max:255']),
            ImportColumn::make('updated')
                ->rules(['max:10']),
            ImportColumn::make('test')
                ->rules(['max:255']),
            ImportColumn::make('egyeb'),
            ImportColumn::make('afa')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?Property
    {
        // return Property::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Property;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your property import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if (($failedRowsCount = $import->getFailedRowsCount()) !== 0) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
