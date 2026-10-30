<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Property as Offices;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

final class ListSaleOffices extends Component
{
    use WithPagination;

    /** Columns the visitor may sort by. */
    private const array SORTABLE_FIELDS = ['title', 'date', 'ord'];

    public string $search = '';

    public string $sortField = 'title';

    #[Locked]
    public int $perPage = 6;

    #[Locked]
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
    public function getOffices(): LengthAwarePaginator
    {
        $sortField = in_array($this->sortField, self::SORTABLE_FIELDS, true) ? $this->sortField : 'title';
        $state = serialize([$this->search, $sortField, $this->perPage, $this->getPage()]);

        return $this->officesMemo[$state] ??= Offices::query()
            ->when($this->search, function ($query): void {
                $query->searchText($this->search);
            })
            ->sale()
            ->active()
            ->orderBy($sortField)
            ->paginate($this->perPage);
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function getOfficesForMap(): Collection
    {
        // Transform the current page of offices to map format (coordinates will be geocoded on frontend)
        return $this->getOffices()->getCollection()
            ->map(function ($office): array {
                // Build full address for geocoding
                $addressParts = array_filter([
                    $office->postal_code,
                    $office->city,
                    $office->street,
                    $office->house_number,
                ]);
                $fullAddress = implode(' ', $addressParts);

                return [
                    'id' => $office->id,
                    'title' => $office->title,
                    'address' => $fullAddress,
                    'postal_code' => $office->postal_code ?? '',
                    'city' => $office->city ?? '',
                    'street' => $office->street ?? '',
                    'house_number' => $office->house_number ?? '',
                    'rent' => ($office->min_rent ?? '').' - '.($office->max_rent ?? '').' '.($office->max_rent_unit ?? ''),
                    'operating_fee' => (translate_value($office->operating_fee) ?? '').' '.($office->operating_fee_unit ?? ''),
                    'url' => $office->url(),
                ];
            })
            ->values(); // Reset array keys to ensure clean JSON
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->updateTotalOffices();
    }

    public function updatedSortField(): void
    {
        $this->resetPage();
    }

    public function render(): Factory|View
    {
        return view('livewire.list-sale-offices', [
            'offices' => $this->getOffices(),
        ]);
    }
}
