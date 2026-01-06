@use('App\Models\Translate')
@props(['property'])

@php
    $firstImage = $property->getFirstImageUrl();
@endphp

<a href="{{ localized_route('properties.show', $property) }}"
    class="block bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 cursor-pointer">
    @if ($firstImage)
        <div class="aspect-[4/3] overflow-hidden">
            <img src="{{ $firstImage }}" alt="{{ $property->title }}"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" loading="lazy">
        </div>
    @else
        <div class="aspect-[4/3] bg-gray-100 flex items-center justify-center">
            <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    @endif

    <div class="p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-2">
            @if (app()->getLocale() === 'en')
                {{ Translate::whereName($property->title)->first()?->translated ?: $property->title }}
            @else
                {{ $property->title }}
            @endif
        </h3>

        <div class="flex justify-between items-center">
            @if (collect($property->property_photos)->count() > 0)
                <span class="text-sm text-gray-500">{{ collect($property->property_photos)->count() }} kép</span>
            @endif

            @if ($property->status)
                <span
                    class="px-2 py-1 text-xs rounded-full {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $property->status === 'active' ? 'Aktív' : 'Inaktív' }}
                </span>
            @endif
        </div>
    </div>
</a>
