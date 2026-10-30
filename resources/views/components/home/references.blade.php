<div class="referenciak my-12">
    <h2 class="my-16 font-bold text-gray-500 text-5xl text-center drop-shadow text-logogray/80">
        {{ __('References, who moved with us') }}</h2>
    <div class="relative py-8 bg-[#EFEFEF]">
        <div
            class="swiper reference-swiper grid! gap-4 max-w-7xl mx-auto">
            <div class="swiper-wrapper">
                @foreach ($references as $reference)
                    <div class="swiper-slide flex! items-center justify-center px-12 py-4 bg-white rounded-xl">
                        <img class="max-h-20 object-contain object-center" src="{{ Storage::url($reference->image) }}"
                            alt="{{ $reference->name }}" loading="lazy" />
                    </div>
                @endforeach
            </div>
        </div>
        <div
            class="swiper-button-prev reference-button-prev hidden! lg:flex! text-accent! hover:bg-black/10 hover:shadow rounded after:text-2xl! after:font-bold! after:drop-shadow">
        </div>
        <div
            class="swiper-button-next reference-button-next hidden! lg:flex! text-accent! hover:bg-black/10 hover:shadow rounded after:text-2xl! after:font-bold! after:drop-shadow">
        </div>
    </div>
</div>
