<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Carbon\CarbonInterface;
use Illuminate\Support\Str;

/**
 * An article with an excerpt shown above its content and a publication date
 * shown to the reader.
 */
trait HasExcerpt
{
    /**
     * Whether the excerpt is just the opening of the content, as for the posts
     * copied from blog.hu and the news whose excerpt was filled in from the
     * content: the page then shows the content only, not the same text twice.
     */
    public function excerptOpensContent(): bool
    {
        $plain = fn (?string $html): string => Str::squish(html_entity_decode(strip_tags((string) $html)));

        $excerpt = mb_rtrim($plain($this->excerpt), '.… ');

        return $excerpt !== '' && str_starts_with($plain($this->content), $excerpt);
    }

    /**
     * The publication date on the Budapest calendar: the timestamps are stored in
     * UTC, so an article published just after midnight would otherwise show the
     * previous day.
     */
    public function localPublishedAt(): ?CarbonInterface
    {
        return $this->published_at?->copy()->setTimezone(config('app.display_timezone'));
    }
}
