<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        @isset($title)
            <title>{{ $title }}</title>
        @else
            <title>{{ __('page.title.default') }}</title>
        @endisset
        <meta name="author" content="{{ $metaAuthor ?? 'Cegem360 Kft.' }}">

        @isset($metaDescription)
            <meta name="description" content="{{ $metaDescription }}">
        @else
            <meta name="description"
                content="Kiadó irodák Budapesten! Kedvező bérleti konstrukciókkal bérelhet a teljes irodapiaci adatbázis áttekintésével hagyományos és szolgáltatott kiadó irodák közül. Ajánlatküldés még a mai napon. ">
        @endisset

        @isset($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}">
        @else
            <meta name="keywords"
                content="kiadó irodaházak,bérbeadó irodák,azonnali irodák,kiadó iroda,eladó irodaházak,belvárosi irodák,loft iroda,kiadó iroda Budán,kiadó iroda Pesten,A-kategóriás irodaházak,zöld irodák,irodaházak listája,Bérlő képviselet,">
        @endisset

        <meta property="og:title"
            content="{{ $metaOgTitle ?? 'PSG-IRODAHÁZAK |  Kiadó irodák, eladó irodaházak, szolgáltatott azonnali iroda megoldások, bérbeadó loft és zöld irodaházak Budapesten. Bérlő képviselet! | ' }}">
        <meta property="og:type" content="{{ $metaOgType ?? 'website' }}">
        <meta property="og:url" content="{{ $metaOgUrl ?? Request::url() }}">
        <meta property="og:description" content="{{ $metaOgDescription ?? '' }}">
        <meta name="twitter:card" content="{{ $metaTwitterCard ?? 'summary' }}">
        <meta name="twitter:url" content="{{ $metaTwitterUrl ?? Request::url() }}">
        <meta name="twitter:title"
            content="{{ $metaTwitterTitle ?? 'PSG-IRODAHÁZAK |  Kiadó irodák, eladó irodaházak, szolgáltatott azonnali iroda megoldások, bérbeadó loft és zöld irodaházak Budapesten. Bérlő képviselet! | ' }}">
        <meta name="twitter:description"
            content="{{ $metaTwitterDescription ?? 'Kiadó irodák Budapesten! Kedvező bérleti konstrukciókkal bérelhet a teljes irodapiaci adatbázis áttekintésével hagyományos és szolgáltatott kiadó irodák közül. Ajánlatküldés még a mai napon. ' }}">
        <meta itemprop="name"
            content="{{ $metaItempropName ?? 'PSG-IRODAHÁZAK |  Kiadó irodák, eladó irodaházak, szolgáltatott azonnali iroda megoldások, bérbeadó loft és zöld irodaházak Budapesten. Bérlő képviselet! | ' }}">
        <meta itemprop="description"
            content="{{ $metaItempropDescription ?? 'Kiadó irodák Budapesten! Kedvező bérleti konstrukciókkal bérelhet a teljes irodapiaci adatbázis áttekintésével hagyományos és szolgáltatott kiadó irodák közül. Ajánlatküldés még a mai napon. ' }}">
        <link rel="canonical" href="{{ $metaCanonical ?? Request::url() }}">
        <meta name="robots" content="{{ $metaRobots ?? 'index, follow' }}">
        <meta name="googlebot" content="{{ $metaGooglebot ?? 'index, follow' }}">

        @include('googletagmanager::head')

        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" sizes="48x48" />

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @cookieconsentscripts
        @filamentStyles
        @vite(['resources/js/app.js'])

    </head>

    <body class="antialiased" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        @include('googletagmanager::body')
        <header>
            <x-layouts.navigation.top-bar />
            <x-layouts.navigation.hero />
        </header>
        <div class="relative">
            <x-layouts.navigation.navbar />
        </div>

        {{ $slot }}

        @livewire('notifications')

        @livewire('quote-request-modal')

        @livewire('property-map-modal')

        @livewire('property-phone-modal')

        <x-layouts.footer />
        @cookieconsentview
        @filamentScripts
        @stack('scripts')

    </body>

</html>
