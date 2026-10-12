<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    /**
     * @return HasMany<News, $this>
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    /**
     * @return HasMany<News, $this>
     */
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
                $category->sort_order = self::query()->max('sort_order') + 1;
            }
        });

        self::updating(function (NewsCategory $category): void {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    protected function newsCount(): Attribute
    {
        return Attribute::make(get: fn () => $this->news()->count());
    }

    protected function publishedNewsCount(): Attribute
    {
        return Attribute::make(get: fn () => $this->publishedNews()->count());
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
