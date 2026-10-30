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
        abort_unless($post->isPublished(), 404);

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
