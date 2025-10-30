@use('Illuminate\Support\Facades\Storage')
@use('App\Models\Tag')
@use('App\Models\Service')
@use('App\Models\Translate')
<!DOCTYPE html>
<html lang="hu">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $property->title }} - {{ __('Property Data Sheet') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'psg-blue': '#1e3c72',
                            'psg-blue-light': '#2a5298',
                            'psg-cyan': '#4fc3f7',
                        }
                    }
                }
            }
        </script>
        <style>
            @media print {
                body {
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }
            }

            @media print {
                .pagebreak {
                    page-break-before: always;
                }
            }

            @media print {
                body {
                    -webkit-print-color-adjust: exact;
                }
            }
        </style>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body,
            h1,
            p {
                font-family: 'Open Sans', Arial, sans-serif;
            }
        </style>
    </head>

    <body class="text-gray-800 bg-white text-sm leading-normal">
        <div class="max-w-[210mm] mx-auto p-0">
            <!-- Header -->
            <div class="bg-white text-black px-6 py-4 relative min-h-[80px]">
                <!-- Logo bal felső sarokban -->
                <div class="absolute top-3 left-6">
                    <img src="{{ Vite::asset('resources/images/psg-irodahazak-logo.png') }}" alt="PSG Logo"
                        class="h-16 w-auto" loading="lazy">
                </div>

                <!-- Cím középen, több távolsággal a logótól -->
                <div class="text-center pt-8">
                    <h1 class="text-xl font-bold mb-1">{{ $property->title }}</h1>
                    <div class="text-sm font-medium opacity-90">

                        {{ $property->cim_irsz ?? '' }} {{ $property->cim_varos ?? '' }},
                        {{ $property->cim_utca ?? '' }} {{ $property->cim_utca_addons ?? '' }}
                        {{ $property->cim_hazszam ?? '' }}

                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex min-h-[380px]">
                <!-- Left Column - Image -->
                <div class="w-1/2 p-0">
                    @if ($property->property_photos && collect($property->property_photos)->count() > 0)
                        <img src="{{ $property->getFirstImageUrl() }}" alt="{{ $property->title }}"
                            class="w-full h-[380px] object-cover block" loading="lazy">
                    @else
                        <div class="w-full h-[380px] bg-gray-100 flex items-center justify-center text-gray-500">
                            {{ __('Image not available') }}
                        </div>
                    @endif
                </div>

                <!-- Right Column - Details -->
                <div class="w-1/2 p-6 bg-gray-50 text-sm leading-snug">
                    @if ($property->construction_year)
                        <x-pdf.property-column :first_span="__('Construction Year')" :second_span="$property->construction_year" />
                    @endif

                    @if ($property->total_area)
                        <x-pdf.property-column :first_span="__('Total Area')" :second_span="$property->total_area . ' m²'" />
                    @endif

                    @if ($property->jelenleg_kiado)
                        <x-pdf.property-column :first_span="__('Currently Available')" :second_span="$property->jelenleg_kiado . ' m²'" />
                    @endif

                    @if ($property->min_kiado)
                        <x-pdf.property-column :first_span="__('Min. Available')" :second_span="number_format((int) $property->min_kiado, 2, ',', ' ') .
                            ' ' .
                            __($property->min_kiado_addons ?? '')" />
                    @endif

                    @if ($property->isSale())
                        <x-pdf.property-column :first_span="__('Sale Price')" :second_span="$property->min_berleti_dij . ' ' . __($property->min_berleti_dij_addons ?? '')" />
                    @endif

                    @if ($property->isRent())
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-200">
                            <span class="font-bold text-gray-600">{{ __('Rent') }}:</span>
                            <span class="font-medium text-gray-900">
                                @if ($property->min_berleti_dij && $property->max_berleti_dij)
                                    {{ $property->min_berleti_dij . ' - ' . $property->max_berleti_dij }}
                                @else
                                    {{ $property->min_berleti_dij }}
                                @endif
                                {{ __($property->min_berleti_dij_addons ?? '') }}
                            </span>
                        </div>
                    @endif
                    @if ($property->uzemeletetesi_dij)
                        <x-pdf.property-column :first_span="__('Operating Fee')" :second_span="number_format((int) $property->uzemeletetesi_dij, 0, ',', ' ') .
                            ' ' .
                            __($property->uzemeletetesi_dij_addons ?? '')" />
                    @endif

                    @if ($property->raktar_terulet)
                        <x-pdf.property-column :first_span="__('Storage Area')" :second_span="number_format((int) $property->raktar_terulet, 0, ',', ' ') .
                            ' ' .
                            __($property->raktar_terulet_addons ?? '')" />
                    @endif
                    @if ($property->raktar_berleti_dij)
                        <x-pdf.property-column :first_span="__('Storage Rent')" :second_span="number_format((int) $property->raktar_berleti_dij, 0, ',', ' ') .
                            ' ' .
                            __($property->raktar_berleti_dij_addons ?? '')" />
                    @endif
                    @if ($property->parkolas)
                        <x-pdf.property-column :first_span="__('Parking')" :second_span="__($property->parkolas)" />
                    @endif
                    @if ($property->min_parkolas_dija)
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-200">
                            <span class="font-bold text-gray-600">{{ __('Parking Fee') }}:</span>
                            <span class="font-medium text-gray-900">
                                @if ($property->min_parkolas_dija && $property->max_parkolas_dija)
                                    {{ $property->min_parkolas_dija . ' - ' . $property->max_parkolas_dija }}
                                @else
                                    {{ $property->min_parkolas_dija }}
                                @endif
                                {{ __($property->min_parkolas_dija_addons ?? '') }}
                            </span>
                        </div>
                    @endif

                    @if ($property->kozos_teruleti_arany)
                        <x-pdf.property-column :first_span="__('Common Area Ratio')" :second_span="$property->kozos_teruleti_arany . '%'" />
                    @endif

                    @if ($property->min_berleti_idoszak)
                        <x-pdf.property-column :first_span="__('Min. Rental Period')" :second_span="$property->min_berleti_idoszak .
                            ' ' .
                            __($property->min_berleti_idoszak_addons ?? '')" />
                    @endif

                    @if ($property->kodszam)
                        <x-pdf.property-column :first_span="__('Code')" :second_span="$property->kodszam" />
                    @endif

                    @if ($property->vat)
                        <div class="mt-3 p-3 text-sm">
                            <span
                                class="font-bold text-red-600">{{ __('The above fees are subject to an additional 27% VAT!') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Images Gallery -->
        @if ($property->property_photos && collect($property->property_photos)->count() > 1)
            <div class="mt-6 px-6">
                <div class="grid grid-cols-3 gap-3">
                    @foreach (collect($property->property_photos)->skip(1)->take($property->isSale() ? 12 : 9) as $image)
                        <div class="image-item">
                            <img src="{{ Storage::url($image) }}" alt="{{ __('Property image') }}"
                                class="w-full h-24 object-cover rounded border border-gray-200" loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <!-- Egyéb mezők -->
        @if ($property->egyeb)
            <div class="mt-6 px-6 py-4 bg-gray-50">
                <div class="text-sm text-gray-700 leading-relaxed">
                    {!! $property->egyeb !!}
                </div>
            </div>
        @endif

        <!-- Description -->
        @if (app()->getLocale() === 'en' ? $property->en_content : $property->content)
            <div class="mt-6 px-6 py-4 bg-gray-50">
                <div class="text-sm text-gray-700 leading-relaxed text-justify" style="page-break-inside: auto;">
                    {!! app()->getLocale() === 'en' ? $property->en_content : $property->content !!}
                </div>
            </div>
        @endif
        @php
            $collator = class_exists(\Collator::class) ? new \Collator('hu_HU') : null;
            if ($collator) {
                $collator->setStrength(\Collator::SECONDARY);
            }

            $huCompare = function ($a, $b) use ($collator) {
                $an = (string) ($a->name ?? '');
                $bn = (string) ($b->name ?? '');
                if ($collator) {
                    return $collator->compare($an, $bn);
                }
                return strcasecmp(\Illuminate\Support\Str::ascii($an), \Illuminate\Support\Str::ascii($bn));
            };

            $normalize = function ($i) {
                if (is_string($i)) {
                    return (object) ['name' => $i];
                }
                if (is_array($i)) {
                    return isset($i['name']) ? (object) ['name' => $i['name']] : null;
                }
                return $i; // assume object with ->name
            };

            $items = collect($property->tags ?? [])
                ->merge(collect($property->services ?? []))
                ->map($normalize)
                ->filter(fn($i) => is_object($i) && filled($i->name ?? null))
                ->unique(fn($i) => \Illuminate\Support\Str::ascii(\Illuminate\Support\Str::lower($i->name)))
                ->sort($huCompare)
                ->values();
        @endphp

        @if ($items->isNotEmpty())
            <div class="mt-6 px-6 py-4 bg-gray-50" style="page-break-inside: auto;">
                <h3 class="text-base font-bold text-gray-800 mb-3">{{ __('Technical specifications and services') }}
                </h3>
                <div class="text-sm text-gray-700 leading-relaxed text-justify" style="page-break-inside: auto;">
                    <ul class="list-disc list-inside mb-4">
                        @foreach ($items as $item)
                            @if (app()->getLocale() === 'en')
                                <li class="mb-1">
                                    {{ Translate::whereName($item->name)->first()?->translated ?? $item->name }}</li>
                            @else
                                <li class="mb-1">{{ $item->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

    </body>

</html>
