<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\News;
use Illuminate\Support\Str;

final class NewsObserver
{
    /**
     * Fills in a missing slug from the title and a missing excerpt from the content.
     */
    public function saving(News $news): void
    {
        if (blank($news->slug)) {
            $news->slug = Str::slug($news->title);
        }

        if (blank($news->excerpt)) {
            $news->excerpt = Str::limit(strip_tags((string) $news->content), 160);
        }
    }
}
