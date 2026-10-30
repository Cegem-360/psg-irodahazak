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

        if (blank(config('seo.indexnow.key')) || $property->status !== 'active' || blank($property->slug)) {
            return;
        }

        $route = $property->elado_v_kiado === 'elado-iroda' ? 'properties.show-for-sale' : 'properties.show';

        SubmitUrlsToIndexNow::dispatchAfterResponse([route($route, ['property' => $property->slug])]);
    }

    public function deleted(Property $property): void
    {
        Property::forgetDistrictCounts();
    }
}
