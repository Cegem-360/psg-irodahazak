<?php

declare(strict_types=1);

namespace App\Livewire\Office;

use App\Models\Category;
use App\Models\Property;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * The list of offices for rent, on /kiado-irodak and on the category pages. The
 * filters come from the search form (query string) or from the category page,
 * once, in mount(): the visitor only pages through the list, so they are locked.
 */
final class RentListing extends Component
{
    use WithPagination;

    /** The area interval of the search form's slider, in m²: an untouched slider asks for no area. */
    private const int AREA_MIN = 1;

    private const int AREA_MAX = 3000;

    #[Locked]
    public ?string $search = '';

    #[Locked]
    public ?string $districts = '';

    #[Locked]
    public ?string $district = '';

    #[Locked]
    public ?string $officeName = '';

    #[Locked]
    public ?string $areaMin = '';

    #[Locked]
    public ?string $areaMax = '';

    #[Locked]
    public ?string $priceMin = '';

    #[Locked]
    public ?string $priceMax = '';

    #[Locked]
    public bool $includeAgglomeration = false;

    #[Locked]
    public ?string $minLeaseTerm = '';

    #[Locked]
    public ?string $minLeaseTermUnit = '';

    #[Locked]
    public int $perPage = 6;

    #[Locked]
    public int $totalOffices = 0;

    #[Locked]
    public ?string $title = null;

    /** The category page this list belongs to; set by the route, not by the visitor. */
    #[Locked]
    public ?string $category = null;

    /** @var array<string, LengthAwarePaginator> Per-request memo of getOffices(), keyed by the list state. */
    private array $officesMemo = [];

    /** @var array<string, Category|null> Per-request memo of the category looked up by slug. */
    private array $categoryMemo = [];

    /**
     * @param  array<string, mixed>  $queryParams  Filters set by the page; the query string fills the rest.
     */
    public function mount(array $queryParams = []): void
    {
        // Never from route parameters: on /budapest/{category} "category" is the bound model
        $filter = function (string $key) use ($queryParams): ?string {
            $value = $queryParams[$key] ?? request()->query($key);

            return is_scalar($value) ? (string) $value : null;
        };

        $this->search = $filter('search');
        $this->districts = $filter('districts');
        $this->district = $filter('district');
        $this->officeName = $filter('office_name');
        $this->areaMin = $filter('area_min');
        $this->areaMax = $filter('area_max');
        $this->priceMin = $filter('price_min');
        $this->priceMax = $filter('price_max');
        $this->includeAgglomeration = (bool) $filter('include_agglomeration');
        $this->category = $filter('category');
        $this->minLeaseTerm = $filter('min_lease_term');
        $this->minLeaseTermUnit = $filter('min_lease_term_unit');

        // An office picked by name in the search form opens its own page
        if ($this->officeName) {
            $office = Property::query()->where('title', $this->officeName)->first();

            if ($office !== null) {
                $this->redirect($office->url());

                return;
            }
        }

        $category = $this->categoryModel();

        $this->title = $category instanceof Category
            ? ($category->heading ?: ($category->name ?? __('page.title.offices_for_rent')))
            : $filter('title') ?? __('page.title.offices_for_rent');

        $this->totalOffices = $this->getOffices()->total();
    }

    /**
     * The current page of offices. Memoised per state, because the list and the
     * map markers both read it during one request.
     */
    public function getOffices(): LengthAwarePaginator
    {
        $state = serialize([$this->search, $this->districts, $this->district, $this->officeName, $this->areaMin,
            $this->areaMax, $this->priceMin, $this->priceMax, $this->includeAgglomeration, $this->category,
            $this->minLeaseTerm, $this->minLeaseTermUnit, $this->perPage, $this->getPage()]);

        return $this->officesMemo[$state] ??= $this->buildQuery()
            ->unless($this->hasAreaFilter(), fn (Builder $query): Builder => $this->orderByAreaInSliderRange($query))
            ->orderBy('title')
            ->paginate($this->perPage);
    }

