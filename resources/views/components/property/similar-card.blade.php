@props(['property', 'small' => false])

{{-- x-data: the buttons' @click needs an Alpine scope, and this card is not inside a Livewire component. --}}
<div x-data
    class="group relative bg-white/10 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl hover:brightness-95 transition-all duration-300 ease-in-out border border-white/15">
    <img src="{{ $property->getFirstImageUrl() ?: Vite::asset('resources/images/default-office.jpg') }}"
        alt="{{ $property->title }}" class="w-full h-auto object-cover aspect-3/2" loading="lazy" />
    <div class="absolute bottom-64 right-2 flex gap-1">
        {{-- Map icon box --}}
        <button type="button"
            @click="$dispatch('show-map-modal', {{ Js::from(['title' => $property->title, 'propertyId' => $property->id]) }})"
            class="bg-orange-500 hover:bg-orange-600 text-white p-2 rounded shadow-lg transition-colors duration-200">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                    clip-rule="evenodd" />
            </svg>
        </button>

        {{-- Phone icon box --}}
        <button type="button"
            @click="$dispatch('show-phone-modal', {{ Js::from(['title' => $property->title, 'propertyId' => $property->id]) }})"
            class="bg-orange-500 hover:bg-orange-600 text-white p-2 rounded shadow-lg transition-colors duration-200">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
            </svg>
        </button>
    </div>
    <div @class(['p-3 pl-4' => $small, 'p-6 pl-8' => !$small])>
        <h3 @class(['text-lg' => $small, 'text-xl' => !$small, 'font-bold mb-2'])>{{ $property->title }}</h3>
        <p @class([
            'text-gray-700 text-xs min-h-16' => $small,
            'text-gray-700 min-h-24' => !$small,
        ])>
            <x-property.summary :$property /></p>
        <a wire:navigate.hover href="{{ $property->url() }}" @class([
            'inline-block',
            'mb-2 px-3 py-1 text-sm' => $small,
            'mb-4 px-6 py-2' => !$small,
            'bg-primary/70 text-white rounded group-hover:bg-primary/90 transition-colors duration-300 ease-in-out',
        ])>
            {{ __('More details') }}
        </a>
        {{-- Icon boxes positioned at bottom-left of image --}}

    </div>

</div>
