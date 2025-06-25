<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

final class PropertyMapModal extends Component
{
    public $showModal = false;

    public $property = null;

    public $title = '';

    protected $listeners = ['show-map-modal' => 'openModal'];

    public function openModal($title, $propertyId = null)
    {
        $this->title = $title;

        // Backend-en lekérjük a property adatokat
        if ($propertyId) {
            $this->property = Property::find($propertyId);
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['property', 'title']);
    }

    public function render()
    {
        return view('livewire.property-map-modal');
    }
}
