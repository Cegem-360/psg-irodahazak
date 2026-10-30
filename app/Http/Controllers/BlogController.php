<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\View\View;

final class BlogController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function show(BlogPost $post): View
    {
        // Csak publikált bejegyzéseket mutatjuk
        abort_if(! $post->is_published || ! $post->published_at || $post->published_at > now(), 404);

        // Megtekintések számának növelése
        $post->incrementViews();

        // Kapcsolódó bejegyzések (ugyanabból a kategóriából)
        $relatedPosts = BlogPost::query()->published()
            ->where('blog_category_id', $post->blog_category_id)
            ->where('id', '!=', $post->id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', ['post' => $post, 'relatedPosts' => $relatedPosts]);
    }
}
