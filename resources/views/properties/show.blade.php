@inject('structuredData', 'App\Services\StructuredDataService')
<x-layouts.app :breadcrumbs="[
    ['name' => __('Homepage'), 'url' => localized_route('home')],
    ['name' => $property->type()->listTitle(), 'url' => localized_route($property->type()->listRoute())],
    ['name' => $property->title, 'url' => $property->url()],
]">
    <x-slot name="title">
        {{ $property->localized('meta_title', 'meta_title_en') ?: $property->title.' | PSG Irodaházak' }}
    </x-slot>

    <x-slot name="meta">
        {{ $structuredData->toScript($structuredData->property($property, $property->url())) }}
    </x-slot>

    <x-slot name="metaDescription">
        {{ $property->localized('meta_description', 'meta_description_en') ?: Str::limit(Str::squish(strip_tags((string) $property->localized('content', 'en_content'))), 160) }}
    </x-slot>

    <x-slot name="metaKeywords">
        {{ $property->localized('meta_keywords', 'meta_keywords_en') }}
    </x-slot>

    @if (!$property->isActive())
        <x-slot name="metaRobots">noindex, nofollow</x-slot>
    @endif

    <x-page-section spacing="space-y-8">
        <x-slot:heading>{{ translate_value($property->title) }}</x-slot:heading>
        <x-glass-panel class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <x-property.gallery-carousel :images="collect($property->property_photos)" :title="$property->title" />
            </div>
            <div class="p-4">

                <table class="table-auto w-full mt-4">
                    <tbody>
                        @if ($property->isSale())

                            <x-property.spec-row :label="__('Address')">
                                {{ $property->postal_code ?? '' }}
                                {{ $property->city ?? '' }}, {{ $property->street ?? '' }}
                                {{ __($property->street_type ?? '') }}
                            </x-property.spec-row>

                            @if ($property->total_area)
                                <x-property.spec-row :label="__('Total Area')">
                                    {{ $property->total_area }}
                                    {{ __($property->total_area_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->min_rent)
                                <x-property.spec-row :label="__('Price')">
                                    {{ $property->min_rent ?? '' }}
                                    {{ __($property->min_rent_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->parking)
                                <x-property.spec-row
                                    :label="__('Parking')">{{ __($property->parking) }}</x-property.spec-row>
                            @endif
                            @if ($property->code)
                                <x-property.spec-row :label="__('Code')">{{ $property->code }}</x-property.spec-row>
                            @endif
                        @else
                            {{-- Default fields for rental offices --}}
                            <x-property.spec-row :label="__('Address')">
                                {{ $property->postal_code }} {{ $property->city }},
                                {{ $property->street }}
                                {{ __($property->street_type ?? '') }} {{ $property->house_number }}
                            </x-property.spec-row>
                            @if ($property->construction_year)
                                <x-property.spec-row
                                    :label="__('Construction Year')">{{ $property->construction_year }}</x-property.spec-row>
                            @endif
                            @if ($property->total_area)
                                <x-property.spec-row :label="__('Total Area')">
                                    {{ $property->total_area }}
                                    {{ __($property->total_area_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->available_area)
                                <x-property.spec-row :label="__('Currently Available')">{{ $property->available_area }}
                                    m2</x-property.spec-row>
                            @endif
                            @if ($property->min_available_area)
                                <x-property.spec-row :label="__('Min. Available')">
                                    {{ $property->min_available_area }}
                                    {{ __($property->min_available_area_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->min_rent)
                                <x-property.spec-row :label="__('Rent')">
                                    {{ $property->min_rent }}{{ $property->max_rent && $property->max_rent !== $property->min_rent ? ' - ' . $property->max_rent : '' }}
                                    {{ __($property->min_rent_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->operating_fee)
                                <x-property.spec-row :label="__('Operating Fee')">
                                    {{ translate_value($property->operating_fee) }}
                                    {{ __($property->operating_fee_unit ?? '') }}
                                </x-property.spec-row>
                            @endif

                            @if ($property->storage_area)
                                <x-property.spec-row :label="__('Storage Area')">
                                    {{ number_format((int) $property->storage_area) }}
                                    {{ __($property->storage_area_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->storage_rent)
                                <x-property.spec-row :label="__('Storage Rent')">
                                    {{ $property->storage_rent }}
                                    {{ __($property->storage_rent_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->parking)
                                <x-property.spec-row
                                    :label="__('Parking')">{{ __($property->parking) }}</x-property.spec-row>
                            @endif
                            @if ($property->min_parking_fee)
                                <x-property.spec-row :label="__('Parking Fee')">
                                    {{ $property->min_parking_fee }}{{ $property->max_parking_fee ? ' - ' . $property->max_parking_fee : '' }}
                                    {{ __($property->min_parking_fee_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->common_area_ratio)
                                <x-property.spec-row :label="__('Common Area Ratio')">
                                    {{ $property->common_area_ratio }}
                                    {{ __($property->common_area_ratio_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->min_lease_term)
                                <x-property.spec-row :label="__('Min. Rental Period')">
                                    {{ $property->min_lease_term }}
                                    {{ __($property->min_lease_term_unit ?? '') }}
                                </x-property.spec-row>
                            @endif
                            @if ($property->code)
                                <x-property.spec-row :label="__('Code')">{{ $property->code }}</x-property.spec-row>
                            @endif
                            @if (!$property->available_area)
                                <tr>
                                    <td class="py-8 text-red-500 italic font-font-bold text-center text-xl"
                                        colspan="2">
                                        {{ __('The office building is currently 100% rented out!') }}
                                    </td>
                                </tr>
                            @endif

                            @if ($property->vat)
                                <tr>
                                    <td class="pt-5 font-bold" colspan="2">
                                        {{ __('The above fees are subject to an additional 27% VAT!') }}
                                    </td>
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </x-glass-panel>
        @if (auth()->check() || request()->hasValidSignature())
            <x-glass-panel>
                <div class="text-center">
                    <h3 class="text-2xl font-bold mb-4">{{ __('Property Details') }}</h3>
                    <p class="mb-6 text-gray-600">{{ __('Download detailed information about this property') }}</p>

                    <a href="{{ URL::signedRoute(app()->getLocale() === 'en' ? 'en.property.pdf' : 'property.pdf', ['property' => $property->id]) }}" target="_blank"
                        class="inline-flex items-center px-6 py-3 bg-accent text-white font-medium rounded-lg hover:bg-accent/90 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        {{ __('Printable Version') }}
                    </a>

                </div>

            </x-glass-panel>
        @endif
        <x-glass-panel class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                @if (!$property->isSale())
                    <iframe src="{{ $property->mapEmbedUrl() }}" width="100%" height="100%" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                @else
                    <livewire:contact-form :selected-property-id="$property->id" :selected-property-type-is-rent="$property->isRent()" />
                @endif

            </div>
            <div class="p-4">
                <h2 class="text-3xl">
                    {{ __(':title Presentation', ['title' => translate_value($property->title)]) }}
                </h2>
                <div class="space-y-4 mt-4">
                    <div class="text-justify leading-relaxed">
                        {!! $property->localized('content', 'en_content') !!}
                    </div>
                </div>

            </div>
        </x-glass-panel>
        @if (!$property->isSale())
            <x-glass-panel class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="order-2 md:order-0">
                    <section class="bg-white rounded-xl">
                        <div class="py-8 lg:py-16 px-4 mx-auto max-w-3xl">
                            <h2 class="mb-4 text-4xl tracking-tight font-extrafont-bold text-center text-accent">
                                {{ __('Contact Us!') }}</h2>
                            <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 sm:text-xl">
                                {{ __('Request a personalized offer online!') }}</p>
                            <livewire:contact-form :selected-property-id="$property->id" :selected-property-type-is-rent="$property->isRent()" />
                        </div>
                    </section>

                </div>
                <div class="order-1 md:order-0 space-y-4 p-4">
                    <div class="space-y-4">
                        <h2 class="text-3xl">{{ __('Features') }}</h2>
                        <ul class="sm:columns-2 gap-x-8 gap-y-3 list-disc text-lg">
                            @foreach (collect($property->services)->merge($property->tags ?? [])->sortBy(fn ($item) => Str::lower(Str::ascii($item->name))) as $item)
                                <li class="jellemzok pb-1">{{ translate_value($item->name) }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </x-glass-panel>
        @endif
    </x-page-section>

    <div class="relative bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ Vite::asset('resources/images/the-office-building-2025-04-02-15-55-34-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-linear-to-b from-white to-white/30"></div>
        <div class="kiemelt-ajanlatok relative z-10 container mx-auto pt-12 pb-20">
            <h2 class="mt-4 mb-16 font-font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('Similar Offices') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-7xl mx-auto">
                @foreach ($similarProperties ?? [] as $similarProperty)
                    <x-property.similar-card :property="$similarProperty" />
                @endforeach

            </div>
        </div>
    </div>

</x-layouts.app>
