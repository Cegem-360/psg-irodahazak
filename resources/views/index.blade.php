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
    <x-layouts.home />
</x-layouts.app>
