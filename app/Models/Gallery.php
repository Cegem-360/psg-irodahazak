<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\GalleryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[ObservedBy(GalleryObserver::class)]
final class Gallery extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'path',
        'target_table_id',
        'ord',
        'size',
        'date',
        'target_table',
        'path_without_size_and_ext',
        'alt',
        'gallery_category_id',
        'video_url',
        'image_file', // Virtual field for file upload
        'images', // JSON array of image filenames
        'sort',
    ];

    protected $casts = [
        'date' => 'datetime',
        'ord' => 'integer',
        'target_table_id' => 'integer',
        'gallery_category_id' => 'integer',
        'images' => 'array',
    ];

    protected $attributes = [
        'ord' => 0,
        'gallery_category_id' => 0,
    ];

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute(): string
    {

        return asset($this->path);
    }

    /**
     * Get the public URL for the image
     */
    public function getPublicUrlAttribute(): string
    {
        return Storage::url($this->path);
    }

    /**
     * Get different sizes of the image
     */
    public function getImageUrl(?string $size = null, string $extension = 'jpg'): string
    {
        if (! $size) {
            return Storage::url($this->path);
        }

        $newPath = $this->path_without_size_and_ext.'_'.$size.'.'.$extension;

        return Storage::url($newPath);
    }

    /**
     * Check if the image file exists
     */
    public function imageExists(): bool
    {
        return Storage::disk('public')->exists($this->path);
    }

    /**
     * Get all images for this gallery property
     */
    public function getAllImages(): array
    {
        return $this->images ?? [];
    }

    /**
     * Get unique images (without duplicates based on filename prefix)
     */
    public function getUniqueImages(): array
    {
        $images = $this->getAllImages();
        $unique = [];
        $seen = [];

        foreach ($images as $image) {
            // Extract the base name (without size and extension)
            $baseName = preg_replace('/_\d+x\d+\.(jpg|png|jpeg)$/', '', $image);

            if (! in_array($baseName, $seen)) {
                $seen[] = $baseName;
                $unique[] = $image;
            }
        }

        return $unique;
    }

    /**
     * Get images by size pattern
     */
    public function getImagesBySize(string $size): array
    {
        $images = $this->getAllImages();

        return array_filter($images, function ($image) use ($size): bool {
            return mb_strpos($image, sprintf('_%s.', $size)) !== false;
        });
    }

    /**
     * Get the first image of a specific size
     */
    public function getFirstImageBySize(string $size): ?string
    {
        $images = $this->getImagesBySize($size);

        return $images === [] ? null : array_values($images)[0];
    }

    /**
     * Get full URL for an image from the images array
     */
    public function getImageUrlFromArray(string $filename): string
    {
        $path = sprintf('property/%s/gallery/%s', $this->target_table_id, $filename);

        return Storage::url($path);
    }

    /**
     * Get the relationship to the property
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'target_table_id');
    }
}