    /**
     * The map markers of the current page: the offices that have coordinates.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function getOfficesForMap(): Collection
    {
        return $this->getOffices()->getCollection()
            ->filter(fn (Property $office): bool => filled($office->maps_lat) && filled($office->maps_lng))
            ->map(fn (Property $office): array => [
                'id' => $office->id,
                'title' => $office->title,
                'lat' => (float) $office->maps_lat,
                'lng' => (float) $office->maps_lng,
                'address' => $office->postal_code.' '.$office->city.($office->district ? ' '.$office->district.'. kerület' : '').', '.$office->street.' '.$office->house_number,
                'rent' => ($office->min_rent ?? '').' - '.($office->max_rent ?? '').' '.($office->max_rent_unit ?? ''),
                'operating_fee' => (translate_value($office->operating_fee) ?? '').' '.($office->operating_fee_unit ?? ''),
                'url' => $office->url(),
            ])
            ->values();
    }

    public function render(): View
    {
        return view('livewire.office.rent-listing', [
            'offices' => $this->getOffices(),
        ]);
    }

    /**
     * @return Builder<Property>
     */
    private function buildQuery(): Builder
    {
        [$areaMin, $areaMax] = $this->areaRange();

        return Property::query()
            ->rent()
            ->active()
            ->when($this->minLeaseTerm, fn (Builder $query, string $term): Builder => $query->where('min_lease_term', $term))
            ->when($this->minLeaseTermUnit, fn (Builder $query, string $unit): Builder => $query->where('min_lease_term_unit', $unit))
            ->when($this->categoryModel(), fn (Builder $query, Category $category): Builder => $query->inCategory($category))
            ->when($this->search, $this->applySearch(...))
            ->when($this->hasAreaFilter(), fn (Builder $query): Builder => $query
                ->where('min_available_area', '<=', $areaMax)
                ->where('available_area', '>=', $areaMin))
            ->when($this->priceMin || $this->priceMax, fn (Builder $query): Builder => $query->priceRange(
                $this->priceMin ? (int) $this->priceMin : null,
                $this->priceMax ? (int) $this->priceMax : null,
            ))
            ->when($this->officeName, fn (Builder $query, string $name): Builder => $query->byOfficeName($name))
            // The agglomeration lists the offices outside Budapest, so the district filters do not apply to it
            ->when(
                $this->includeAgglomeration,
                fn (Builder $query): Builder => $query->agglomeration(),
                fn (Builder $query): Builder => $query
                    ->when($this->district, fn (Builder $query, string $district): Builder => $query->inDistrict($district))
                    ->when($this->selectedDistricts(), fn (Builder $query, array $districts): Builder => $query->inDistricts($districts)),
            );
    }

    /**
     * Searching for a fan-coil type lists the offices with that tag; any other
     * text is searched in the title, description, code, tags and services.
     *
     * @param  Builder<Property>  $query
     */
    private function applySearch(Builder $query, string $search): void
    {
        $fanCoilPipes = Arr::first(['2', '4'], fn (string $pipes): bool => mb_stripos($search, $pipes.' csöves') !== false
            || mb_stripos($search, $pipes.' csoves') !== false);

        if ($fanCoilPipes === null) {
            $query->searchText($search);

            return;
        }

        $query->whereRelation('tags', 'name', 'like', '%'.$fanCoilPipes.' csöves fan-coil%');
    }

    /**
     * Without an area asked for, every office is listed, but those that fit the
     * slider's full range come first; the ones with no or a larger area go last.
     *
     * @param  Builder<Property>  $query
     * @return Builder<Property>
     */
    private function orderByAreaInSliderRange(Builder $query): Builder
    {
        return $query->orderByRaw(
            'CASE WHEN min_available_area <= ? AND available_area >= ? THEN 0 ELSE 1 END',
            [self::AREA_MAX, self::AREA_MIN],
        );
    }

    /**
     * Whether the visitor narrowed the area slider: only then are the offices
     * outside the interval left out.
     */
    private function hasAreaFilter(): bool
    {
        return $this->areaRange() !== [self::AREA_MIN, self::AREA_MAX];
    }

    /**
     * @return array{int, int}
     */
    private function areaRange(): array
    {
        return [
            max((int) $this->areaMin, self::AREA_MIN),
            (int) $this->areaMax ?: self::AREA_MAX,
        ];
    }

    /**
     * @return array<int, string>
     */
    private function selectedDistricts(): array
    {
        return array_values(array_filter(array_map(trim(...), explode(',', (string) $this->districts))));
    }

    /**
     * The category of a category page. A slug with no matching category is a page
     * that does not exist: 404 rather than quietly listing everything keeps it out
     * of search results as a soft 404, and matches psg-raktarak.
     */
    private function categoryModel(): ?Category
    {
        if (! $this->category) {
            return null;
        }

        $category = $this->categoryMemo[$this->category] ??= Category::query()->where('slug', $this->category)->first();

        abort_if($category === null, 404);

        return $category;
    }
}
