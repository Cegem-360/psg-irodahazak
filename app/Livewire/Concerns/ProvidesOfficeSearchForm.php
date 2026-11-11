<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use App\Models\Property;

/**
 * Pages that show <x-office-search-form>: the data the form's script needs.
 */
trait ProvidesOfficeSearchForm
{
    /**
     * Read by resources/js/office-search-form.js: the office buildings for the
     * name search and the texts of the district picker.
     *
     * @return array{offices: list<array{title: string, city: string}>, i18n: array<string, string>}
     */
    public function searchFormConfig(): array
    {
        return [
            'offices' => Property::query()->rent()->active()->orderBy('title')->get(['title', 'postal_code'])
                ->map(fn (Property $office): array => ['title' => $office->title, 'city' => $office->postal_code ?? 'Budapest'])
                ->values()
                ->all(),
            'i18n' => [
                'selectDistricts' => __('Select Districts'),
                'districtsSelected' => __(':count districts selected'),
                'allOfficeBuildings' => __('All Office Buildings'),
                'officeBuildingName' => __('modal.office_building_name'),
            ],
        ];
    }
}
