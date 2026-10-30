<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property as Offices;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

final class ListSaleOffices extends Component
{
    use WithPagination;

    public string $search = '';

    public string $sortField = 'title';

    public string $sortDirection = 'asc';

    public int $perPage = 6;

    public int $totalOffices = 0;

    /** @var array<string, mixed> Per-request memo of getOffices(), keyed by the list state. */
    private array $officesMemo = [];

    public function mount(): void
    {
        $this->updateTotalOffices();
    }

    public function updateTotalOffices(): void
    {
        $this->totalOffices = $this->getOffices()->total();
    }

    /**
     * The current page of offices. Memoised per state, because the count, the list,
     * the pagination and the map markers all read it during one request.
     */
    public function getOffices()
    {
        $state = serialize([$this->search, $this->sortField, $this->sortDirection, $this->perPage, $this->getPage()]);

        return $this->officesMemo[$state] ??= Offices::query()
            ->with('images') // Eager load images
            ->when($this->search, function ($query): void {
                $query->searchText($this->search);
            })
            ->sale()
            ->active()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function getOfficesForMap()
    {
        // Transform the current page of offices to map format (coordinates will be geocoded on frontend)
        return $this->getOffices()->getCollection()
            ->map(function ($office): array {
                // Build full address for geocoding
                $addressParts = array_filter([
                    $office->cim_irsz,
                    $office->cim_varos,
                    $office->cim_utca,
                    $office->cim_hazszam,
                ]);
                $fullAddress = implode(' ', $addressParts);

                return [
                    'id' => $office->id,
                    'title' => $office->title,
                    'address' => $fullAddress,
                    'postal_code' => $office->cim_irsz ?? '',
                    'city' => $office->cim_varos ?? '',
                    'street' => $office->cim_utca ?? '',
                    'house_number' => $office->cim_hazszam ?? '',
                    'rent' => ($office->min_berleti_dij ?? '').' - '.($office->max_berleti_dij ?? '').' '.($office->max_berleti_dij_addons ?? ''),
                    'operating_fee' => (translate_value($office->uzemeletetesi_dij) ?? '').' '.($office->uzemeletetesi_dij_addons ?? ''),
                    'url' => route('properties.show', ['property' => $office]),

                ];
            })
            ->values(); // Reset array keys to ensure clean JSON
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->updateTotalOffices();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    #[On('refreshList')]
    public function refreshList(): void
    {
        $this->updateTotalOffices();
        $this->resetPage();
    }

    public function render(): Factory|View
    {
        return view('livewire.list-sale-offices', [
            'offices' => $this->getOffices(),
        ]);
    }
}
