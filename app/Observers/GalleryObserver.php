<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Gallery;
use App\Services\WatermarkService;
use Illuminate\Support\Facades\Storage;

final class GalleryObserver
{
    private WatermarkService $watermarkService;

    public function __construct(WatermarkService $watermarkService)
    {
        $this->watermarkService = $watermarkService;
    }

    /**
     * Handle the Gallery "created" event.
     */
    public function created(Gallery $gallery): void
    {
        // Vízjel alkalmazása a létrehozott képre
        if ($gallery->path) {
            $this->watermarkService->applyWatermark($gallery->path, $gallery->target_table);

            // Különböző méretek létrehozása vízjellel (opcionális)
            $sizes = ['160x160', '300x200', '800x600', '1200x800'];
            $this->watermarkService->createWatermarkedSizes($gallery->path, $sizes, $gallery->target_table);
        }
    }

    /**
     * Handle the Gallery "updating" event.
     */
    public function updating(Gallery $gallery): void
    {
        // Ha új kép van feltöltve frissítéskor
        if (request()->hasFile('image_file')) {
            // Töröljük a régi képet
            if ($gallery->path && Storage::disk('public')->exists(str_replace('./', '', $gallery->path))) {
                Storage::disk('public')->delete(str_replace('./', '', $gallery->path));
            }

            $file = request()->file('image_file');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('uploads/gallery', $filename, 'public');

            $gallery->path = './'.$path;
            $gallery->path_without_size_and_ext = './'.pathinfo($path, PATHINFO_DIRNAME).'/'.pathinfo($path, PATHINFO_FILENAME);
        }
    }

    /**
     * Handle the Gallery "updated" event.
     */
    public function updated(Gallery $gallery): void
    {
        // Ha új kép lett feltöltve, alkalmazunk vízjelet
        if ($gallery->wasChanged('path') && $gallery->path) {
            $this->watermarkService->applyWatermark($gallery->path, $gallery->target_table);

            // Különböző méretek létrehozása vízjellel (opcionális)
            $sizes = ['160x160', '300x200', '800x600', '1200x800'];
            $this->watermarkService->createWatermarkedSizes($gallery->path, $sizes, $gallery->target_table);
        }
    }

    /**
     * Handle the Gallery "deleted" event.
     */
    public function deleted(Gallery $gallery): void
    {
        // Töröljük a képfájlt, amikor törölják a gallery rekordot
        if ($gallery->path && Storage::disk('public')->exists(str_replace('./', '', $gallery->path))) {
            Storage::disk('public')->delete(str_replace('./', '', $gallery->path));
        }
    }
}
