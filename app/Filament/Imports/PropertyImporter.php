<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Models\Property;
use App\Models\Service;
use App\Models\Tag;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

final class PropertyImporter extends Importer
{
    protected static ?string $model = Property::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->label('ID'),
            ImportColumn::make('tags'),
            ImportColumn::make('services'),

        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your property import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if (($failedRowsCount = $import->getFailedRowsCount()) !== 0) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }

    public function resolveRecord(): ?Property
    {
        /* foreach ($this->data['tags'] as $tag) {
            Tag::firstOrCreate([
                'name' => $tag,
            ]);
        }
        foreach (($this->data['services']) as $service) {
            Service::firstOrCreate([
                'name' => $service,
            ]);
        }
 */
        return Property::query()
            ->where('id', $this->data['id'])
            ->first();
    }
}
