<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\BlogCategoryObserver;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(BlogCategoryObserver::class)]
#[Fillable([
    'name',
    'slug',
    'description',
    'color',
    'is_active',
])]
final class BlogCategory extends Model
{
    use HasFactory;

    /**
     * @return HasMany<BlogPost, $this>
     */
    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }

    protected function postsCount(): Attribute
    {
        return Attribute::make(get: fn () => $this->blogPosts()->count());
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
