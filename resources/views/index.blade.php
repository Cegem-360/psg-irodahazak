@php
    $home = ['name' => __('Homepage'), 'url' => localized_route('home')];

    [$pageTitle, $pageDescription, $breadcrumbs] = match (true) {
        request()->routeIs('kiado-irodak', 'en.kiado-irodak') => [
            __('Offices for rent in Budapest | PSG Irodaházak'),
            __('Offices for rent in Budapest in one place: current available spaces, rental and operating fees of A-category office buildings on a map. Request an offer today!'),
            [$home, ['name' => __('Rental Offices'), 'url' => localized_route('kiado-irodak')]],
        ],
        request()->routeIs('elado-irodahazak', 'en.elado-irodahazak') => [
            __('Office buildings for sale in Budapest | PSG Irodaházak'),
            __('Office buildings and office premises for sale in Budapest: current listings with area, price and location. Investment office properties from PSG Irodaházak.'),
            [$home, ['name' => __('Office Buildings for Sale'), 'url' => localized_route('elado-irodahazak')]],
        ],
        request()->routeIs('rolunk', 'en.rolunk') => [
            __('About Us | PSG Irodaházak'),
            __('Since 2014, Property Solution Group Kft. has been helping companies as tenants on the Budapest office market: independent tenant representation, office search and negotiation free of charge.'),
            [$home, ['name' => __('About Us'), 'url' => localized_route('rolunk')]],
        ],
        request()->routeIs('adatlap-oldal', 'en.adatlap-oldal') => [
            __('Data Sheet | PSG Irodaházak'),
            null,
            [$home],
        ],
        default => [
            __('PSG-IRODAHÁZAK | Offices for rent, office buildings for sale, serviced instant office solutions, loft and green office buildings for lease in Budapest. Tenant representation!'),
            __('Offices for rent in Budapest! Rent from traditional and serviced offices on favourable lease terms, with a review of the entire office market database. Offers sent the same day.'),
            [$home],
        ],
    };
@endphp
<x-layouts.app :breadcrumbs="$breadcrumbs">
    <x-slot name="title">{{ $pageTitle }}</x-slot>
    <x-slot name="meta">
        @if (request()->routeIs('adatlap-oldal', 'en.adatlap-oldal'))
            <meta name="robots" content="noindex, follow">
        @endif
        @if ($pageDescription)
            <meta name="description" content="{{ $pageDescription }}">
        @endif
        <meta name="keywords"
            content="{{ __('office buildings for rent,offices for lease,instant offices,office for rent,office buildings for sale,downtown offices,loft office,office for rent in Buda,office for rent in Pest,A-category office buildings,green offices,list of office buildings,serviced offices,Tenant representation,') }}">
    </x-slot>
    <div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
        @if (request()->routeIs('home') || request()->routeIs('en.home'))
            @include('pages.home')
        @elseif (request()->routeIs('kiado-irodak') || request()->routeIs('en.kiado-irodak'))
            @include('pages.offices-for-rent')
        @elseif (request()->routeIs('elado-irodahazak') || request()->routeIs('en.elado-irodahazak'))
            @include('pages.offices-for-sale')
        @elseif (request()->routeIs('rolunk') || request()->routeIs('en.rolunk'))
            <x-pages.about-us />
        @elseif (request()->routeIs('kapcsolat') || request()->routeIs('en.kapcsolat'))
            @include('pages.contact')
        @endif

    </div>
</x-layouts.app>
