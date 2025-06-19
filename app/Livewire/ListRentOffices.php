<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property as Offices;
use Livewire\Component;
use Livewire\WithPagination;
use Log;

final class ListRentOffices extends Component
{
    use WithPagination;

    public $search = '';

    public $districts = '';

    public $district = '';

    public $officeName = '';

    public $areaMin = '';

    public $areaMax = '';

    public $priceMin = '';

    public $priceMax = '';

    public $includeAgglomeration = false;

    public $sortField = 'title';

    public $sortDirection = 'asc';

    public $perPage = 6;

    public $totalOffices;

    public $selectedOffice;

    public $showModal = false;

    public $officeDetails = [];

    public function mount(): void
    {
        // Initialize filters from request parameters
        $this->search = request('search', '');
        $this->districts = request('districts', '');
        $this->district = request('district', '');
        $this->officeName = request('office_name', '');
        $this->areaMin = request('area_min', '');
        $this->areaMax = request('area_max', '');
        $this->priceMin = request('price_min', '');
        $this->priceMax = request('price_max', '');
        $this->includeAgglomeration = request('include_agglomeration', false);

        $this->updateTotalOffices();
    }

    public function updateTotalOffices(): void
    {
        $this->totalOffices = $this->buildQuery()->count();
    }

    public function getOffices()
    {
        return $this->buildQuery()
            ->with('images') // Eager load images
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
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

    public function render()
    {
        return view('livewire.list-rent-offices', [
            'offices' => $this->getOffices(),
        ]);
    }

    private function buildQuery()
    {
        $query = Offices::query()
            ->rent()
            ->active();

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('content', 'like', '%'.$this->search.'%')
                    ->orWhere('lead', 'like', '%'.$this->search.'%');
            });
        }

        // Apply district filter (single district for backward compatibility)
        if ($this->district) {
            $query->where(function ($q) {
                $districtNumber = $this->district;
                $q->where('cim_varos', 'like', '%'.$districtNumber.'. kerület%')
                    ->orWhere('cim_varos', 'like', '%Budapest '.$districtNumber.'%')
                    ->orWhere('cim_varos', 'like', '%1'.mb_str_pad($districtNumber, 2, '0', STR_PAD_LEFT).'%');
            });
        }

        // Apply multiple districts filter
        if ($this->districts) {
            // Debug logging
            Log::info('Districts filter applied with value: '.$this->districts);

            $selectedDistricts = explode(',', $this->districts);
            $selectedDistricts = array_filter(array_map('trim', $selectedDistricts));

            Log::info('Processed districts: ', $selectedDistricts);

            if (! empty($selectedDistricts)) {
                $query->where(function ($q) use ($selectedDistricts) {
                    foreach ($selectedDistricts as $district) {
                        $q->orWhere(function ($subQ) use ($district) {
                            $districtNum = (int) $district; // Ensure it's an integer
                            $postalCode = '1'.mb_str_pad((string) $districtNum, 2, '0', STR_PAD_LEFT);

                            // Match different possible formats:
                            $subQ->where('cim_varos', 'like', '%'.$district.'. kerület%')
                                ->orWhere('cim_varos', 'like', '%Budapest '.$district.'%')
                                ->orWhere('cim_varos', 'like', '%'.$district.'.kerület%') // without space
                                ->orWhere('cim_irsz', 'like', $postalCode.'%')
                                ->orWhere('cim_utca', 'like', '%'.$district.'. kerület%')
                                ->orWhere('title', 'like', '%'.$district.'. kerület%')
                                ->orWhere('content', 'like', '%'.$district.'. kerület%');
                        });
                    }
                });
            }
        }

        // Apply office name filter
        if ($this->officeName) {
            $query->where('title', 'like', '%'.$this->officeName.'%');
        }

        // Apply area range filter
        if ($this->areaMin && $this->areaMax) {
            $query->whereBetween('total_area', [$this->areaMin, $this->areaMax]);
        } elseif ($this->areaMin) {
            $query->where('total_area', '>=', $this->areaMin);
        } elseif ($this->areaMax) {
            $query->where('total_area', '<=', $this->areaMax);
        }

        // Apply price range filter
        if ($this->priceMin && $this->priceMax) {
            $query->whereBetween('max_berleti_dij', [$this->priceMin, $this->priceMax]);
        } elseif ($this->priceMin) {
            $query->where('max_berleti_dij', '>=', $this->priceMin);
        } elseif ($this->priceMax) {
            $query->where('max_berleti_dij', '<=', $this->priceMax);
        }

        return $query;
    }
}
