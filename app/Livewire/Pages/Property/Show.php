<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Property;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\Property;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class Show extends Component
{
    use RendersAsPage;

    public Property $property;

    /**
     * Three other active properties of the same type: from the same district
     * first, the nearest ones when the building has coordinates. The block is
     * the way on from the page of a building that is no longer offered.
     *
     * @return Collection<int, Property>
     */
    #[Computed]
    public function similarProperties(): Collection
    {
        $query = Property::query()->active()
            ->where('offer_type', $this->property->type())
            ->whereKeyNot($this->property->id)
            ->orderByRaw('district = ? desc', [(string) $this->property->district]);

        if (is_numeric($this->property->maps_lat) && is_numeric($this->property->maps_lng)) {
            $latitude = (float) $this->property->maps_lat;
            $longitude = (float) $this->property->maps_lng;

            // Squared distance on a flat map; a degree of longitude is about two thirds of a
            // degree of latitude at Budapest. Buildings without coordinates go last.
            $query->orderByRaw("coalesce(maps_lat, '') = '' or coalesce(maps_lng, '') = ''")
                ->orderByRaw('(maps_lat - ?) * (maps_lat - ?) + (maps_lng - ?) * (maps_lng - ?) * 0.45', [$latitude, $latitude, $longitude, $longitude]);
        } else {
            $query->inRandomOrder();
        }

        // Sort the ids only, then load the three winners: sorting whole rows drags the long
        // text columns into MySQL's on-disk temporary table, which once filled the host's disk.
        $ids = $query->limit(3)->pluck('id');

        return Property::query()->findMany($ids)
            ->sortBy(fn (Property $property): int => (int) $ids->search($property->id))
            ->values();
    }

    public function render(): View
    {
        $type = $this->property->type();

        return $this->asPage(view('pages.property.show', ['similarProperties' => $this->similarProperties]), [
            ['name' => $type->listTitle(), 'url' => localized_route($type->listRoute())],
            ['name' => $this->property->title, 'url' => $this->property->url()],
        ]);
    }
}
