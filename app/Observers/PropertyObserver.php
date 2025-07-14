<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

final class PropertyObserver
{
    public function updating($property): void
    {
        $originalPhotos = $property->getOriginal('property_photos') ?? [];
        $newPhotos = $property->property_photos ?? [];

        $deletedPhotos = array_diff($originalPhotos, $newPhotos);

        foreach ($deletedPhotos as $photo) {

            if (Storage::disk('public')->exists($photo)) {
                Storage::disk('public')->delete($photo);
            }

            Log::info('Deleted property photo: ' . $photo);
        }
    }
}
