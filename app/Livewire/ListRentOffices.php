<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property as Offices;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

final class ListRentOffices extends Component
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
            ->when($this->search, function ($query): void {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->active()
            ->count();
    }

    public function getOffices()
    {
        return Offices::query()
            ->when($this->search, function ($query): void {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->active()
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
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
        return view('livewire.list-rent-offices', [
            'offices' => $this->getOffices(),
        ]);
    }
}
