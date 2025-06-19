@props(['images' => [], 'title' => 'Ingatlan Galéria'])

<div class="space-y-4">
    <div class="swiper gallery-carousel-swiper rounded-xl">
        <div class="swiper-wrapper">
            @dump($images)
            @foreach ($images ?? [] as $image)
                <div class="swiper-slide">
                    <img src="{{ $image->getImageUrl('800x600', 'jpg') }}" alt="{{ $title }}"
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
            @foreach ($images ?? [] as $image)
                <div class="swiper-slide p-1 cursor-pointer">
                    <img src="{{ $image->getImageUrl('160x160', 'jpg') }}" alt="{{ $title }}"
                        class="w-full h-auto object-cover aspect-[16/9] rounded-xl">
                </div>
            @endforeach
        </div>
    </div>
</div>
