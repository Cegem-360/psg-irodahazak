<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Property;

final class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Property::with('images')->active();

        // Filter by districts (multiple)
        if (request('districts')) {
            $districts = explode(',', request('districts'));
            $districts = array_map('trim', $districts); // Remove any extra whitespace
            $districts = array_filter($districts); // Remove empty values

            if (! empty($districts)) {
                $query->where(function ($q) use ($districts) {
                    foreach ($districts as $district) {
                        $q->orWhere('cim_varos', 'like', '%'.$district.'%');
                    }
                });
            }
        }

        // Filter by district (single - for backward compatibility)
        if (request('district') && ! request('districts')) {
            $query->where('cim_varos', 'like', '%'.request('district').'%');
        }

        // Filter by office building name
        if (request('office_name')) {
            $query->where('title', 'like', '%'.request('office_name').'%');
        }

        // Filter by search term
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.request('search').'%')
                    ->orWhere('content', 'like', '%'.request('search').'%')
                    ->orWhere('lead', 'like', '%'.request('search').'%');
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
            $query->whereBetween('max_berleti_dij', [$priceMin, $priceMax]);
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
    public function show(Property $property)
    {
        $property->load('images');

        return view('properties.show', ['property' => $property]);
    }

    /**
     * API endpoint to get property images
     */
    public function images(Property $property)
    {
        $images = $property->images()->orderBy('ord')->get()->map(function ($image): array {
            return [
                'id' => $image->id,
                'url' => $image->image_url,
                'alt' => $image->alt,
                'size' => $image->size,
                'order' => $image->ord,
            ];
        });

        return response()->json($images);
    }

    /**
     * Get property images in different sizes
     */
    public function imagesWithSize(Property $property, $size = null)
    {
        $images = $property->images()->orderBy('ord')->get()->map(function ($image) use ($size): array {
            return [
                'id' => $image->id,
                'url' => $image->getImageUrl($size),
                'alt' => $image->alt,
                'size' => $size ?? $image->size,
                'order' => $image->ord,
            ];
        });

        return response()->json($images);
    }

    /**
     * Search office names for autocomplete
     */
    public function searchOfficeNames()
    {
        $searchTerm = request('q', '');
        
        if (strlen($searchTerm) < 2) {
            return response()->json([]);
        }
        
        $offices = Property::active()
            ->where('title', 'like', '%' . $searchTerm . '%')
            ->select('title', 'cim_varos')
            ->distinct()
            ->orderBy('title')
            ->limit(10)
            ->get();
        
        return response()->json($offices);
    }
}
