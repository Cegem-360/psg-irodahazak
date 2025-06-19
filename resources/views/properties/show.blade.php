<x-layouts.app>
    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-8 pt-24 pb-20">
            <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ $property->title }}</h2>
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div>
                    <x-cards.ingatlan-gallery-carousel :images="$property->galleryImages()" :title="$property->title" />
                </div>
                <div class="p-4">
                    <h2 class="text-3xl">Adatok</h2>
                    <table class="table-auto w-full mt-4">
                        <tbody>
                            <tr>
                                <td class="bold head">Név:</td>
                                <td class="head">{{ $property->title }}</td>
                            </tr>
                            <tr>
                                <td class="bold">Cím:</td>
                                <td>{{ $property->cim_irsz }} {{ $property->cim_varos }}, {{ $property->cim_utca }}
                                    {{ $property->cim_hazszam }}{{ $property->cim_utca_addons ? ', ' . $property->cim_utca_addons : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bold">Építés éve:</td>
                                <td>{{ $property->construction_year }}</td>
                            </tr>
                            <tr>
                                <td class="bold">Összterület:</td>
                                <td>{{ number_format($property->total_area) }}
                                    {{ $property->osszterulet_addons ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bold">Jelenleg kiadó:</td>
                                <td>{{ $property->jelenleg_kiado }}
                                    {{ $property->jelenleg_kiado_addons ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bold">Min. kiadó:</td>
                                <td>{{ $property->min_kiado }}
                                    {{ $property->min_kiado_addons ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bold">Bérleti díj:</td>
                                <td>{{ $property->min_berleti_dij }}{{ $property->max_berleti_dij ? ' - ' . $property->max_berleti_dij : '' }}
                                    {{ $property->min_berleti_dij_addons ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bold">Üzemeltetési díj:</td>
                                <td>{{ $property->uzemeletetesi_dij }}
                                    {{ $property->uzemeletetesi_dij_addons ?? '' }}</td>
                                </td>
                            </tr>
                            @if ($property->raktar_terulet)
                                <tr>
                                    <td class="bold">Raktár terület:</td>
                                    <td>{{ number_format($property->raktar_terulet) }}
                                        {{ $property->raktar_terulet_addons ?? '' }}
                                    </td>
                                </tr>
                            @endif
                            @if ($property->raktar_berleti_dij)
                                <tr>
                                    <td class="bold">Raktár bérleti díj:</td>
                                    <td>{{ $property->raktar_berleti_dij }}
                                        {{ $property->raktar_berleti_dij_addons ?? '' }}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="bold">Parkolás:</td>
                                <td>{{ $property->parkolas }}</td>
                            </tr>
                            <tr>
                                <td class="bold">Parkolás díja:</td>
                                <td>{{ $property->min_parkolas_dija }}
                                    {{ $property->min_parkolas_dija_addons ?? '' }}
                                </td>
                            </tr>
                            @if ($property->kozos_teruleti_arany)
                                <tr>
                                    <td class="bold">Közös területi arány:</td>
                                    <td>{{ $property->kozos_teruleti_arany }}
                                        {{ $property->kozos_teruleti_arany_addons ?? '' }}
                                    </td>
                                </tr>
                            @endif
                            @if ($property->min_berleti_idoszak)
                                <tr>
                                    <td class="bold">Min. bérleti időszak:</td>
                                    <td>
                                        {{ $property->min_berleti_idoszak }}
                                        {{ $property->min_berleti_idoszak_addons ?? '' }}
                                    </td>
                                </tr>
                            @endif
                            @if ($property->kodszam)
                                <tr>
                                    <td class="bold">Kódszám:</td>
                                    <td>{{ $property->kodszam }}</td>
                                </tr>
                            @endif
                            @if ($property->afa)
                                <tr>
                                    <td style="padding-top: 20px" class="bold" colspan="2">
                                        @if ($property->afa /* == 'igen' */)
                                            A fenti díjakra még 27% ÁFA tevődik!
                                        @else
                                            A fenti díjakra még 27% ÁFA nem tevődik!
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div>
                    <iframe
                        @if ($property->maps_lat && $property->maps_lng) src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2695.3752330104103!2d{{ $property->maps_lng }}!3d{{ $property->maps_lat }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2s{{ urlencode($property->title) }}!5e0!3m2!1shu!2shu!4v1749023556934!5m2!1shu!2shu"
                        @else
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2695.3752330104103!2d19.04358067667799!3d47.502083195188725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2s{{ urlencode($property->title) }}!5e0!3m2!1shu!2shu!4v1749023556934!5m2!1shu!2shu" @endif
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="p-4">
                    <h2 class="text-3xl">{{ $property->title }} bemutató</h2>
                    <div class="space-y-4 mt-4">
                        {!! $property->content !!}
                    </div>
                    <h2>Szolgáltatások</h2>
                    <div class="space-y-4 mt-4">
                        @if ($property->services && count($property->services) > 0)
                            @foreach ($property->services as $service)
                                <a href="/talalatok?tag={{ urlencode($service) }}"
                                    class="label label_szolg">{{ $service }}</a>
                            @endforeach
                        @endif
                    </div>
                    <h2>Műszaki paraméterek</h2>
                    <div class="space-y-4 mt-4">
                        @if ($property->tags && count($property->tags) > 0)
                            @foreach ($property->tags as $tag)
                                <a href="/talalatok?stag={{ urlencode($tag) }}"
                                    class="label label_muszaki">{{ $tag }}</a>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="">
                    <section class="bg-white rounded-xl">
                        <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-accent">Lépjen
                                velünk
                                kapcsolatba!</h2>
                            <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 sm:text-xl">Kérjen személyre
                                szabott ajánlatot online!</p>
                            <form action="#" class="space-y-8">
                                <div>
                                    <label for="nev" class="block mb-2 text-sm font-medium text-gray-900">Az Ön
                                        neve</label>
                                    <input type="text" id="nev"
                                        class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="Az Ön neve" required>
                                </div>
                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Az Ön
                                        email
                                        címe</label>
                                    <input type="email" id="email"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                        placeholder="email@email.hu" required>
                                </div>
                                <div>
                                    <label for="tel" class="block mb-2 text-sm font-medium text-gray-900">Az Ön
                                        telefonszáma</label>
                                    <input type="phone" id="tel"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                        placeholder="+36 00 000 0000" required>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="message"
                                        class="block mb-2 text-sm font-medium text-gray-900">Üzenet</label>
                                    <textarea id="message" rows="6"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="Miben lehetünk a segítségére?"></textarea>
                                </div>
                                <button type="submit"
                                    class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-primary/70 sm:w-fit hover:bg-accent/70 focus:ring-4 focus:outline-none focus:ring-primary-300">Küldés</button>
                            </form>
                        </div>
                    </section>

                </div>
                <div class="space-y-4 p-4">
                    <div class="space-y-4">
                        <h2 class="text-3xl">Jellemzők</h2>
                        <ul class="sm:columns-2 gap-x-8 gap-y-3 list-disc text-lg">
                            @if ($property->services && count($property->services) > 0)
                                @foreach ($property->services as $service)
                                    <li class="pb-1">{{ $service }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    {{-- <div class="space-y-4">
                    <h2 class="text-3xl">Műszaki paraméterek</h2>
                    <ul class="sm:columns-2 gap-x-8 gap-y-3 list-disc text-lg">
                        <li class="pb-1">4 csöves fan-coil légkondicionálás</li>
                        <li class="pb-1">belső árnyékolók</li>
                        <li class="pb-1">épületfelügyeleti rendszer</li>
                        <li class="pb-1">frisslevegő ellátás</li>
                        <li class="pb-1">kiváló tömegközlekedési lehetőség</li>
                        <li class="pb-1">emelt padló</li>
                        <li class="pb-1">korszerű, kényelmes és gyors liftek</li>
                        <li class="pb-1">nyitható ablakok</li>
                        <li class="pb-1">kettős elektromos betáp.</li>
                        <li class="pb-1">álmennyezet</li>
                        <li class="pb-1">teherlift</li>
                        <li class="pb-1">akadálymentesített épület</li>
                        <li class="pb-1">Access4You</li>
                        <li class="pb-1">elektromos és hibrid autós töltők</li>
                        <li class="pb-1">magas minőségű kivitelezés és anyaghasználat</li>
                        <li class="pb-1">optikai kábel-csatlakozás</li>
                        <li class="pb-1">BREEAM minősítés</li>
                        <li class="pb-1">WELL-being</li>
                    </ul>
                </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="relative bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ Vite::asset('resources/images/the-office-building-2025-04-02-15-55-34-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white to-white/30"></div>
        <div class="kiemelt-ajanlatok relative z-10 container mx-auto pt-12 pb-20">
            <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                Hasonló irodák</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-screen-xl mx-auto">
                <x-cards.ingatlan-card
                    image="{{ Vite::asset('resources/images/andrassy_palace_iroda_5__384x246.jpg') }}"
                    title="Andrássy Palace Iroda" :description="'1061 Budapest, Andrássy út 9.<br><strong>Bérleti díj:</strong> 16 - 17 EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2990 HUF/m2/hó'" link="/adatlap-oldal/" />
                <x-cards.ingatlan-card
                    image="{{ Vite::asset('resources/images/arena_corner_irodahaz_1__384x246.jpg') }}"
                    title="Arena Corner" :description="'1087 Budapest, Hungária körút 40.<br><strong>Bérleti díj:</strong> 14.5 - 15.5 EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2200 HUF/m2/hó'" link="/adatlap-oldal/" />
                <x-cards.ingatlan-card image="{{ Vite::asset('resources/images/bank_center_1_2_3_4_5_384x246.jpg') }}"
                    title="Bank Center" :description="'1054 Budapest, Szabadság tér 7.<br><strong>Bérleti díj:</strong> 22 - 26 EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2700 HUF/m2/hó'" link="/adatlap-oldal/" />
            </div>
        </div>
    </div>

    <x-pages.sections.ajanlat />
</x-layouts.app>
