<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Override;

#[Fillable([
    'title',
    'slug',
    'source',
    'excerpt',
    'content',
    'featured_image',
    'news_category_id',
    'user_id',
    'is_published',
    'published_at',
    'meta_data',
    'views_count',
    'priority',
    'is_breaking',
    'created_at',
    'updated_at',
])]
#[Table(name: 'news')]
final class News extends Model
{
    use HasFactory;

    // Relationships
    /**
     * @return BelongsTo<NewsCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Methods
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

    public function markAsBreaking(): void
    {
        $this->update(['is_breaking' => true]);
    }

    public function unmarkAsBreaking(): void
    {
        $this->update(['is_breaking' => false]);
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (News $news): void {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }

            if (empty($news->excerpt)) {
                $news->excerpt = Str::limit(strip_tags($news->content), 160);
            }

            if (empty($news->priority)) {
                $news->priority = 2; // Default to normal priority
            }
        });

        self::updating(function (News $news): void {
            if ($news->isDirty('title') && empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }

            if ($news->isDirty('content') && empty($news->excerpt)) {
                $news->excerpt = Str::limit(strip_tags($news->content), 160);
            }
        });
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    #[Scope]
    protected function draft(Builder $query): Builder
    {
        return $query->where('is_published', false);
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    #[Scope]
    protected function breaking(Builder $query): Builder
    {
        return $query->where('is_breaking', true);
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

    protected function priorityLabel(): Attribute
    {
        return Attribute::make(get: fn (): string => match ($this->priority) {
            1 => 'Alacsony',
            2 => 'Normál',
            3 => 'Magas',
            4 => 'Sürgős',
            5 => 'Kritikus',
            default => 'Normál',
        });
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function byPriority(Builder $query): void
    {
        $query->orderBy('priority', 'desc')
            ->latest('published_at');
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function byCategory(Builder $query, int $categoryId): void
    {
        $query->where('news_category_id', $categoryId);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true);
    }

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_breaking' => 'boolean',
            'published_at' => 'date',
            'meta_data' => 'array',
            'views_count' => 'integer',
            'priority' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'date',

        ];
    }
}
