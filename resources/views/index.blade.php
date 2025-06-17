<x-layouts.app>
    <x-slot
        name="title">{{ __('PSG-IRODAHÁZAK |  Kiadó irodák, eladó irodaházak, szolgáltatott azonnali iroda megoldások, bérbeadó loft és zöld irodaházak Budapesten. Bérlő képviselet! | ') }}</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="description"
            content="Kiadó irodák Budapesten! Kedvező bérleti konstrukciókkal bérelhet a teljes irodapiaci adatbázis áttekintésével hagyományos és szolgáltatott kiadó irodák közül. Ajánlatküldés még a mai napon.">
        <meta name="keywords"
            content="kiadó irodaházak,bérbeadó irodák,azonnali irodák,kiadó iroda,eladó irodaházak,belvárosi irodák,loft iroda,kiadó iroda Budán,kiadó iroda Pesten,A-kategóriás irodaházak,zöld irodák,irodaházak listája,serviced offices,Bérlő képviselet,">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>
    <x-slot name="content">
    </x-slot>
    <div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
        @if (request()->routeIs('home'))
            @include('pages.home')
            {{--     <x-layouts.home /> --}}
        @elseif (request()->routeIs('adatlap-oldal'))
            <x-layouts.pages.adatlap-oldal />
        @elseif (request()->routeIs('kiado-irodak'))
            @include('pages.offices-for-rent')
        @elseif (request()->routeIs('hirek'))
            <x-layouts.pages.hirek />
        @elseif (request()->routeIs('rolunk'))
            <x-layouts.pages.rolunk />
        @elseif (request()->routeIs('kapcsolat'))
            <x-layouts.pages.kapcsolat />
        @endif

    </div>
</x-layouts.app>
