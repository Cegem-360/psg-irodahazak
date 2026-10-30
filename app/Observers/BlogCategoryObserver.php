<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\BlogCategory;
use Illuminate\Support\Str;

final class BlogCategoryObserver
{
    /**
     * Fills in a missing slug from the name.
     */
    public function saving(BlogCategory $category): void
    {
        if (blank($category->slug)) {
            $category->slug = Str::slug($category->name);
        }
    }
}
