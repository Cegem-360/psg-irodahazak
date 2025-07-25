<?php

declare(strict_types=1);

namespace App\Filament\Imports;

use App\Models\Page;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

final class PageImporter extends Importer
{
    protected static ?string $model = Page::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('title')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('url')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('ord')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('template')
                ->requiredMapping()
                ->rules(['required', 'max:150']),
            ImportColumn::make('parent_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('need_login')
                ->requiredMapping()
                ->rules(['max:25']),
            ImportColumn::make('show_menu')
                ->requiredMapping()
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('date')
                ->requiredMapping()
                ->rules(['datetime']),
            ImportColumn::make('type')->requiredMapping()
                ->rules(['max:100']),
            ImportColumn::make('content_json')
                ->requiredMapping(),
            ImportColumn::make('title_url')
                ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('sow_just_super_admin')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('content_category_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your page import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if (($failedRowsCount = $import->getFailedRowsCount()) !== 0) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }

    public function resolveRecord(): ?Page
    {
        // return Page::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Page;
    }
}
