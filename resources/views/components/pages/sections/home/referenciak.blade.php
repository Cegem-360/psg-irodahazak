@use('App\Models\Reference')
<div class="referenciak my-12">
    <h2 class="my-16 font-bold text-gray-500 text-5xl text-center drop-shadow text-logogray/80">
        Referenciák, akik velünk költöztek</h2>
    <div class="py-8 bg-[#EFEFEF]">
        <div class="reference-swiper grid _grid-cols-2 sm:grid-cols-3 lg:grid-cols-5_ gap-4 max-w-screen-xl mx-auto">
            {{-- <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                <img class="max-w-[90%] object-contain"
                    src="{{ Vite::asset('resources/images/aip_logo_800x600.jpg') }}" />
            </div>
            <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                <img class="max-w-[90%] object-contain"
                    src="{{ Vite::asset('resources/images/datapao_logo_800x600.png') }}" />
            </div>
            <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                <img class="max-w-[90%] object-contain"
                    src="{{ Vite::asset('resources/images/collabit_logo_800x600.png') }}" />
            </div>
            <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                <img class="max-w-[90%] object-contain"
                    src="{{ Vite::asset('resources/images/welsec_logo_800x600.png') }}" />
            </div>
            <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                <img class="max-w-[90%] object-contain"
                    src="{{ Vite::asset('resources/images/artera_800x600.jpg') }}" />
            </div> --}}
            <div class="swiper-wrapper">
                @foreach (Reference::active()->orderBy('order')->get() ?? [] as $reference)
                    <div class="swiper-slide !flex items-center justify-center px-12 py-4 bg-white rounded-xl">
                        <img class="max-h-20 object-contain object-center" src="{{ Storage::url($reference->image) }}" />
                    </div>
                @endforeach
            </div>
            {{-- <div class="swiper-pagination"></div> --}}
            {{-- <div
                class="reference-button-prev !text-accent bg-black/60 shadow rounded after:!text-xl after:!font-bold after:drop-shadow">
            </div>
            <div
                class="reference-button-next !text-accent bg-black/60 shadow rounded after:!text-xl after:!font-bold after:drop-shadow">
            </div> --}}
        </div>
    </div>
</div>
