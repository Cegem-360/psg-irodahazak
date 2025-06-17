@props([
    'property',
    'size' => null,
    'class' => 'w-full h-auto object-cover',
    'alt' => null,
    'showPlaceholder' => true,
])

@php
    $imageUrl = null;

    if ($property instanceof \App\Models\Property) {
        $firstImage = $property->images->first();
        if ($firstImage) {
            $imageUrl = $firstImage->getImageUrl($size);
            $alt = $alt ?? ($firstImage->alt ?? $property->title);
        }
    }

    $alt = $alt ?? 'Ingatlan kép';
@endphp

@if ($imageUrl)
    <img src="{{ $imageUrl }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => $class]) }}>
@elseif($showPlaceholder)
    <div {{ $attributes->merge(['class' => $class . ' bg-gray-100 flex items-center justify-center']) }}>
        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                clip-rule="evenodd" />
        </svg>
    </div>
@endif
