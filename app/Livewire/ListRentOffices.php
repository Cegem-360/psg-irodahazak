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

    public function mount($queryParams = []): void
    {
        // Initialize filters from queryParams if provided, otherwise from request parameters
        $this->search = $queryParams['search'] ?? request('search', '');
        $this->districts = $queryParams['districts'] ?? request('districts', '');
        $this->district = $queryParams['district'] ?? request('district', '');
        $this->officeName = $queryParams['office_name'] ?? request('office_name', '');
        $this->areaMin = $queryParams['area_min'] ?? request('area_min', '');
        $this->areaMax = $queryParams['area_max'] ?? request('area_max', '');
        $this->priceMin = $queryParams['price_min'] ?? request('price_min', '');
        $this->priceMax = $queryParams['price_max'] ?? request('price_max', '');
        $this->includeAgglomeration = $queryParams['include_agglomeration'] ?? request('include_agglomeration', false);

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
            $searchTerms = explode(' ', mb_trim($this->search));
            $searchTerms = array_filter($searchTerms);

            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->where(function ($subQ) use ($term) {
                        $subQ->where('title', 'like', '%'.$term.'%')
                            ->orWhere('content', 'like', '%'.$term.'%')
                            ->orWhere('lead', 'like', '%'.$term.'%');
                    });
                }
            });
        }

        // Apply district filter (single district for backward compatibility)
        if ($this->district) {
            $query->where(function ($q) {
                $districtNumber = $this->district;
                $districtNum = (int) $districtNumber;
                $postalCode = '1'.mb_str_pad((string) $districtNum, 2, '0', STR_PAD_LEFT);

                // Roman numerals mapping
                $romanNumerals = [
                    1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
                    6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
                    11 => 'XI', 12 => 'XII', 13 => 'XIII', 14 => 'XIV', 15 => 'XV',
                    16 => 'XVI', 17 => 'XVII', 18 => 'XVIII', 19 => 'XIX', 20 => 'XX',
                    21 => 'XXI', 22 => 'XXII', 23 => 'XXIII',
                ];

                $romanDistrict = $romanNumerals[$districtNum] ?? $districtNumber;

                $q->where('cim_varos', 'like', '%'.$districtNumber.'. kerület%')
                    ->orWhere('cim_varos', 'like', '%'.$romanDistrict.'. kerület%')
                    ->orWhere('cim_varos', 'like', '%Budapest '.$districtNumber.'%')
                    ->orWhere('cim_irsz', 'like', $postalCode.'%');
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
                            $districtNum = (int) $district;
                            $postalCode = '1'.mb_str_pad((string) $districtNum, 2, '0', STR_PAD_LEFT);

                            // Roman numerals mapping for Hungarian districts
                            $romanNumerals = [
                                1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
                                6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X',
                                11 => 'XI', 12 => 'XII', 13 => 'XIII', 14 => 'XIV', 15 => 'XV',
                                16 => 'XVI', 17 => 'XVII', 18 => 'XVIII', 19 => 'XIX', 20 => 'XX',
                                21 => 'XXI', 22 => 'XXII', 23 => 'XXIII',
                            ];

                            $romanDistrict = $romanNumerals[$districtNum] ?? $district;

                            // Match different possible formats:
                            $subQ->where('cim_varos', 'like', '%'.$district.'. kerület%')
                                ->orWhere('cim_varos', 'like', '%'.$romanDistrict.'. kerület%')
                                ->orWhere('cim_varos', 'like', '%Budapest '.$district.'%')
                                ->orWhere('cim_varos', 'like', '%'.$district.'.kerület%')
                                ->orWhere('cim_varos', 'like', '%'.$romanDistrict.'.kerület%')
                                ->orWhere('cim_irsz', 'like', $postalCode.'%')
                                ->orWhere('cim_utca', 'like', '%'.$district.'. kerület%')
                                ->orWhere('cim_utca', 'like', '%'.$romanDistrict.'. kerület%')
                                ->orWhere('title', 'like', '%'.$district.'. kerület%')
                                ->orWhere('title', 'like', '%'.$romanDistrict.'. kerület%')
                                ->orWhere('content', 'like', '%'.$district.'. kerület%')
                                ->orWhere('content', 'like', '%'.$romanDistrict.'. kerület%');
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
