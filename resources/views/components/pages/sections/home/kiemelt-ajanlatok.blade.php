@use('App\Models\Property')
<div class="relative bg-cover bg-center bg-no-repeat"
    style="background-image: url({{ Vite::asset('resources/images/the-office-building-2025-04-02-15-55-34-utc.webp') }});">
    <div class="absolute inset-0 z-1 bg-gradient-to-b from-white to-white/30"></div>
    <div class="kiemelt-ajanlatok relative z-10 container mx-auto pt-12 pb-20">
        <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
            {{ __('Featured Offers') }}</h2>
        <div
            class="swiper kiemeltajanlatok-swiper !grid _grid-cols-1 md:grid-cols-2 lg:grid-cols-3_ gap-4 max-w-screen-xl mx-auto">
            <div class="swiper-wrapper">
                @foreach (Property::active()->featured()->get() ?? [] as $property)
                    <livewire:ingatlan-card :property="$property" :image="$property->getFirstImageUrl()" :title="$property->title" :description="$property->getAddressFormated()"
                        :link="localized_route('properties.show', ['property' => $property->slug])" :key="$property->id" :smal="true" :swiper="true" />
                @endforeach
            </div>
        </div>
    </div>
    <div
        class="swiper-button-prev kiemelt-button-prev !text-accent bg-white/40 hover:bg-white/60 shadow rounded after:!text-2xl after:!font-bold after:drop-shadow">
    </div>
    <div
        class="swiper-button-next kiemelt-button-next !text-accent bg-white/40 hover:bg-white/60 shadow rounded after:!text-2xl after:!font-bold after:drop-shadow">
    </div>
</div>
