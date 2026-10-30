<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Category;
use App\Models\Property as Offices;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

final class ListRentOffices extends Component
{
    use WithPagination;

    public ?string $search = '';

    public ?string $districts = '';

    public ?string $district = '';

    public ?string $officeName = '';

    public ?string $areaMin = '';

    public ?string $areaMax = '';

    public ?string $priceMin = '';

    public ?string $priceMax = '';

    public bool $includeAgglomeration = false;

    #[Locked]
    public int $perPage = 6;

    #[Locked]
    public int $totalOffices = 0;

    /** Minimum lease term filter, from the search form. */
    public null|int|string $minLeaseTerm = '';

    public ?string $minLeaseTermUnit = '';

    #[Locked]
    public ?string $title = null;

    /** The category page this list belongs to; set by the route, not by the visitor. */
    #[Locked]
    public ?string $category = null;

    /** @var array<string, mixed> Per-request memo of getOffices(), keyed by the filter state. */
    private array $officesMemo = [];

    /** @var array<string, Category|null> Per-request memo of the category looked up by slug. */
    private array $categoryMemo = [];

    public function mount(array $queryParams = []): void
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
        $this->includeAgglomeration = (bool) ($queryParams['include_agglomeration'] ?? request('include_agglomeration', false));
        $this->category = $queryParams['category'] ?? request('category');
        $this->minLeaseTerm = $queryParams['min_lease_term'] ?? request('min_lease_term');
        $this->minLeaseTermUnit = $queryParams['min_lease_term_unit'] ?? request('min_lease_term_unit');

        if ($this->officeName) {
            $office = Offices::query()->where('title', $this->officeName)->first();

            if ($office !== null) {
                $this->redirect($office->url());
            }
        }

        // Before the first query: buildQuery() replaces the title with the category's heading.
        $this->title = $queryParams['title'] ?? request('title', __('page.title.offices_for_rent'));

        $this->updateTotalOffices();

    }

    public function updateTotalOffices(): void
    {
        $this->totalOffices = $this->getOffices()->total();
    }

    /**
     * The current page of offices. Memoised per state, because the count, the list
     * and the map markers all read it during one request.
     */
    public function getOffices(): LengthAwarePaginator
    {
        $state = serialize([$this->search, $this->districts, $this->district, $this->officeName, $this->areaMin,
            $this->areaMax, $this->priceMin, $this->priceMax, $this->includeAgglomeration, $this->category,
            $this->minLeaseTerm, $this->minLeaseTermUnit, $this->perPage, $this->getPage()]);

        return $this->officesMemo[$state] ??= $this->buildQuery()
            ->orderBy('title')
            ->paginate($this->perPage);
    }

    public function render(): Factory|View
    {

        $offices = $this->getOffices();

        return view('livewire.list-rent-offices', [
            'offices' => $offices,
        ]);
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function getOfficesForMap(): Collection
    {
        // Get only the currently paginated offices that have coordinates
        $paginatedOffices = $this->getOffices();

        // Filter out offices without coordinates and transform to map format
        return $paginatedOffices->getCollection()
            ->whereNotNull('maps_lat')
            ->whereNotNull('maps_lng')
            ->where('maps_lat', '!=', '')
            ->where('maps_lng', '!=', '')
            ->map(fn ($office): array => [
                'id' => $office->id,
                'title' => $office->title,
                'lat' => (float) $office->maps_lat,
                'lng' => (float) $office->maps_lng,
                'address' => $office->postal_code.' '.$office->city.($office->district ? ' '.$office->district.'. kerület' : '').', '.$office->street.' '.$office->house_number,
                'rent' => ($office->min_rent ?? '').' - '.($office->max_rent ?? '').' '.($office->max_rent_unit ?? ''),
                'operating_fee' => (translate_value($office->operating_fee) ?? '').' '.($office->operating_fee_unit ?? ''),
                'url' => $office->url(),
            ])
            ->values(); // Reset array keys to ensure clean JSON
    }

    /**
     * @return Builder<Offices>
     */
    private function buildQuery(): Builder
    {
        $query = Offices::query()
            ->rent()
            ->active();

        if ($this->minLeaseTerm) {
            $query->where('min_lease_term', $this->minLeaseTerm);
        }

        if ($this->minLeaseTermUnit) {
            $query->where('min_lease_term_unit', $this->minLeaseTermUnit);
        }

        if ($this->category) {
            $category_model = $this->categoryMemo[$this->category] ??= Category::query()->where('slug', 'like', $this->category)->first();

            // A slug with no matching category is a page that does not exist. Returning
            // 404 rather than quietly listing everything keeps it out of search results
            // as a soft 404, and matches psg-raktarak.
            abort_if($category_model === null, 404);

            $this->title = $category_model->heading ?: ($category_model->name ?? __('page.title.offices_for_rent'));
            $query->inCategory($category_model);
        }

        // Apply search filter
        if ($this->search) {
            if (
                mb_stripos((string) $this->search, '2 csöves fan-coil') !== false ||
                mb_stripos((string) $this->search, '2 csoves fan-coil') !== false ||
                mb_stripos((string) $this->search, '2 csöves') !== false ||
                mb_stripos((string) $this->search, '2 csoves') !== false
            ) {
                $query->whereRaw('JSON_SEARCH(LOWER(tags), "one", LOWER(?)) IS NOT NULL', ['%2 csöves fan-coil%']);
            } elseif (
                mb_stripos((string) $this->search, '4 csöves fan-coil') !== false ||
                mb_stripos((string) $this->search, '4 csoves fan-coil') !== false ||
                mb_stripos((string) $this->search, '4 csöves') !== false ||
                mb_stripos((string) $this->search, '4 csoves') !== false
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

            $query->where('min_available_area', '<=', $amax)
                ->where('available_area', '>=', $amin);
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
            $selectedDistricts = explode(',', (string) $this->districts);
            $selectedDistricts = array_filter(array_map(trim(...), $selectedDistricts));

            if ($selectedDistricts !== []) {
                $query->inDistricts($selectedDistricts);
            }
        }

        return $query;
    }
}
