<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

final class NewsCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'is_active',
        'sort_order',
    ];

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

    public function getNewsCountAttribute(): int
    {
        return $this->news()->count();
    }

    public function getPublishedNewsCountAttribute(): int
    {
        return $this->publishedNews()->count();
    }

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
}
