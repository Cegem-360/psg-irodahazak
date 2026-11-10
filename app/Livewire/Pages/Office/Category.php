<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Office;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\Category as CategoryModel;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * A /budapest/{category} page: the rental list narrowed to one category.
 */
final class Category extends Component
{
    use RendersAsPage;

    public CategoryModel $category;

    public function render(): View
    {
        return $this->asPage(view('pages.office.category', [
            'queryParams' => ['category' => $this->category->slug],
        ]), [
            ['name' => __('Rental Offices'), 'url' => localized_route('kiado-irodak')],
            ['name' => $this->category->name, 'url' => localized_route('budapest.category', ['category' => $this->category->slug])],
        ]);
    }
}
