<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Concerns\RendersAsPage;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * A /budapest/{category} page: the rental list narrowed to one category.
 */
final class OfficeCategory extends Component
{
    use RendersAsPage;

    public Category $category;

    public function render(): View
    {
        return $this->asPage(view('pages.filter', [
            'queryParams' => ['category' => $this->category->slug],
        ]), [
            ['name' => __('Rental Offices'), 'url' => localized_route('kiado-irodak')],
            ['name' => $this->category->name, 'url' => localized_route('budapest.category', ['category' => $this->category->slug])],
        ]);
    }
}
