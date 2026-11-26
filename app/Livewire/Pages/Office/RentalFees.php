<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Office;

use App\Enums\ArticlePageKey;
use App\Livewire\Concerns\RendersAsPage;
use App\Models\ArticlePage;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * /budapest/irodaberleti-dijak: the office rental fee bands of Budapest per
 * submarket, from the property data sheets. Hungarian only.
 *
 * The copy, the table, the FAQ and the "last updated" date are edited in the
 * admin (Díjak és cikkek), so the owner keeps the figures and the year current.
 */
final class RentalFees extends Component
{
    use RendersAsPage;

    public function mount(): void
    {
        app()->setLocale('hu');
    }

    public function render(): View
    {
        $page = ArticlePage::for(ArticlePageKey::RentalFees);

        return $this->asPage(view('pages.article-page', ['page' => $page]), [
            ['name' => __('Rental Offices'), 'url' => route('kiado-irodak')],
            ['name' => $page->short_title, 'url' => route('rental-fees')],
        ]);
    }
}
