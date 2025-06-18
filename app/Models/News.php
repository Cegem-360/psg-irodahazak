<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

final class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
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
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_breaking' => 'boolean',
        'published_at' => 'datetime',
        'meta_data' => 'array',
        'views_count' => 'integer',
        'priority' => 'integer',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('is_published', false);
    }

    public function scopeBreaking(Builder $query): Builder
    {
        return $query->where('is_breaking', true);
    }

    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('news_category_id', $categoryId);
    }

    public function scopeByPriority(Builder $query): Builder
    {
        return $query->orderBy('priority', 'desc')
            ->orderBy('published_at', 'desc');
    }

    // Accessors
    public function getReadingTimeAttribute(): string
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average reading speed

        return $minutes.' perc olvasás';
    }

    public function getStatusAttribute(): string
    {
        if ($this->is_published && $this->published_at && $this->published_at <= now()) {
            return 'published';
        }

        if ($this->is_published && $this->published_at && $this->published_at > now()) {
            return 'scheduled';
        }

        return 'draft';
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            1 => 'Alacsony',
            2 => 'Normál',
            3 => 'Magas',
            4 => 'Sürgős',
            5 => 'Kritikus',
            default => 'Normál',
        };
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
}
