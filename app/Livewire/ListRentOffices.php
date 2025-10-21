<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Category;
use App\Models\Property as Offices;
use Livewire\Component;
use Livewire\WithPagination;

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

    public null|int|string $min_rent = '';

    public ?string $min_rent_addons = '';

    public ?string $title;

    public ?string $category = null;

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
        $this->category = $queryParams['category'] ?? request('category', null);
        $this->min_rent = $queryParams['min_rent'] ?? request('min_rent', null);
        $this->min_rent_addons = $queryParams['min_rent_addons'] ?? request('min_rent_addons', null);

        if ($this->officeName) {
            $office = Offices::where('title', $this->officeName)->first();

            $this->redirect(localized_route('properties.show', ['property' => $office->slug]));
        }

        $this->updateTotalOffices();

        $this->title = $queryParams['title'] ?? request('title', __('page.title.offices_for_rent'));

    }

    public function updateTotalOffices(): void
    {
        $this->totalOffices = $this->buildQuery()->count();
    }

    public function getOffices()
    {

        return $this->buildQuery()
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

        $offices = $this->getOffices();

        return view('livewire.list-rent-offices', [
            'offices' => $offices,
        ]);
    }

    public function getOfficesForMap()
    {
        // Get only the currently paginated offices that have coordinates
        $paginatedOffices = $this->getOffices();

        // Filter out offices without coordinates and transform to map format
        return $paginatedOffices->getCollection()
            ->whereNotNull('maps_lat')
            ->whereNotNull('maps_lng')
            ->where('maps_lat', '!=', '')
            ->where('maps_lng', '!=', '')
            ->map(function ($office): array {
                return [
                    'id' => $office->id,
                    'title' => $office->title,
                    'lat' => (float) $office->maps_lat,
                    'lng' => (float) $office->maps_lng,
                    'address' => $office->cim_irsz.' '.$office->cim_varos.($office->district ? ' '.$office->district.'. kerület' : '').', '.$office->cim_utca.' '.$office->cim_hazszam,
                    'rent' => ($office->min_berleti_dij ?? '').' - '.($office->max_berleti_dij ?? '').' '.($office->max_berleti_dij_addons ?? ''),
                    'operating_fee' => ($office->uzemeletetesi_dij ?? '').' '.($office->uzemeletetesi_dij_addons ?? ''),
                    'url' => route('properties.show', ['property' => $office]),
                ];
            })
            ->values(); // Reset array keys to ensure clean JSON
    }

    private function buildQuery()
    {
        $query = Offices::query()
            ->rent()
            ->active();

        if ($this->min_rent) {
            $query->where('min_berleti_idoszak', $this->min_rent);
        }

        if ($this->min_rent_addons) {
            $query->where('min_berleti_idoszak_addons', $this->min_rent_addons);
        }

        // If agglomeration is not included, only show Budapest properties
        if ($this->includeAgglomeration) {
            $query->whereNot(function ($query): void {
                $query->budapestOnly();
            });
        }

        if ($this->category) {
            $category_model = Category::where('slug', 'like', $this->category)->first();
            $this->title = $category_model?->name ?? __('page.title.offices_for_rent');
            if ($category_model) {
                $query->byCategory(stripslashes($category_model->name));
            }
        }

        // Apply search filter
        if ($this->search) {
            if (
                mb_stripos($this->search, '2 csöves fan-coil') !== false ||
                mb_stripos($this->search, '2 csoves fan-coil') !== false ||
                mb_stripos($this->search, '2 csöves') !== false ||
                mb_stripos($this->search, '2 csoves') !== false
            ) {
                $query->whereRaw('JSON_SEARCH(LOWER(tags), "one", LOWER(?)) IS NOT NULL', ['%2 csöves fan-coil%']);
            } elseif (
                mb_stripos($this->search, '4 csöves fan-coil') !== false ||
                mb_stripos($this->search, '4 csoves fan-coil') !== false ||
                mb_stripos($this->search, '4 csöves') !== false ||
                mb_stripos($this->search, '4 csoves') !== false
            ) {
                $query->whereRaw('JSON_SEARCH(LOWER(tags), "one", LOWER(?)) IS NOT NULL', ['%4 csöves fan-coil%']);
            } else {
                $query->searchText($this->search);
            }
        }

        if ($this->areaMin >= 0 || $this->areaMax) {
            // Requested interval
            $amin = $this->areaMin ? (int) $this->areaMin : 1;
            $amax = $this->areaMax ? (int) $this->areaMax : 3000;

            $query->where('min_kiado', '<=', $amax)
                ->where('jelenleg_kiado', '>=', $amin);
        }

        // Apply price range filter
        if ($this->priceMin || $this->priceMax) {
            $query->priceRange(
                $this->priceMin ? (int) $this->priceMin : null,
                $this->priceMax ? (int) $this->priceMax : null
            );
        }

        // Apply office name filter
        if ($this->officeName) {
            $query->byOfficeName($this->officeName);
        }

        // If agglomeration is included, return only agglomeration properties and skip district filters
        if ($this->includeAgglomeration) {

            return $query->agglomeration();
        }

        // Apply district filter (single district for backward compatibility)
        if ($this->district) {
            $query->inDistrict($this->district);
        }

        // Apply multiple districts filter
        if ($this->districts) {
            $selectedDistricts = explode(',', $this->districts);
            $selectedDistricts = array_filter(array_map('trim', $selectedDistricts));

            if ($selectedDistricts !== []) {
                $query->inDistricts($selectedDistricts);
            }
        }

        return $query;
    }
}
