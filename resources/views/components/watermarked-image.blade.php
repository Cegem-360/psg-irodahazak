@props([
    'path' => null,
    'size' => null,
    'alt' => 'Kép',
    'class' => 'w-full h-auto object-cover',
    'showPlaceholder' => true,
])

@php
    use Illuminate\Support\Facades\Storage;

    $imageUrl = null;

    if ($path) {
        if ($size) {
            // Ha van size megadva, használjuk a megfelelő méretű változatot
            $pathInfo = pathinfo($path);
            $directory = $pathInfo['dirname'];
            $filename = $pathInfo['filename'];
            $extension = $pathInfo['extension'] ?? 'jpg';

            $sizedPath = "{$directory}/{$filename}_{$size}.{$extension}";

            // Ellenőrizzük, hogy létezik-e a méretezett változat
            if (Storage::disk('public')->exists(ltrim($sizedPath, './'))) {
                $imageUrl = Storage::url(ltrim($sizedPath, './'));
            } else {
                // Ha nincs méretezett változat, használjuk az eredetit
                $imageUrl = Storage::url(ltrim($path, './'));
            }
        } else {
            $imageUrl = Storage::url(ltrim($path, './'));
        }
    }
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
        <span class="ml-2 text-gray-500 text-sm">{{ $alt }}</span>
    </div>
@endif
