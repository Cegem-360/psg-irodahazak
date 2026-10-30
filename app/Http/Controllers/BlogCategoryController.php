<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\View\View;

final class BlogCategoryController extends Controller
{
    public function show(BlogCategory $category): View
    {
        abort_unless($category->is_active, 404);

        $posts = BlogPost::query()->published()
            ->where('blog_category_id', $category->id)
            ->with(['category', 'author'])
            ->latest('published_at')
            ->paginate(12);

        $categories = BlogCategory::query()->where('is_active', true)
            ->withCount('blogPosts')
            ->orderBy('name')
            ->get();

        return view('blog.category', ['posts' => $posts, 'category' => $category, 'categories' => $categories]);
    }
}
