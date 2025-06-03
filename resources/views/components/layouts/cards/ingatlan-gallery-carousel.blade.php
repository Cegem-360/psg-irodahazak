@props(['images', 'title'])
@php
    $images = is_array($images) ? $images : (empty($images) ? [] : [$images]);
@endphp

<div class="space-y-4">
    <div class="swiper gallery-carousel-swiper rounded-xl">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
                <div class="swiper-slide">
                    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-auto object-cover">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <div class="swiper gallery-carousel-swiper-thumbs" thumbsSlider="">
        <div class="swiper-wrapper">
            @foreach ($images as $image)
                <div class="swiper-slide">
                    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-auto object-cover">
                </div>
            @endforeach
        </div>
    </div>
</div>
