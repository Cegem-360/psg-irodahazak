<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property as Offices;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

final class ListSaleOffices extends Component
{
    use WithPagination;

    public $search = '';

    public $sortField = 'title';

    public $sortDirection = 'asc';

    public $perPage = 6;

    public $totalOffices;

    public $selectedOffice;

    public $showModal = false;

    public $officeDetails = [];

    public function mount(): void
    {
        $this->updateTotalOffices();
    }

    public function updateTotalOffices(): void
    {
        $this->totalOffices = Offices::query()
            ->sale()
            ->when($this->search, function ($query): void {
                $query->searchText($this->search);
            })
            ->active()
            ->count();
    }

    public function getOffices()
    {
        return Offices::query()
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
        // Get only the currently paginated offices
        $paginatedOffices = Offices::query()
            ->with('images')
            ->when($this->search, function ($query): void {
                $query->searchText($this->search);
            })
            ->sale()
            ->active()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Transform all offices to map format (coordinates will be geocoded on frontend)
        return $paginatedOffices->getCollection()
            ->map(function ($office) {
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
                    'operating_fee' => ($office->uzemeletetesi_dij ?? '').' '.($office->uzemeletetesi_dij_addons ?? ''),
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

    public function sortBy($field): void
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

    public function render()
    {
        return view('livewire.list-sale-offices', [
            'offices' => $this->getOffices(),
        ]);
    }
}
