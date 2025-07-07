<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $news = News::query()->published()->orderByDesc('published_at')->paginate();

        return view('news.index', ['news' => $news]);
    }

    public function show(string $slug): View
    {
        $news = News::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $news->incrementViews();

        return view('news.show', ['news' => $news]);
    }
}
