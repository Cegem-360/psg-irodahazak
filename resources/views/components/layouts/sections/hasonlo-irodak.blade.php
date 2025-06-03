    <div class="relative bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ Vite::asset('resources/images/reflections-in-modern-dutch-design-architecture-2025-03-23-22-04-59-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white to-white/30"></div>
        <div class="kiemelt-ajanlatok relative z-10 container mx-auto pt-12 pb-20">
            <h2
                class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow bg-clip-text text-transparent bg-gradient-to-r from-accentdark to-accent">
                Hasonló irodák</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-screen-xl mx-auto">
                <x-layouts.cards.ingatlan-card
                    image="{{ Vite::asset('resources/images/andrassy_palace_iroda_5__384x246.jpg') }}"
                    title="Andrássy Palace Iroda" :description="'1061 Budapest, Andrássy út 9.<br><strong>Bérleti díj:</strong> 16 - 17 EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2990 HUF/m2/hó'" />
                <x-layouts.cards.ingatlan-card
                    image="{{ Vite::asset('resources/images/arena_corner_irodahaz_1__384x246.jpg') }}"
                    title="Arena Corner" :description="'1087 Budapest, Hungária körút 40.<br><strong>Bérleti díj:</strong> 14.5 - 15.5 EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2200 HUF/m2/hó'" />
                <x-layouts.cards.ingatlan-card
                    image="{{ Vite::asset('resources/images/bank_center_1_2_3_4_5_384x246.jpg') }}" title="Bank Center"
                    :description="'1054 Budapest, Szabadság tér 7.<br><strong>Bérleti díj:</strong> 22 - 26 EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2700 HUF/m2/hó'" />
            </div>
        </div>
    </div>
