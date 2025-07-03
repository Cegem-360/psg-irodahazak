<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $categories = BlogCategory::where('is_active', true)
            ->withCount('blogPosts')
            ->orderBy('name')
            ->get();

        $query = BlogPost::published()
            ->with(['category', 'author'])
            ->latest('published_at');

        // Kategória szűrés
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request): void {
                $q->where('slug', $request->category);
            });
        }

        // Keresés
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm): void {
                $q->where('title', 'like', '%'.$searchTerm.'%')
                    ->orWhere('excerpt', 'like', '%'.$searchTerm.'%')
                    ->orWhere('content', 'like', '%'.$searchTerm.'%');
            });
        }

        $posts = $query->paginate(12);

        return view('index');
    }

    public function show(BlogPost $post): View
    {
        // Csak publikált bejegyzéseket mutatjuk
        if (! $post->is_published || ! $post->published_at || $post->published_at > now()) {
            abort(404);
        }

        // Megtekintések számának növelése
        $post->incrementViews();

        // Kapcsolódó bejegyzések (ugyanabból a kategóriából)
        $relatedPosts = BlogPost::published()
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', ['post' => $post, 'relatedPosts' => $relatedPosts]);
    }

    public function category(BlogCategory $category): View
    {
        if (! $category->is_active) {
            abort(404);
        }

        $posts = BlogPost::published()
            ->where('blog_category_id', $category->id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->paginate(12);

        $categories = BlogCategory::where('is_active', true)
            ->withCount('blogPosts')
            ->orderBy('name')
            ->get();

        return view('blog.category', ['posts' => $posts, 'category' => $category, 'categories' => $categories]);
    }
}
