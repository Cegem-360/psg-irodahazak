<?php

declare(strict_types=1);

namespace App\Observers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

final class PropertyObserver
{
    public function updating($property)
    {
        $originalPhotos = $property->getOriginal('property_photos') ?? [];
        $newPhotos = $property->property_photos ?? [];

        $deletedPhotos = array_diff($originalPhotos, $newPhotos);

        foreach ($deletedPhotos as $photo) {
            $filePath = 'property/'.$property->id.'/gallery_images/'.$photo;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            Log::info("Deleted property photo: {$filePath}");
        }
    }
}
