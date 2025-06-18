@props(['property'])

@php
    // Ha Property objektumot kapunk, lekérjük a képeket
    $images = $property instanceof \App\Models\Property ? $property->images : collect();
@endphp

@if ($images->count() > 0)
    <div class="space-y-4">
        <div class="swiper gallery-carousel-swiper rounded-xl">
            <div class="swiper-wrapper">
                @foreach ($images as $image)
                    <div class="swiper-slide">
                        <img src="{{ $image->image_url }}" alt="{{ $image->alt ?? ($property->title ?? 'Galéria kép') }}"
                            class="w-full h-auto object-cover aspect-[4/3]">
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div
                class="swiper-button-next !text-accent bg-white/60 shadow rounded after:!text-xl after:!font-bold after:drop-shadow">
            </div>
            <div
                class="swiper-button-prev !text-accent bg-white/60 shadow rounded after:!text-xl after:!font-bold after:drop-shadow">
            </div>
        </div>
        <div class="swiper gallery-carousel-swiper-thumbs" thumbsSlider="">
            <div class="swiper-wrapper">
                @foreach ($images as $image)
                    <div class="swiper-slide p-1 cursor-pointer">
                        <img src="{{ $image->getImageUrl('160x160') }}"
                            alt="{{ $image->alt ?? ($property->title ?? 'Galéria kép') }}"
                            class="w-20 h-20 object-cover rounded-xl">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="bg-gray-100 rounded-xl aspect-[4/3] flex items-center justify-center">
        <div class="text-center text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                    clip-rule="evenodd" />
            </svg>
            <p>Nincsenek elérhető képek</p>
        </div>
    </div>
@endif
