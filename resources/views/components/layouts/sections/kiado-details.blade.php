@php
    // Get the images ftom storage/app/public/ingatlan/gallery
    $images = [
        Storage::url('ingatlan/gallery/akademia_business_center_1__1_800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_1__800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_5__1_800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_6__1_800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_3__800x600.webp'),
    ];
@endphp

<div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
    style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
    <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
    <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
        <h2 class="mt-4 mb-4 font-bold text-5xl text-center drop-shadow text-logogray/80">
            Kiadó irodák</h2>
        <h4 class="text-xl text-center mb-16">(238 találat)</h2>
            <div
                class="flex justify-end gap-8 max-w-screen-xl mx-auto px-8 py-3 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="">
                    <form action="#" class="">
                        <div>
                            <select id="szuro"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <option selected value="1">Név szerint növekvő</option>
                                <option value="2">Név szerint csökkenő</option>
                                <option value="3">Ár szerint növekvő</option>
                                <option value="4">Ár szerint csökkenő</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="relative">
                    <iframe class="sticky top-8 h-[120vh]"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2695.3752330104103!2d19.04358067667799!3d47.502083195188725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741dc15d6bf2925%3A0xd7e6926bead52fbc!2sAcademia%20Offices%20%2F%20Irodah%C3%A1z!5e0!3m2!1shu!2shu!4v1749023556934!5m2!1shu!2shu"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($images as $image)
                        <x-layouts.cards.ingatlan-card image="{{ $image }}" small title="Academia Irodaház"
                            :description="'1061 Budapest, Andrássy út 9.<br><strong>Bérleti díj:</strong> 16 - 17 EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2990 HUF/m2/hó'" link="/kiado-irodak/academia-irodahaz" />
                    @endforeach
                </div>
            </div>
    </div>
</div>
