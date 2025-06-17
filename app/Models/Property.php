<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class Property extends Model
{
    protected $guarded = [];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function images()
    {
        return $this->hasMany(Gallery::class, 'target_table_id')
            ->where('target_table', 'property')
            ->orderBy('ord');
    }

    /**
     * Get gallery images ordered by ord field
     */
    public function galleryImages()
    {
        return $this->images()->orderBy('ord');
    }

    /**
     * Get all image URLs for this property
     */
    public function getImageUrlsAttribute(): array
    {
        return $this->images->map(function ($image) {
            return $image->image_url;
        })->toArray();
    }

    /**
     * Get the first image URL
     */
    public function getFirstImageUrlAttribute(): ?string
    {
        $firstImage = $this->images->first();

        return $firstImage ? $firstImage->image_url : null;
    }

    /**
     * Get image URLs in a specific size
     */
    public function getImageUrls(?string $size = null): array
    {
        return $this->images->map(function ($image) use ($size) {
            return $image->getImageUrl($size);
        })->toArray();
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('status', 'active');
    }

    #[Scope]
    protected function inactive(Builder $query): void
    {
        $query->where('status', 'inactive');
    }

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'services' => 'array',
        ];
    }
}
