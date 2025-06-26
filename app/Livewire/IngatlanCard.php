<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

final class IngatlanCard extends Component
{
    public $property;

    public $title;

    public $description;

    public $image;

    public $link;

    public $small = false;

    public $isFavorite = false;

    public function mount(?Property $property = null, $title = null, $description = null, $image = null, $link = null, bool $small = false)
    {
        $this->property = $property;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->link = $link;
        $this->small = $small;

        $this->initializeFavoriteStatus();
    }

    public function showMapModal()
    {
        $this->dispatch('show-map-modal', [
            'propertyId' => $this->property?->id,
            'title' => $this->title,
        ]);
    }

    public function showPhoneModal()
    {
        $this->dispatch('show-phone-modal', [
            'propertyId' => $this->property?->id,
            'title' => $this->title,
        ]);
    }

    public function toggleFavorite()
    {
        if (! $this->property) {
            return;
        }

        $favorites = $this->getFavorites();
        $propertyId = $this->property->id;

        if ($this->isFavorite) {
            // Remove from favorites
            $favorites = array_filter($favorites, fn ($id) => $id !== $propertyId);
            $this->isFavorite = false;
        } else {
            // Add to favorites
            $favorites[] = $propertyId;
            $this->isFavorite = true;
        }

        $this->saveFavorites($favorites);

        // Dispatch event for other components to listen
        $this->dispatch('favorites-updated', ['propertyId' => $propertyId, 'isFavorite' => $this->isFavorite]);
    }

    #[On('favorites-updated')]
    public function handleFavoritesUpdate($propertyId, $isFavorite)
    {
        if ($this->property && $this->property->id === $propertyId) {
            $this->isFavorite = $isFavorite;
        }
    }

    public function render()
    {
        return view('livewire.ingatlan-card');
    }

    private function initializeFavoriteStatus(): void
    {
        // Check if this property is in favorites
        if ($this->property) {
            $favorites = $this->getFavorites();
            $this->isFavorite = in_array($this->property->id, $favorites);
        }
    }

    private function getFavorites(): array
    {
        try {
            $favorites = $_COOKIE['property_favorites'] ?? '[]';
            $decoded = json_decode($favorites, true);

            return is_array($decoded) ? $decoded : [];
        } catch (Exception $e) {
            return [];
        }
    }

    private function saveFavorites(array $favorites): void
    {
        // Remove duplicates and re-index
        $favorites = array_values(array_unique($favorites));

        // Set cookie via JavaScript (since we can't set cookies directly in Livewire)
        $this->dispatch('set-cookie', [
            'name' => 'property_favorites',
            'value' => json_encode($favorites),
            'days' => 365,
        ]);
    }
}
