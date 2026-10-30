<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class PropertyPhoneModal extends Component
{
    public bool $showModal = false;

    public ?Property $property = null;

    public string $title = '';

    #[On('show-phone-modal')]
    public function openModal(string $title = '', ?int $propertyId = null): void
    {
        $this->title = $title;

        $this->property = $propertyId === null ? null : Property::query()->active()->find($propertyId);

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['property', 'title']);
    }

    public function openContactModal(): void
    {
        $this->dispatch('open-request-quote-modal');
        $this->closeModal();
    }

    public function render(): Factory|View
    {
        return view('livewire.property-phone-modal');
    }
}
