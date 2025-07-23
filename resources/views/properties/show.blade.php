@use('App\Models\Translate')
<x-layouts.app>
    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-8 pt-24 pb-20">
            <h2 class="mt-4 mb-16 font-font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ $property->title }}</h2>
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div>
                    <x-cards.ingatlan-gallery-carousel :images="collect($property->property_photos)" :title="$property->title" />
                </div>
                <div class="p-4">

                    <table class="table-auto w-full mt-4">
                        <tbody>
                            @if ($property->elado_v_kiado === 'elado-iroda')

                                <tr>
                                    <td class="font-bold">{{ __('Address') }}:</td>
                                    <td>{{ $property->cim_irsz }} {{ $property->cim_varos }},</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Total Area') }}:</td>
                                    <td>{{ $property->total_area }} m2</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Price') }}:</td>
                                    <td>{{ $property->min_berleti_dij ?? '' }} {{ $property->min_berleti_dij_addons }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Parking') }}:</td>
                                    <td>{{ $property->parkolas }}</td>
                                </tr>
                                @if ($property->kodszam)
                                    <tr>
                                        <td class="font-bold">{{ __('Code') }}:</td>
                                        <td>{{ $property->kodszam }}</td>
                                    </tr>
                                @endif
                            @else
                                {{-- Default fields for rental offices --}}
                                <tr>
                                    <td class="font-bold">{{ __('Address') }}:</td>
                                    <td>{{ $property->cim_irsz }} {{ $property->cim_varos }},
                                        {{ $property->cim_utca }}
                                        {{ $property->cim_utca_addons ?? '' }} {{ $property->cim_hazszam }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Construction Year') }}:</td>
                                    <td>{{ $property->construction_year }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Total Area') }}:</td>
                                    <td>{{ $property->total_area }}
                                        {{ $property->osszterulet_addons ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Currently Available') }}:</td>
                                    <td>{{ $property->jelenleg_kiado }}
                                        {{ $property->jelenleg_kiado_addons ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Min. Available') }}:</td>
                                    <td>{{ $property->min_kiado }}
                                        {{ $property->min_kiado_addons ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Rent') }}:</td>
                                    <td>{{ $property->min_berleti_dij }}{{ $property->max_berleti_dij ? ' - ' . $property->max_berleti_dij : '' }}
                                        {{ $property->min_berleti_dij_addons ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Operating Fee') }}:</td>
                                    <td>{{ $property->uzemeletetesi_dij }}
                                        {{ $property->uzemeletetesi_dij_addons ?? '' }}</td>
                                    </td>
                                </tr>
                                @if ($property->raktar_terulet)
                                    <tr>
                                        <td class="font-bold">{{ __('Storage Area') }}:</td>
                                        <td>{{ number_format($property->raktar_terulet) }}
                                            {{ $property->raktar_terulet_addons ?? '' }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($property->raktar_berleti_dij)
                                    <tr>
                                        <td class="font-bold">{{ __('Storage Rent') }}:</td>
                                        <td>{{ $property->raktar_berleti_dij }}
                                            {{ $property->raktar_berleti_dij_addons ?? '' }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="font-bold">{{ __('Parking') }}:</td>
                                    <td>{{ $property->parkolas }}</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">{{ __('Parking Fee') }}:</td>
                                    <td>{{ $property->min_parkolas_dija }}{{ $property->max_parkolas_dija ? ' - ' . $property->max_parkolas_dija : '' }}
                                        {{ $property->min_parkolas_dija_addons ?? '' }}
                                    </td>
                                </tr>
                                @if ($property->kozos_teruleti_arany)
                                    <tr>
                                        <td class="font-bold">{{ __('Common Area Ratio') }}:</td>
                                        <td>{{ $property->kozos_teruleti_arany }}
                                            {{ $property->kozos_teruleti_arany_addons ?? '' }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($property->min_berleti_idoszak)
                                    <tr>
                                        <td class="font-bold">{{ __('Min. Rental Period') }}:</td>
                                        <td>
                                            {{ $property->min_berleti_idoszak }}
                                            {{ $property->min_berleti_idoszak_addons ?? '' }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($property->kodszam)
                                    <tr>
                                        <td class="font-bold">{{ __('Code') }}:</td>
                                        <td>{{ $property->kodszam }}</td>
                                    </tr>
                                @endif
                                @if (!$property->jelenleg_kiado)
                                    <tr>
                                        <td class="py-8 text-red-500 italic font-font-bold text-center text-xl"
                                            colspan="2">
                                            {{ __('The office building is currently 100% rented out!') }}
                                        </td>
                                    </tr>
                                @endif

                                @if ($property->vat)
                                    <tr>
                                        <td style="padding-top: 20px" class="font-bold" colspan="2">
                                            @if ($property->vat)
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

            <div class="max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="text-center">
                    <h3 class="text-2xl font-bold mb-4">{{ __('Property Details') }}</h3>
                    <p class="mb-6 text-gray-600">{{ __('Download detailed information about this property') }}</p>

                    @auth
                        <a href="{{ URL::signedRoute('property.pdf', ['property' => $property->id]) }}"
                            class="inline-flex items-center px-6 py-3 bg-accent text-white font-medium rounded-lg hover:bg-accent/90 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            {{ __('Download PDF') }}
                        </a>
                    @else
                        @if (request()->hasValidSignature())
                            <a href="{{ URL::signedRoute('property.pdf', ['property' => $property->id]) }}"
                                class="inline-flex items-center px-6 py-3 bg-accent text-white font-medium rounded-lg hover:bg-accent/90 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                {{ __('Download PDF') }}
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div>
                    @if (!$property->isSale())
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
                    @else
                        <x-forms.contact />
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
            @if (!$property->isSale())
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                    <div class="">
                        <section class="bg-white rounded-xl">
                            <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrafont-bold text-center text-accent">
                                    {{ __('Contact Us!') }}</h2>
                                <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 sm:text-xl">
                                    {{ __('Request a personalized offer online!') }}</p>
                                <x-forms.contact :selected_property_id="$property->id" :selected_property_type_is_rent="$property->isRent()" />
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
                                        <li class="jellemzok pb-1">
                                            @if (app()->getLocale() === 'en')
                                                {{ Translate::whereName($item)->first()?->translated ?? $item }}
                                            @else
                                                {{ $item }}
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="relative bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ Vite::asset('resources/images/the-office-building-2025-04-02-15-55-34-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white to-white/30"></div>
        <div class="kiemelt-ajanlatok relative z-10 container mx-auto pt-12 pb-20">
            <h2 class="mt-4 mb-16 font-font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('Similar Offices') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-screen-xl mx-auto">
                @foreach ($similarProperties ?? [] as $similarProperty)
                    @if ($similarProperty->isRent())
                        <x-cards.ingatlan-card
                            image="{{ $similarProperty->getFirstImageUrl() ?: Vite::asset('resources/images/default-office.jpg') }}"
                            title="{{ $similarProperty->title }}" :description="$similarProperty->getAddressFormated()"
                            link="{{ route('properties.show', $similarProperty->slug) }}" />
                    @else
                        <x-cards.ingatlan-card
                            image="{{ $similarProperty->getFirstImageUrl() ?: Vite::asset('resources/images/default-office.jpg') }}"
                            title="{{ $similarProperty->title }}" :description="$similarProperty->getAddressFormatedForSale()"
                            link="{{ route('properties.show-for-sale', $similarProperty->slug) }}" />
                    @endif
                @endforeach

            </div>
        </div>
    </div>

</x-layouts.app>
