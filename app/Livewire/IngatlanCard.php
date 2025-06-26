<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

final class IngatlanCard extends Component
{
    public $property;

    public $title;

    public $description;

    public $image;

    public $link;

    public $small = false;

    public $swiper = false;

    public function mount(?Property $property = null, $title = null, $description = null, $image = null, $link = null, $small = false)
    {
        $this->property = $property;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->link = $link;
        $this->small = $small;
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

    public function render()
    {
        return view('livewire.ingatlan-card');
    }
}
