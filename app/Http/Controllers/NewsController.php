<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::with(['category', 'author'])
            ->published()
            ->byPriority();

        // Filter by category if requested
        if ($request->has('category')) {
            $category = NewsCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->byCategory($category->id);
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate(12);
        $categories = NewsCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $breakingNews = News::with(['category'])
            ->published()
            ->breaking()
            ->latest()
            ->take(3)
            ->get();

        return view('news.index', compact('news', 'categories', 'breakingNews'));
    }

    public function show(string $slug): View
    {
        $news = News::with(['category', 'author'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $news->incrementViews();

        // Get related news from the same category
        $relatedNews = News::with(['category'])
            ->published()
            ->where('news_category_id', $news->news_category_id)
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(4)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }

    public function category(string $slug): View
    {
        $category = NewsCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $news = News::with(['category', 'author'])
            ->published()
            ->byCategory($category->id)
            ->byPriority()
            ->paginate(12);

        $allCategories = NewsCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('news.category', compact('news', 'category', 'allCategories'));
    }

    public function search(Request $request): View
    {
        $search = $request->input('q');
        $query = News::with(['category', 'author'])
            ->published()
            ->byPriority();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate(12);
        $categories = NewsCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('news.search', compact('news', 'search', 'categories'));
    }
}
