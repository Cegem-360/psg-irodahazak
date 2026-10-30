<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\SubmitUrlsToIndexNow;
use App\Models\Property;
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

            Log::info('Deleted property photo: '.$photo);
        }
    }

    /**
     * Pings IndexNow with the property's page after every save in the admin.
     */
    public function saved(Property $property): void
    {
        Property::forgetDistrictCounts();

        if (blank(config('seo.indexnow.key')) || ! $property->isActive() || blank($property->slug)) {
            return;
        }

        SubmitUrlsToIndexNow::dispatchAfterResponse([$property->url()]);
    }

    public function deleted(Property $property): void
    {
        Property::forgetDistrictCounts();
    }
}
