<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\News;
use App\Services\WatermarkService;
use Illuminate\Support\Facades\Storage;

final class NewsObserver
{
    private WatermarkService $watermarkService;

    public function __construct(WatermarkService $watermarkService)
    {
        $this->watermarkService = $watermarkService;
    }

    /**
     * Handle the News "created" event.
     */
    public function created(News $news): void
    {
        $this->applyWatermarkToFeaturedImage($news);
    }

    /**
     * Handle the News "updated" event.
     */
    public function updated(News $news): void
    {
        // Ha a featured_image megváltozott, alkalmazunk vízjelet
        if ($news->wasChanged('featured_image') && $news->featured_image) {
            $this->applyWatermarkToFeaturedImage($news);
        }
    }

    /**
     * Vízjel alkalmazása a kiemelt képre
     */
    private function applyWatermarkToFeaturedImage(News $news): void
    {
        if (! $news->featured_image) {
            return;
        }

        // A featured_image már storage path formátumban van
        $imagePath = $news->featured_image;

        // Vízjel alkalmazása
        $this->watermarkService->applyWatermark($imagePath, 'news');

        // Különböző méretek létrehozása vízjellel
        $sizes = ['300x200', '600x400', '800x533', '1200x800'];
        $this->watermarkService->createWatermarkedSizes($imagePath, $sizes, 'news');
    }
}
