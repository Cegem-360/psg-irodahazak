@props(['properties'])

<div class="relative bg-cover bg-center bg-no-repeat"
    style="background-image: url({{ Vite::asset('resources/images/the-office-building-2025-04-02-15-55-34-utc.webp') }});">
    <div class="absolute inset-0 z-1 bg-linear-to-b from-white to-white/30"></div>
    <div class="kiemelt-ajanlatok relative z-10 container mx-auto pt-12 pb-20">
        <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
            {{ __('Featured Offers') }}</h2>
        <div
            class="swiper kiemeltajanlatok-swiper grid! gap-4 max-w-7xl mx-auto">
            <div class="swiper-wrapper">
                @foreach ($properties as $property)
                    <livewire:property-card :property="$property" :key="$property->id" :swiper="true" />
                @endforeach
            </div>
        </div>
    </div>
    <div
        class="swiper-button-prev kiemelt-button-prev hidden! lg:flex! text-accent! bg-white/40 hover:bg-white/60 shadow rounded after:text-2xl! after:font-bold! after:drop-shadow">
    </div>
    <div
        class="swiper-button-next kiemelt-button-next hidden! lg:flex! text-accent! bg-white/40 hover:bg-white/60 shadow rounded after:text-2xl! after:font-bold! after:drop-shadow">
    </div>
</div>
