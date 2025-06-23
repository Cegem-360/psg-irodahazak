<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\BlogPost;
use App\Services\WatermarkService;
use Illuminate\Support\Facades\Storage;

final class BlogPostObserver
{
    private WatermarkService $watermarkService;

    public function __construct(WatermarkService $watermarkService)
    {
        $this->watermarkService = $watermarkService;
    }

    /**
     * Handle the BlogPost "created" event.
     */
    public function created(BlogPost $blogPost): void
    {
        $this->applyWatermarkToFeaturedImage($blogPost);
    }

    /**
     * Handle the BlogPost "updated" event.
     */
    public function updated(BlogPost $blogPost): void
    {
        // Ha a featured_image megváltozott, alkalmazunk vízjelet
        if ($blogPost->wasChanged('featured_image') && $blogPost->featured_image) {
            $this->applyWatermarkToFeaturedImage($blogPost);
        }
    }

    /**
     * Vízjel alkalmazása a kiemelt képre
     */
    private function applyWatermarkToFeaturedImage(BlogPost $blogPost): void
    {
        if (! $blogPost->featured_image) {
            return;
        }

        // A featured_image már storage path formátumban van
        $imagePath = $blogPost->featured_image;

        // Vízjel alkalmazása
        $this->watermarkService->applyWatermark($imagePath, 'blog');

        // Különböző méretek létrehozása vízjellel
        $sizes = ['300x200', '600x400', '800x533', '1200x800'];
        $this->watermarkService->createWatermarkedSizes($imagePath, $sizes, 'blog');
    }
}
