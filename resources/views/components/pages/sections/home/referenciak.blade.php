@use('App\Models\Reference')
<div class="referenciak my-12">
    <h2 class="my-16 font-bold text-gray-500 text-5xl text-center drop-shadow text-logogray/80">
        {{ __('References, who moved with us') }}</h2>
    <div class="relative py-8 bg-[#EFEFEF]">
        <div
            class="swiper reference-swiper !grid _grid-cols-2 sm:grid-cols-3 lg:grid-cols-5_ gap-4 max-w-screen-xl mx-auto">

            <div class="swiper-wrapper">
                @foreach (Reference::active()->orderBy('order')->get() ?? [] as $reference)
                    <div class="swiper-slide !flex items-center justify-center px-12 py-4 bg-white rounded-xl">
                        <img class="max-h-20 object-contain object-center" src="{{ Storage::url($reference->image) }}" />
                    </div>
                @endforeach
            </div>
        </div>
        <div
            class="swiper-button-prev reference-button-prev !text-accent hover:bg-black/10 hover:shadow rounded after:!text-2xl after:!font-bold after:drop-shadow">
        </div>
        <div
            class="swiper-button-next reference-button-next !text-accent hover:bg-black/10 hover:shadow rounded after:!text-2xl after:!font-bold after:drop-shadow">
        </div>
    </div>
</div>
