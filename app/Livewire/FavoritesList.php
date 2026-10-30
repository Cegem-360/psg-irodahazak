<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use App\Services\FavoriteProperties;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

final class FavoritesList extends Component
{
    /** @var Collection<int, Property> */
    public Collection $favoriteProperties;

    public int $favoriteCount = 0;

    public function mount(FavoriteProperties $favorites): void
    {
        $this->loadFavorites($favorites);
    }

    #[On('favorites-updated')]
    #[On('refresh-favorites')]
    public function refreshFavorites(FavoriteProperties $favorites): void
    {
        $this->loadFavorites($favorites);
    }

    public function render(): Factory|View
    {
        return view('livewire.favorites-list');
    }

    private function loadFavorites(FavoriteProperties $favorites): void
    {
        $this->favoriteProperties = $favorites->properties();
        $this->favoriteCount = $this->favoriteProperties->count();
    }
}
