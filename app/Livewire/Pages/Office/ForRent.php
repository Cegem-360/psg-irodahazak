<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Office;

use App\Livewire\Concerns\ProvidesOfficeSearchForm;
use App\Livewire\Concerns\RendersAsPage;
use App\Livewire\Office\RentListing;
use App\Models\Property;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class ForRent extends Component
{
    use ProvidesOfficeSearchForm;
    use RendersAsPage;

    public function metaDescription(): string
    {
        return __('Offices for rent in Budapest from :count office buildings: rent 7–28 EUR/m²/month, operating fee, parking and minimum area per building. Quote within 24 hours.', [
            'count' => Property::query()->rent()->active()->count(),
        ]);
    }

    /**
     * @return Collection<int, Property>
     */
    #[Computed]
    public function listedOffices(): Collection
    {
        return RentListing::listedOffices(null, Category::ITEM_LIST_LIMIT);
    }

    public function render(): View
    {
        return $this->asPage(view('pages.office.for-rent'), [['name' => __('Rental Offices'), 'url' => localized_route('kiado-irodak')]]);
    }
}
