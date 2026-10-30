<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\NewsCategoryObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(NewsCategoryObserver::class)]
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
