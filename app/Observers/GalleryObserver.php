<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

final class GalleryObserver
{
    /**
     * Handle the Gallery "creating" event.
     */
    public function creating(Gallery $gallery): void
    {
        // Ha van feltöltött kép fájl, állítsuk be a path mezőket
        if (request()->hasFile('image_file')) {
            $file = request()->file('image_file');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('uploads/gallery', $filename, 'public');

            $gallery->path = './'.$path;
            $gallery->path_without_size_and_ext = './'.pathinfo($path, PATHINFO_DIRNAME).'/'.pathinfo($path, PATHINFO_FILENAME);

            // Automatikusan beállítjuk a target_table-t, ha nincs megadva
            if (! $gallery->target_table) {
                $gallery->target_table = 'property';
            }
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
