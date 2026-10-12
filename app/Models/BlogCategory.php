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

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (BlogCategory $category): void {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        self::updating(function (BlogCategory $category): void {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
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
