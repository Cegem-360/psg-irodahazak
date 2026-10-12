<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class PropertyMapModal extends Component
{
    public $showModal = false;

    public $property;

    public $title = '';

    protected $listeners = ['show-map-modal' => 'openModal'];

    public function openModal($title, $propertyId = null): void
    {
        $this->title = $title;

        // Backend-en lekérjük a property adatokat
        if ($propertyId) {
            $this->property = Property::query()->find($propertyId);
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['property', 'title']);
    }

    public function render(): Factory|View
    {
        return view('livewire.property-map-modal');
    }
}
