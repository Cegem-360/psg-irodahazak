<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        $query = Property::query()->active();

        // Filter by districts (multiple)
        if (request('districts')) {
            $districts = explode(',', (string) request('districts'));
            $districts = array_map(trim(...), $districts); // Remove any extra whitespace
            $districts = array_filter($districts); // Remove empty values

            if ($districts !== []) {
                $query->where(function ($q) use ($districts): void {
                    foreach ($districts as $district) {
                        $q->orWhere('city', 'like', '%'.$district.'%');
                    }
                });
            }
        }

        // Filter by district (single - for backward compatibility)
        if (request('district') && ! request('districts')) {
            $query->where('city', 'like', '%'.request('district').'%');
        }

        // Filter by office building name
        if (request('office_name')) {
            $query->where('title', 'like', '%'.request('office_name').'%');
        }

        // Filter by search term
        if (request('search')) {
            $query->where(function ($q): void {
                $q->where('title', 'like', '%'.request('search').'%')
                    ->orWhere('content', 'like', '%'.request('search').'%');
            });
        }

        // Filter by area range
        if (request('area_min') || request('area_max')) {
            $areaMin = request('area_min', 0);
            $areaMax = request('area_max', 9999999);
            $query->whereBetween('total_area', [$areaMin, $areaMax]);
        }

        // Filter by rental price range
        if (request('price_min') || request('price_max')) {
            $priceMin = request('price_min', 0);
            $priceMax = request('price_max', 9999999);
            $query->whereBetween('max_rent', [$priceMin, $priceMax]);
        }

        // Filter by rental properties only if rental filter is applied
        if (request('type') === 'rent') {
            $query->rent();
        }

        $properties = $query->orderBy('ord')->paginate(12);

        return view('properties.index', ['properties' => $properties]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property): Factory|View
    {
        // Inactive listings stay viewable for signed-in admins, who use the page as a preview
        abort_unless($property->isActive() || auth()->check(), 404);

        // Apply the appropriate scope based on property type
        $similarPropertiesQuery = Property::query()->where('id', '!=', $property->id)
            ->whereDistrict($property->district)
            ->active();

        // If property is for sale, apply sale scope, otherwise apply rent scope
        if ($property->isSale()) {
            $similarPropertiesQuery->sale();
        } else {
            $similarPropertiesQuery->rent();
        }

        $similarProperties = $similarPropertiesQuery
            ->inRandomOrder()
            ->limit(3)
            ->get();

        // If we don't have enough similar properties from the same district,
        // get additional ones from other districts
        if ($similarProperties->count() < 3) {
            $additionalCount = 3 - $similarProperties->count();
            $excludeIds = $similarProperties->pluck('id')->push($property->id)->toArray();

            $additionalQuery = Property::query()->whereNotIn('id', $excludeIds)
                ->active();

            // Apply the same scope for additional properties
            if ($property->isSale()) {
                $additionalQuery->sale();
            } else {
                $additionalQuery->rent();
            }

            $additionalProperties = $additionalQuery
                ->inRandomOrder()
                ->limit($additionalCount)
                ->get();

            $similarProperties = $similarProperties->merge($additionalProperties);
        }

        return view('properties.show', [
            'property' => $property,
            'similarProperties' => $similarProperties,
        ]);
    }
}
