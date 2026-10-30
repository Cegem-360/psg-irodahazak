<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\NewsCategory;
use Illuminate\Support\Str;

final class NewsCategoryObserver
{
    /**
     * Puts a new category at the end of the list unless it has a position.
     */
    public function creating(NewsCategory $category): void
    {
        if (blank($category->sort_order)) {
            $category->sort_order = NewsCategory::query()->max('sort_order') + 1;
        }
    }

    /**
     * Fills in a missing slug from the name.
     */
    public function saving(NewsCategory $category): void
    {
        if (blank($category->slug)) {
            $category->slug = Str::slug($category->name);
        }
    }
}
