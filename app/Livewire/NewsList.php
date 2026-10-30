<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * The /hirek listing: published news, newest first, searchable and filterable by
 * category without a page reload. Search, category and page live in the query
 * string, so every state keeps a shareable, crawlable URL.
 */
final class NewsList extends Component
{
    use WithPagination;

    public const int PER_PAGE = 15;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(as: 'kategoria', except: '')]
    public string $category = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'category');
        $this->resetPage();
    }

    /**
     * @return Collection<int, NewsCategory>
     */
    #[Computed]
    public function categories(): Collection
    {
        return NewsCategory::query()
            ->where('is_active', true)
            ->whereHas('news', fn (Builder $query): Builder => $query->where('is_published', true))
            ->orderBy('name')
            ->get();
    }

    public function render(): View
    {
        return view('livewire.news-list', [
            'news' => $this->news(),
        ]);
    }

    /**
     * @return LengthAwarePaginator<int, News>
     */
    private function news(): LengthAwarePaginator
    {
        $search = mb_trim($this->search);

        return News::query()
            ->published()
            ->when($search !== '', fn (Builder $query): Builder => $query->where(
                fn (Builder $query): Builder => $query
                    ->where('title', 'like', '%'.$search.'%')
                    ->orWhere('excerpt', 'like', '%'.$search.'%')
                    ->orWhere('content', 'like', '%'.$search.'%')
            ))
            ->when($this->category !== '', fn (Builder $query): Builder => $query->whereHas(
                'category',
                fn (Builder $query): Builder => $query->where('slug', $this->category)
            ))
            ->orderByDesc('published_at')
            ->paginate(self::PER_PAGE);
    }
}
