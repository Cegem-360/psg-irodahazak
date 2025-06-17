<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected $casts = [
        'date' => 'datetime',
        'ord' => 'integer',
        'target_table_id' => 'integer',
        'gallery_category_id' => 'integer',
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
        // Remove the leading "./" from the path
        $path = mb_ltrim($this->path, './');

        // Return the full URL using asset() helper
        return asset($path);
    }

    /**
     * Get the public URL for the image
     */
    public function getPublicUrlAttribute(): string
    {
        // Remove the leading "./" from the path
        $path = mb_ltrim($this->path, './');

        // Return the public URL
        return url($path);
    }

    /**
     * Get different sizes of the image
     */
    public function getImageUrl(?string $size = null): string
    {
        if (! $size) {
            return $this->image_url;
        }

        // Build the path with the specified size
        $pathWithoutExt = $this->path_without_size_and_ext;
        $extension = pathinfo($this->path, PATHINFO_EXTENSION);
        $newPath = $pathWithoutExt.'_'.$size.'.'.$extension;

        // Remove the leading "./" from the path
        $path = mb_ltrim($newPath, './');

        return asset($path);
    }

    /**
     * Check if the image file exists
     */
    public function imageExists(): bool
    {
        $path = mb_ltrim($this->path, './');

        return file_exists(public_path($path));
    }

    /**
     * Get the relationship to the property
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'target_table_id');
    }
}
