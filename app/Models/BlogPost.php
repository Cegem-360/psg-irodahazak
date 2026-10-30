<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BlogPostStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'title',
    'slug',
    'excerpt',
    'content',
    'featured_image',
    'blog_category_id',
    'user_id',
    'is_published',
    'noindex',
    'published_at',
    'meta_data',
    'views_count',
    'link',
])]
final class BlogPost extends Model
{
    use HasFactory;

    /** Average reading speed, in words per minute. */
    private const int WORDS_PER_MINUTE = 200;

    /**
     * @return BelongsTo<BlogCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isPublished(): bool
    {
        return $this->status === BlogPostStatus::Published;
    }

    /**
     * Counts a page view without touching updated_at, which the sitemap reports as the last modification.
     */
    public function incrementViews(): void
    {
        self::query()->whereKey($this->getKey())->toBase()->increment('views_count');
        $this->views_count++;
        $this->syncOriginalAttribute('views_count');
    }

    public function publish(): void
    {
        $this->update([
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    public function unpublish(): void
    {
        $this->update([
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function scheduled(Builder $query): void
    {
        $query->where('is_published', true)
            ->where('published_at', '>', now());
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function draft(Builder $query): void
    {
        $query->where(fn (Builder $query): Builder => $query->where('is_published', false)->orWhereNull('published_at'));
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function withStatus(Builder $query, BlogPostStatus $status): void
    {
        match ($status) {
            BlogPostStatus::Published => $query->published(),
            BlogPostStatus::Scheduled => $query->scheduled(),
            BlogPostStatus::Draft => $query->draft(),
        };
    }

    /**
     * @return Attribute<BlogPostStatus, never>
     */
    protected function status(): Attribute
    {
        return Attribute::make(get: fn (): BlogPostStatus => match (true) {
            ! $this->is_published || $this->published_at === null => BlogPostStatus::Draft,
            $this->published_at->isFuture() => BlogPostStatus::Scheduled,
            default => BlogPostStatus::Published,
        });
    }

    /**
     * Estimated reading time in whole minutes, at least one.
     *
     * @return Attribute<int, never>
     */
    protected function readingTime(): Attribute
    {
        return Attribute::make(get: function (): int {
            $words = preg_split('/\s+/u', mb_trim(strip_tags((string) $this->content)), flags: PREG_SPLIT_NO_EMPTY);

            return max(1, (int) ceil(count($words ?: []) / self::WORDS_PER_MINUTE));
        });
    }

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'noindex' => 'boolean',
            'published_at' => 'datetime',
            'meta_data' => 'array',
            'views_count' => 'integer',
        ];
    }
}
