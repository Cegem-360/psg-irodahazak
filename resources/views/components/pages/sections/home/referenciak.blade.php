@use('App\Models\Reference')
<div class="referenciak my-12">
    <h2 class="my-16 font-bold text-gray-500 text-5xl text-center drop-shadow text-logogray/80">
        Referenciák, akik velünk költöztek</h2>
    <div class=" py-8 bg-[#EFEFEF]">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 max-w-screen-xl mx-auto">
            <div class="flex items-center justify-center p-4 bg-white rounded-xl">
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
            </div>
            @foreach (Reference::active()->orderBy('order')->get() ?? [] as $reference)
                <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                    <img class="max-w-[90%] object-contain" src="{{ Storage::url($reference->image) }}" />
                </div>
            @endforeach
        </div>
    </div>
</div>
