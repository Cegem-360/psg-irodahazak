<?php

declare(strict_types=1);

namespace App\Models;

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
    'published_at',
    'meta_data',
    'views_count',
    'link',
])]
final class BlogPost extends Model
{
    use HasFactory;

    // Relationships
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

    public function incrementViews(): void
    {
        $this->increment('views_count');
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

    // Scopes
    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    #[Scope]
    protected function byCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('blog_category_id', $categoryId);
    }

    protected function readingTime(): Attribute
    {
        return Attribute::make(get: function (): string {
            $wordCount = str_word_count(strip_tags($this->content));
            $minutes = ceil($wordCount / 200);

            // Average reading speed
            return $minutes.' perc olvasás';
        });
    }

    protected function status(): Attribute
    {
        return Attribute::make(get: function (): string {
            if ($this->is_published && $this->published_at && $this->published_at <= now()) {
                return 'published';
            }

            if ($this->is_published && $this->published_at && $this->published_at > now()) {
                return 'scheduled';
            }

            return 'draft';
        });
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function draft(Builder $query): void
    {
        $query->where('is_published', false);
    }

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'meta_data' => 'array',
            'views_count' => 'integer',
        ];
    }
}
