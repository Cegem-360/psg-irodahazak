@php
    $home = ['name' => __('Homepage'), 'url' => localized_route('home')];

    [$pageTitle, $pageDescription, $breadcrumbs] = match (true) {
        request()->routeIs('kiado-irodak', 'en.kiado-irodak') => [
            __('Kiadó irodák Budapesten | PSG Irodaházak'),
            __('Kiadó irodák Budapesten egy helyen: A kategóriás irodaházak aktuális szabad területei, bérleti és üzemeltetési díjai térképpel. Kérjen ajánlatot még ma!'),
            [$home, ['name' => __('Rental Offices'), 'url' => localized_route('kiado-irodak')]],
        ],
        request()->routeIs('elado-irodahazak', 'en.elado-irodahazak') => [
            __('Eladó irodaházak Budapesten | PSG Irodaházak'),
            __('Eladó irodaházak és irodaépületek Budapesten: aktuális kínálat területtel, árral és helyszínnel. Befektetési célú irodaingatlanok a PSG Irodaházaktól.'),
            [$home, ['name' => __('Office Buildings for Sale'), 'url' => localized_route('elado-irodahazak')]],
        ],
        request()->routeIs('rolunk', 'en.rolunk') => [
            __('Rólunk | PSG Irodaházak'),
            __('A Property Solution Group Kft. 2014 óta segíti bérlőként a cégeket a budapesti irodapiacon: független bérlőképviselet, irodakeresés és tárgyalás díjmentesen.'),
            [$home, ['name' => __('About Us'), 'url' => localized_route('rolunk')]],
        ],
        request()->routeIs('adatlap-oldal', 'en.adatlap-oldal') => [
            __('Adatlap | PSG Irodaházak'),
            null,
            [$home],
        ],
        default => [
            __('PSG-IRODAHÁZAK |  Kiadó irodák, eladó irodaházak, szolgáltatott azonnali iroda megoldások, bérbeadó loft és zöld irodaházak Budapesten. Bérlő képviselet!'),
            'Kiadó irodák Budapesten! Kedvező bérleti konstrukciókkal bérelhet a teljes irodapiaci adatbázis áttekintésével hagyományos és szolgáltatott kiadó irodák közül. Ajánlatküldés még a mai napon.',
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
            content="kiadó irodaházak,bérbeadó irodák,azonnali irodák,kiadó iroda,eladó irodaházak,belvárosi irodák,loft iroda,kiadó iroda Budán,kiadó iroda Pesten,A-kategóriás irodaházak,zöld irodák,irodaházak listája,serviced offices,Bérlő képviselet,">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>
    <div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
        @if (request()->routeIs('home') || request()->routeIs('en.home'))
            @include('pages.home')
        @elseif (request()->routeIs('adatlap-oldal') || request()->routeIs('en.adatlap-oldal'))
            <x-pages.adatlap-oldal />
        @elseif (request()->routeIs('kiado-irodak') || request()->routeIs('en.kiado-irodak'))
            @include('pages.offices-for-rent')
        @elseif (request()->routeIs('elado-irodahazak') || request()->routeIs('en.elado-irodahazak'))
            @include('pages.offices-for-sale')
        @elseif (request()->routeIs('rolunk') || request()->routeIs('en.rolunk'))
            <x-pages.rolunk />
        @elseif (request()->routeIs('kapcsolat') || request()->routeIs('en.kapcsolat'))
            @include('pages.contact')
        @endif

    </div>
</x-layouts.app>
