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

                    <table class="table-auto w-full mt-4">
                        <tbody>
                            @if ($property->elado_v_kiado === 'elado-iroda')

                                <tr>
                                    <td class="bold">{{ __('Address') }}:</td>
                                    <td>{{ $property->cim_irsz }} {{ $property->cim_varos }},</td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Total Area') }}:</td>
                                    <td>{{ number_format($property->total_area) }} m2</td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Price') }}:</td>
                                    <td>{{ $property->ar ?? '12 mEUR' }}</td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Parking') }}:</td>
                                    <td>{{ $property->parkolas }}</td>
                                </tr>
                                @if ($property->kodszam)
                                    <tr>
                                        <td class="bold">{{ __('Code') }}:</td>
                                        <td>{{ $property->kodszam }}</td>
                                    </tr>
                                @endif
                            @else
                                {{-- Default fields for rental offices --}}
                                <tr>
                                    <td class="bold">{{ __('Address') }}:</td>
                                    <td>{{ $property->cim_irsz }} {{ $property->cim_varos }},
                                        {{ $property->cim_utca }}
                                        {{ $property->cim_utca_addons ?? '' }} {{ $property->cim_hazszam }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Construction Year') }}:</td>
                                    <td>{{ $property->construction_year }}</td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Total Area') }}:</td>
                                    <td>{{ number_format($property->total_area) }}
                                        {{ $property->osszterulet_addons ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Currently Available') }}:</td>
                                    <td>{{ $property->jelenleg_kiado }}
                                        {{ $property->jelenleg_kiado_addons ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Min. Available') }}:</td>
                                    <td>{{ $property->min_kiado }}
                                        {{ $property->min_kiado_addons ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Rent') }}:</td>
                                    <td>{{ $property->min_berleti_dij }}{{ $property->max_berleti_dij ? ' - ' . $property->max_berleti_dij : '' }}
                                        {{ $property->min_berleti_dij_addons ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Operating Fee') }}:</td>
                                    <td>{{ $property->uzemeletetesi_dij }}
                                        {{ $property->uzemeletetesi_dij_addons ?? '' }}</td>
                                    </td>
                                </tr>
                                @if ($property->raktar_terulet)
                                    <tr>
                                        <td class="bold">{{ __('Storage Area') }}:</td>
                                        <td>{{ number_format($property->raktar_terulet) }}
                                            {{ $property->raktar_terulet_addons ?? '' }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($property->raktar_berleti_dij)
                                    <tr>
                                        <td class="bold">{{ __('Storage Rent') }}:</td>
                                        <td>{{ $property->raktar_berleti_dij }}
                                            {{ $property->raktar_berleti_dij_addons ?? '' }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="bold">{{ __('Parking') }}:</td>
                                    <td>{{ $property->parkolas }}</td>
                                </tr>
                                <tr>
                                    <td class="bold">{{ __('Parking Fee') }}:</td>
                                    <td>{{ $property->min_parkolas_dija }}
                                        {{ $property->min_parkolas_dija_addons ?? '' }}
                                    </td>
                                </tr>
                                @if ($property->kozos_teruleti_arany)
                                    <tr>
                                        <td class="bold">{{ __('Common Area Ratio') }}:</td>
                                        <td>{{ $property->kozos_teruleti_arany }}
                                            {{ $property->kozos_teruleti_arany_addons ?? '' }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($property->min_berleti_idoszak)
                                    <tr>
                                        <td class="bold">{{ __('Min. Rental Period') }}:</td>
                                        <td>
                                            {{ $property->min_berleti_idoszak }}
                                            {{ $property->min_berleti_idoszak_addons ?? '' }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($property->kodszam)
                                    <tr>
                                        <td class="bold">{{ __('Code') }}:</td>
                                        <td>{{ $property->kodszam }}</td>
                                    </tr>
                                @endif
                                @if (!$property->jelenleg_kiado)
                                    <tr>
                                        <td class="py-8 text-red-500 italic font-bold text-center text-xl"
                                            colspan="2">
                                            {{ __('The office building is currently 100% rented out!') }}
                                        </td>
                                    </tr>
                                @endif

                                @if ($property->afa)
                                    <tr>
                                        <td style="padding-top: 20px" class="bold" colspan="2">
                                            @if ($property->afa /* == 'igen' */)
                                                {{ __('The above fees are subject to an additional 27% VAT!') }}
                                            @else
                                                {{ __('The above fees are NOT subject to an additional 27% VAT!') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div>
                    @if ($property->maps_lat && $property->maps_lng)
                        {{-- Ingyenes: Koordináta alapú térkép pin-nel --}}
                        <iframe
                            src="https://maps.google.com/maps?q={{ $property->maps_lat }},{{ $property->maps_lng }}&hl={{ app()->getLocale() }}&z=16&output=embed"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        {{-- Ingyenes: Cím alapú keresés pin-nel --}}
                        <iframe
                            src="https://maps.google.com/maps?q={{ urlencode($property->cim_irsz . ' ' . $property->cim_varos . ', ' . $property->cim_utca . ' ' . $property->cim_hazszam . ($property->cim_utca_addons ? ', ' . $property->cim_utca_addons : '')) }}&hl={{ app()->getLocale() }}&z=16&output=embed"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @endif
                </div>
                <div class="p-4">
                    <h2 class="text-3xl">{{ __(':title Presentation', ['title' => $property->title]) }}</h2>
                    <div class="space-y-4 mt-4">
                        <div class="text-justify leading-relaxed">
                            @if (app()->getLocale() === 'en' && $property->en_content)
                                {!! $property->en_content !!}
                            @elseif ($property->content)
                                {!! $property->content !!}
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="">
                    <section class="bg-white rounded-xl">
                        <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-accent">
                                {{ __('Contact Us!') }}</h2>
                            <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 sm:text-xl">
                                {{ __('Request a personalized offer online!') }}</p>
                            <form action="#" class="space-y-8">
                                <div>
                                    <label for="nev"
                                        class="block mb-2 text-sm font-medium text-gray-900">{{ __('Your Name') }}</label>
                                    <input type="text" id="nev"
                                        class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="{{ __('Your Name') }}" required>
                                </div>
                                <div>
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900">{{ __('Your Email') }}</label>
                                    <input type="email" id="email"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                        placeholder="email@email.hu" required>
                                </div>

                                <div>
                                    <label for="tel"
                                        class="block mb-2 text-sm font-medium text-gray-900">{{ __('Your Phone Number') }}</label>
                                    <input type="phone" id="tel"
                                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                        placeholder="+36 00 000 0000" required>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="message"
                                        class="block mb-2 text-sm font-medium text-gray-900">{{ __('Message') }}</label>
                                    <textarea id="message" rows="6"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="{{ __('How can we help you?') }}"></textarea>
                                </div>
                                <button type="submit"
                                    class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-primary/70 sm:w-fit hover:bg-accent/70 focus:ring-4 focus:outline-none focus:ring-primary-300">{{ __('Send') }}</button>
                            </form>
                        </div>
                    </section>

                </div>
                <div class="space-y-4 p-4">
                    <div class="space-y-4">
                        <h2 class="text-3xl">{{ __('Features') }}</h2>
                        <ul class="sm:columns-2 gap-x-8 gap-y-3 list-disc text-lg">
                            @if ($property->services && count($property->services) > 0)
                                @php
                                    $allItems = collect($property->services)
                                        ->merge($property->tags ?? [])
                                        ->sortBy(function ($item) {
                                            // Ékezetek eltávolítása és kisbetűsítés a rendezéshez
                                            $normalized = strtolower($item);
                                            $normalized = str_replace(
                                                ['á', 'é', 'í', 'ó', 'ő', 'ú', 'ű', 'ü', 'ö'],
                                                ['a', 'e', 'i', 'o', 'o', 'u', 'u', 'u', 'o'],
                                                $normalized,
                                            );
                                            return $normalized;
                                        });
                                @endphp
                                @foreach ($allItems as $item)
                                    <li class="jellemzok pb-1">{{ $item }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="relative bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ Vite::asset('resources/images/the-office-building-2025-04-02-15-55-34-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white to-white/30"></div>
        <div class="kiemelt-ajanlatok relative z-10 container mx-auto pt-12 pb-20">
            <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('Similar Offices') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-screen-xl mx-auto">
                @if ($similarProperties && $similarProperties->count() > 0)
                    @foreach ($similarProperties as $similarProperty)
                        <x-cards.ingatlan-card
                            image="{{ $similarProperty->getFirstImageUrl('384x246') ?: Vite::asset('resources/images/default-office.jpg') }}"
                            title="{{ $similarProperty->title }}" :description="$similarProperty->cim_irsz .
                                ' ' .
                                $similarProperty->cim_varos .
                                ', ' .
                                $similarProperty->cim_utca .
                                ' ' .
                                $similarProperty->cim_hazszam .
                                ($similarProperty->cim_utca_addons ? ', ' . $similarProperty->cim_utca_addons : '') .
                                '<br>' .
                                '<strong>' .
                                __('Rent:') .
                                '</strong> ' .
                                ($similarProperty->min_berleti_dij ?: __('Please inquire')) .
                                ($similarProperty->max_berleti_dij ? ' - ' . $similarProperty->max_berleti_dij : '') .
                                '<br>' .
                                '<strong>' .
                                __('Operating Fee:') .
                                '</strong> ' .
                                ($similarProperty->uzemeletetesi_dij ?: __('Please inquire'))"
                            link="{{ route('properties.show', $similarProperty->slug) }}" />
                    @endforeach
                @else
                    <x-cards.ingatlan-card
                        image="{{ Vite::asset('resources/images/andrassy_palace_iroda_5__384x246.jpg') }}"
                        title="Andrássy Palace Iroda" :description="'1061 Budapest, Andrássy út 9.<br><strong>' .
                            __('Rent:') .
                            '</strong> 16 - 17 EUR/m2/hó<br><strong>' .
                            __('Operating Fee:') .
                            '</strong> 2990 HUF/m2/hó'" link="/adatlap-oldal/" />
                    <x-cards.ingatlan-card
                        image="{{ Vite::asset('resources/images/arena_corner_irodahaz_1__384x246.jpg') }}"
                        title="Arena Corner" :description="'1087 Budapest, Hungária körút 40.<br><strong>' .
                            __('Rent:') .
                            '</strong> 14.5 - 15.5 EUR/m2/hó<br><strong>' .
                            __('Operating Fee:') .
                            '</strong> 2200 HUF/m2/hó'" link="/adatlap-oldal/" />
                    <x-cards.ingatlan-card
                        image="{{ Vite::asset('resources/images/bank_center_1_2_3_4_5_384x246.jpg') }}"
                        title="Bank Center" :description="'1054 Budapest, Szabadság tér 7.<br><strong>' .
                            __('Rent:') .
                            '</strong> 22 - 26 EUR/m2/hó<br><strong>' .
                            __('Operating Fee:') .
                            '</strong> 2700 HUF/m2/hó'" link="/adatlap-oldal/" />
                @endif
            </div>
        </div>
    </div>

</x-layouts.app>
