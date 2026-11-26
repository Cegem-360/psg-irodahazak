<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ArticlePageKey;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Once;

/**
 * The editable copy of a fixed article page (the rental fee overview, the
 * operating fee article): headline, meta, dates, body with its tables, FAQ and
 * call to action. The pages render this record, so the site owner can keep the
 * figures and the year up to date in the admin.
 *
 * @property ArticlePageKey $key
 * @property string $headline
 * @property string $short_title
 * @property string $meta_title
 * @property string $meta_description
 * @property string|null $link_label
 * @property CarbonImmutable $published_on
 * @property CarbonImmutable $last_updated_on
 * @property string $body
 * @property string|null $cta
 * @property list<array{question: string, answer: string}> $faqs
 */
#[Fillable([
    'key',
    'headline',
    'short_title',
    'meta_title',
    'meta_description',
    'link_label',
    'published_on',
    'last_updated_on',
    'body',
    'cta',
    'faqs',
])]
final class ArticlePage extends Model
{
    /**
     * The page's record, loaded once per request (the menus and the data sheets use it too).
     */
    public static function for(ArticlePageKey $key): self
    {
        return once(fn (): self => self::query()->where('key', $key)->firstOrFail());
    }

    /**
     * A saved edit is shown at once, not the record loaded earlier in the same request.
     */
    protected static function booted(): void
    {
        self::saved(function (): void {
            Once::flush();
        });
    }

    protected function casts(): array
    {
        return [
            'key' => ArticlePageKey::class,
            'published_on' => 'immutable_date',
            'last_updated_on' => 'immutable_date',
            'faqs' => 'array',
        ];
    }
}
