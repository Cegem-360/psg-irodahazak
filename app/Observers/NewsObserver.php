<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\SubmitUrlsToIndexNow;
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

    /**
     * Pings IndexNow with the article once it is published, and after every
     * later edit. The news only exist in Hungarian.
     */
    public function saved(News $news): void
    {
        if (blank(config('seo.indexnow.key')) || $news->status !== 'published' || blank($news->slug)) {
            return;
        }

        SubmitUrlsToIndexNow::dispatchAfterResponse([route('news.show', ['news' => $news->slug])]);
    }
}
