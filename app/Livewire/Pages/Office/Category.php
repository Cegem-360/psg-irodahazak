<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Office;

use App\Livewire\Concerns\RendersAsPage;
use App\Livewire\Office\RentListing;
use App\Models\Category as CategoryModel;
use App\Models\Property;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * A /budapest/{category} page: the rental list narrowed to one category.
 *
 * The title, meta description and intro set in the admin are Hungarian copy,
 * so they are used on the Hungarian page only. A ":count" in the meta
 * description becomes the current number of office buildings in the category.
 */
final class Category extends Component
{
    use RendersAsPage;

    /** The ItemList schema names at most this many of the listed office buildings. */
    public const int ITEM_LIST_LIMIT = 50;

    public CategoryModel $category;

    public function title(): string
    {
        return $this->hungarian($this->category->seo_title)
            ?? __(':category in Budapest | PSG Irodaházak', ['category' => $this->category->name]);
    }

    public function metaDescription(): string
    {
        $description = $this->hungarian($this->category->meta_description);

        return $description !== null
            ? str_replace(':count', (string) $this->officeCount(), $description)
            : __(':category in Budapest: current available spaces, rental and operating fees of office buildings on a map. Request a personalised offer from PSG Irodaházak!', ['category' => $this->category->name]);
    }

    /**
     * @return Collection<int, Property>
     */
    #[Computed]
    public function listedOffices(): Collection
    {
        return RentListing::listedOffices($this->category, self::ITEM_LIST_LIMIT);
    }

    public function render(): View
    {
        return $this->asPage(view('pages.office.category', [
            'queryParams' => ['category' => $this->category->slug],
        ]), [
            ['name' => __('Rental Offices'), 'url' => localized_route('kiado-irodak')],
            ['name' => $this->category->name, 'url' => localized_route('budapest.category', ['category' => $this->category->slug])],
        ]);
    }

    private function officeCount(): int
    {
        return Property::query()->rent()->active()->inCategory($this->category)->count();
    }

    private function hungarian(?string $copy): ?string
    {
        return app()->getLocale() === 'hu' && filled($copy) ? $copy : null;
    }
}
