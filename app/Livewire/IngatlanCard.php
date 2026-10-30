<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\On;
use Livewire\Component;

final class IngatlanCard extends Component
{
    public ?Property $property = null;

    public string $title = '';

    public ?string $description = null;

    public ?string $image = null;

    /** @var list<string> Gallery image paths for the mini carousel */
    public array $images = [];

    public ?string $link = null;

    public bool $small = false;

    public bool $swiper = false;

    public bool $minicarousel = false;

    public bool $favoritestatus = false;

    /**
     * @param  iterable<int, string>  $images
     */
    public function mount(?Property $property, ?string $title, ?string $description = null, ?string $image = null, ?string $link = null, bool $small = false, iterable $images = []): void
    {
        $this->images = collect($images)->values()->all();
        $this->favoritestatus = false; // Initialize favorite status
        $this->property = $property;
        $this->title = (string) $title;
        $this->description = $description;
        $this->image = $image;
        $this->link = $link;
        $this->small = $small;

        $this->initializeFavoriteStatus();
    }

    public function showMapModal(): void
    {
        $this->dispatch('show-map-modal', title: $this->title, propertyId: $this->property?->id);
    }

    public function showPhoneModal(): void
    {
        $this->dispatch('show-phone-modal', title: $this->title, propertyId: $this->property?->id);
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

    #[On('favorites-updated')]
    public function handleFavoritesUpdate(int $propertyId, bool $favoritestatus): void
    {
        if ($this->property && $this->property->id === $propertyId) {
            $this->favoritestatus = $favoritestatus;
        }
    }

    public function render(): Factory|View
    {
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
        } catch (Exception) {
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
