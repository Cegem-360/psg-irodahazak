<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Override;

#[Fillable([
    'name',
    'slug',
    'description',
    'color',
    'icon',
    'is_active',
    'sort_order',
])]
final class NewsCategory extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function publishedNews(): HasMany
    {
        return $this->hasMany(News::class)->published();
    }

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (NewsCategory $category): void {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }

            if (empty($category->sort_order)) {
                $category->sort_order = self::max('sort_order') + 1;
            }
        });

        self::updating(function (NewsCategory $category): void {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    protected function getNewsCountAttribute(): int
    {
        return $this->news()->count();
    }

    protected function getPublishedNewsCountAttribute(): int
    {
        return $this->publishedNews()->count();
    }
}
