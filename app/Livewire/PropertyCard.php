<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use App\Services\FavoriteProperties;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * A property in the office lists: photo or mini gallery, map and phone buttons,
 * and the heart that adds it to the visitor's favorites.
 */
final class PropertyCard extends Component
{
    public Property $property;

    public bool $small = false;

    public bool $swiper = false;

    /** Whether to show the photos as a small carousel instead of the first photo only. */
    public bool $minicarousel = false;

    public bool $isFavorite = false;

    public function mount(FavoriteProperties $favorites): void
    {
        $this->isFavorite = $favorites->has($this->property->id);
    }

    public function showMapModal(): void
    {
        $this->dispatch('show-map-modal', title: $this->property->title, propertyId: $this->property->id);
    }

    public function showPhoneModal(): void
    {
        $this->dispatch('show-phone-modal', title: $this->property->title, propertyId: $this->property->id);
    }

    public function toggleFavorite(FavoriteProperties $favorites): void
    {
        $ids = $favorites->toggle($this->property->id);
        $this->isFavorite = in_array($this->property->id, $ids, true);

        // The browser sets the cookie right away too, so the counters update before the next page load.
        $this->dispatch('set-cookie', name: FavoriteProperties::COOKIE, value: json_encode($ids), days: 365);
        $this->dispatch('favorites-updated', propertyId: $this->property->id, isFavorite: $this->isFavorite);
    }

    #[On('favorites-updated')]
    public function handleFavoritesUpdate(int $propertyId, bool $isFavorite): void
    {
        if ($this->property->id === $propertyId) {
            $this->isFavorite = $isFavorite;
        }
    }

    public function render(): Factory|View
    {
        return view('livewire.property-card');
    }
}
