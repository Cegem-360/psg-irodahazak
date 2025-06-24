<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Gallery;

final class GalleryObserver
{
    /**
     * Handle the Gallery "created" event.
     */
    public function created(Gallery $gallery): void {}

    /**
     * Handle the Gallery "updating" event.
     */
    public function updating(Gallery $gallery): void {}

    /**
     * Handle the Gallery "updated" event.
     */
    public function updated(Gallery $gallery): void {}

    /**
     * Handle the Gallery "deleted" event.
     */
    public function deleted(Gallery $gallery): void {}
}
