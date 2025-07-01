<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

final class IngatlanCard extends Component
{
    public $property;

    public $title;

    public $description;

    public $image;

    public $images = [];

    public $link;

    public $small = false;

    public $swiper = false;

    public $minicarousel = false;

    public $favoritestatus = false;

    protected $listeners = ['favorites-updated' => 'handleFavoritesUpdate'];

    public function mount(?Property $property, $title, $description = null, $image = null, $link = null, bool $small = false, $images = []): void
    {
        $this->images = $images; // Initialize images array
        $this->favoritestatus = false; // Initialize favorite status
        $this->property = $property;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->link = $link;
        $this->small = $small;

        $this->initializeFavoriteStatus();
    }

    public function showMapModal(): void
    {
        $this->dispatch('show-map-modal', [
            'propertyId' => $this->property?->id,
            'title' => $this->title,
        ]);
    }

    public function showPhoneModal(): void
    {
        $this->dispatch('show-phone-modal', [
            'propertyId' => $this->property?->id,
            'title' => $this->title,
        ]);
    }

    public function toggleFavorite(): void
    {
        if (! $this->property) {
            return;
        }

        $favorites = $this->getFavorites();
        $propertyId = $this->property->id;

        if ($this->favoritestatus) {
            // Remove from favorites
            $favorites = array_filter($favorites, fn ($id): bool => $id !== $propertyId);
            $this->favoritestatus = false;
        } else {
            // Add to favorites
            $favorites[] = $propertyId;
            $this->favoritestatus = true;
        }

        $this->saveFavorites($favorites);

        // Dispatch event for other components to listen
        $this->dispatch('favorites-updated', propertyId: $propertyId, favoritestatus: $this->favoritestatus);
    }

    public function handleFavoritesUpdate($propertyId, $favoritestatus): void
    {
        if ($this->property && $this->property->id === $propertyId) {
            $this->favoritestatus = $favoritestatus;
        }
    }

    public function render()
    {
        $this->favoritestatus = $this->favoritestatus ?? false;

        return view('livewire.ingatlan-card', [
            'favoritestatus' => $this->favoritestatus,
        ]);
    }

    private function initializeFavoriteStatus(): void
    {
        // Check if this property is in favorites
        if ($this->property) {
            $favorites = $this->getFavorites();
            $this->favoritestatus = in_array($this->property->id, $favorites);
        }
    }

    private function getFavorites(): array
    {
        try {
            $favorites = Cookie::get('property_favorites', '[]');
            $decoded = json_decode($favorites, true);

            return is_array($decoded) ? $decoded : [];
        } catch (Exception $exception) {
            return [];
        }
    }

    private function saveFavorites(array $favorites): void
    {
        // Remove duplicates and re-index
        $favorites = array_values(array_unique($favorites));

        // Set cookie using Laravel's Cookie facade
        Cookie::queue('property_favorites', json_encode($favorites), 60 * 24 * 365); // 365 days

        // Also dispatch event for immediate JS update
        $this->dispatch('set-cookie', [
            'name' => 'property_favorites',
            'value' => json_encode($favorites),
            'days' => 365,
        ]);

    }
}
