<?php

declare(strict_types=1);

namespace App\Livewire\Pages\News;

use App\Enums\ArticlePageKey;
use App\Livewire\Concerns\RendersAsPage;
use App\Models\ArticlePage;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * /hirek/uzemeltetesi-dij-irodaberles: the article on the operating fee of
 * office leases, from the property data sheets. Hungarian only.
 *
 * It is not a news item (the owner's request): it has no News record, so it
 * is not in the news list or the home page news block. Its route comes before
 * the news route, so a News record with the same slug would never be shown.
 *
 * The copy is edited in the admin (Díjak és cikkek), like the rental fee overview.
 */
final class OperatingFee extends Component
{
    use RendersAsPage;

    public const string SLUG = 'uzemeltetesi-dij-irodaberles';

    public function mount(): void
    {
        app()->setLocale('hu');
    }

    public function render(): View
    {
        $page = ArticlePage::for(ArticlePageKey::OperatingFee);

        return $this->asPage(view('pages.article-page', ['page' => $page]), [
            ['name' => __('News'), 'url' => route('news.index')],
            ['name' => $page->short_title, 'url' => route('operating-fee')],
        ]);
    }
}
