<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\SubmitUrlsToIndexNow;
use App\Models\Property;
use App\Models\PropertyRedirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class PropertyObserver
{
    /**
     * Fills in a missing slug from the title.
     */
    public function saving(Property $property): void
    {
        if (blank($property->slug)) {
            $property->slug = Str::slug((string) $property->title, language: 'hu');
        }
    }

    /**
     * Deletes the photos that were removed from the gallery.
     */
    public function updating(Property $property): void
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
     * Pings IndexNow with the property's pages after every save in the admin:
     * inactive properties keep a public page too.
     */
    public function saved(Property $property): void
    {
        Property::forgetDistrictCounts();

        $this->pingIndexNow($property);
    }

    /**
     * A deleted property keeps its page as an inactive data sheet; search engines
     * are told to look at it again.
     */
    public function deleted(Property $property): void
    {
        Property::forgetDistrictCounts();

        $this->pingIndexNow($property);
    }

    /**
     * A property deleted for good leaves a 301 behind to its district's page.
     */
    public function forceDeleted(Property $property): void
    {
        PropertyRedirect::rememberDeleted($property);
    }

    private function pingIndexNow(Property $property): void
    {
        if (blank(config('seo.indexnow.key')) || blank($property->slug)) {
            return;
        }

        SubmitUrlsToIndexNow::dispatchAfterResponse($property->publicUrls());
    }
}
