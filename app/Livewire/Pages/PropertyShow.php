<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\Property;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class PropertyShow extends Component
{
    use RendersAsPage;

    public Property $property;

    public function mount(): void
    {
        // Inactive listings stay viewable for signed-in admins, who use the page as a preview
        abort_unless($this->property->isActive() || auth()->check(), 404);
    }

    /**
     * Three other active properties of the same type, from the same district when there are enough.
     *
     * @return Collection<int, Property>
     */
    #[Computed]
    public function similarProperties(): Collection
    {
        return Property::query()->active()
            ->where('offer_type', $this->property->type())
            ->whereKeyNot($this->property->id)
            ->orderByRaw('district = ? desc', [(string) $this->property->district])
            ->inRandomOrder()
            ->limit(3)
            ->get();
    }

    public function render(): View
    {
        $type = $this->property->type();

        return $this->asPage(view('properties.show', ['similarProperties' => $this->similarProperties]), [
            ['name' => $type->listTitle(), 'url' => localized_route($type->listRoute())],
            ['name' => $this->property->title, 'url' => $this->property->url()],
        ]);
    }
}
