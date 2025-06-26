<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

final class FavoritesList extends Component
{
    public $favorites = [];

    public $favoriteProperties = [];

    public function mount()
    {
        $this->loadFavorites();
    }

    #[On('favorites-updated')]
    public function handleFavoritesUpdate()
    {
        $this->loadFavorites();
    }

    public function removeFromFavorites($propertyId)
    {
        $favorites = $this->getFavorites();
        $favorites = array_filter($favorites, fn ($id) => $id !== $propertyId);

        $this->dispatch('set-cookie', [
            'name' => 'property_favorites',
            'value' => json_encode(array_values($favorites)),
            'days' => 365,
        ]);

        $this->loadFavorites();

        // Notify other components
        $this->dispatch('favorites-updated', ['propertyId' => $propertyId, 'isFavorite' => false]);
    }

    public function render()
    {
        return view('livewire.favorites-list');
    }

    private function loadFavorites()
    {
        $this->favorites = $this->getFavorites();

        if (! empty($this->favorites)) {
            $this->favoriteProperties = Property::whereIn('id', $this->favorites)
                ->select('id', 'title', 'lead', 'slug', 'status')
                ->get()
                ->toArray();
        } else {
            $this->favoriteProperties = [];
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
}
