<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\View\View;

final class NewsController extends Controller
{
    /**
     * The listing itself, with search, category filter and paging, is the NewsList Livewire component.
     */
    public function index(): View
    {
        return view('news.index');
    }

    public function show(string $slug): View
    {
        $news = News::query()->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $news->incrementViews();

        return view('news.show', ['news' => $news]);
    }
}
