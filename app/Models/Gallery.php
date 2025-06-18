<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

        return asset($this->path);
    }

    /**
     * Get the public URL for the image
     */
    public function getPublicUrlAttribute(): string
    {
        return asset($this->path);
    }

    /**
     * Get different sizes of the image
     */
    public function getImageUrl(?string $size = null, string $extension = 'jpg'): string
    {
        if (! $size) {
            return asset($this->path);
        }

        $newPath = $this->path_without_size_and_ext.'_'.$size.'.'.$extension;

        return asset($newPath);

    }

    /**
     * Check if the image file exists
     */
    public function imageExists(): bool
    {
        return Storage::disk('public')->exists($this->path);
    }

    /**
     * Get the relationship to the property
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'target_table_id');
    }
}
