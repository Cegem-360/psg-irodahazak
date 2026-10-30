<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\On;
use Livewire\Component;

final class FavoritesList extends Component
{
    /** @var Collection<int, Property> */
    public Collection $favoriteProperties;

    public int $favoriteCount = 0;

    public function mount(): void
    {
        $this->loadFavorites();
    }

    #[On('favorites-updated')]
    #[On('refresh-favorites')]
    public function refreshFavorites(): void
    {
        $this->loadFavorites();
    }

    public function openSendFavoritesModal(): void
    {
        $this->dispatch('openSendFavoritesModal')->to('favorites-send-modal');
    }

    public function render(): Factory|View
    {
        return view('livewire.favorites-list', [
            'favoriteProperties' => $this->favoriteProperties,
            'favoriteCount' => $this->favoriteCount,
        ]);
    }

    private function loadFavorites(): void
    {
        $favorites = $this->getFavorites();
        $this->favoriteCount = count($favorites);

        if ($favorites !== []) {
            $this->favoriteProperties = Property::query()->whereIn('id', $favorites)
                ->active()
                ->get();
        } else {
            $this->favoriteProperties = new Collection;
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
}
