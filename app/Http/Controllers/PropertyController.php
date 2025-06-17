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
        $properties = Property::with('images')
            ->active()
            ->orderBy('ord')
            ->paginate(12);

        return view('properties.index', compact('properties'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load('images');

        return view('properties.show', compact('property'));
    }

    /**
     * API endpoint to get property images
     */
    public function images(Property $property)
    {
        $images = $property->images()->orderBy('ord')->get()->map(function ($image) {
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
        $images = $property->images()->orderBy('ord')->get()->map(function ($image) use ($size) {
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
}
