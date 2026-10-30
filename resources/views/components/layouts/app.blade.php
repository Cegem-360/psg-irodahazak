@props(['breadcrumbs' => []])
@inject('structuredData', 'App\\Services\\StructuredDataService')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        {{-- Pages may add their own head tags via the "meta" slot; those replace the matching defaults below. --}}
        @php
            $metaSlotHtml = isset($meta) ? (string) $meta : '';
            $metaSlotHas = fn (string $needle): bool => str_contains($metaSlotHtml, $needle);

            $defaultDescription = 'Kiadó irodák Budapesten! Kedvező bérleti konstrukciókkal bérelhet a teljes irodapiaci adatbázis áttekintésével hagyományos és szolgáltatott kiadó irodák közül. Ajánlatküldés még a mai napon.';
            $pageTitleText = Str::squish(isset($title) ? strip_tags((string) $title) : '') ?: __('page.title.default');
            $pageDescriptionText = Str::squish(isset($metaDescription) ? strip_tags((string) $metaDescription) : '');
            if ($pageDescriptionText === '' && preg_match('/name="description"\s+content="([^"]*)"/', $metaSlotHtml, $slotDescription)) {
                $pageDescriptionText = html_entity_decode($slotDescription[1]);
            }
            $pageDescriptionText = $pageDescriptionText ?: $defaultDescription;
        @endphp

        <title>{{ $pageTitleText }}</title>
        <meta name="author" content="{{ $metaAuthor ?? 'Property Solution Group Kft.' }}">

        @unless ($metaSlotHas('name="description"'))
            <meta name="description" content="{{ $pageDescriptionText }}">
        @endunless

        @unless ($metaSlotHas('name="keywords"'))
            @isset($metaKeywords)
                <meta name="keywords" content="{{ $metaKeywords }}">
            @else
                <meta name="keywords"
                    content="kiadó irodaházak,bérbeadó irodák,azonnali irodák,kiadó iroda,eladó irodaházak,belvárosi irodák,loft iroda,kiadó iroda Budán,kiadó iroda Pesten,A-kategóriás irodaházak,zöld irodák,irodaházak listája,Bérlő képviselet,">
            @endisset
        @endunless

        @unless ($metaSlotHas('property="og:title"'))
            <meta property="og:title" content="{{ $metaOgTitle ?? $pageTitleText }}">
        @endunless
        @unless ($metaSlotHas('property="og:type"'))
            <meta property="og:type" content="{{ $metaOgType ?? 'website' }}">
        @endunless
        @unless ($metaSlotHas('property="og:url"'))
            <meta property="og:url" content="{{ $metaOgUrl ?? Request::url() }}">
        @endunless
        @unless ($metaSlotHas('property="og:description"'))
            <meta property="og:description" content="{{ $metaOgDescription ?? $pageDescriptionText }}">
        @endunless
        <meta name="twitter:card" content="{{ $metaTwitterCard ?? 'summary' }}">
        <meta name="twitter:url" content="{{ $metaTwitterUrl ?? Request::url() }}">
        <meta name="twitter:title" content="{{ $metaTwitterTitle ?? $pageTitleText }}">
        <meta name="twitter:description" content="{{ $metaTwitterDescription ?? $pageDescriptionText }}">
        <meta itemprop="name" content="{{ $metaItempropName ?? $pageTitleText }}">
        <meta itemprop="description" content="{{ $metaItempropDescription ?? $pageDescriptionText }}">
        @unless ($metaSlotHas('rel="canonical"'))
            <link rel="canonical" href="{{ $metaCanonical ?? Request::url() }}">
        @endunless
        @unless ($metaSlotHas('name="robots"'))
            <meta name="robots"
                content="{{ $metaRobots ?? 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1' }}">
        @endunless

        {{ $meta ?? '' }}

        @if (file_exists(public_path('llms.txt')))
            <link rel="alternate" type="text/plain" href="/llms.txt">
        @endif

        {{ $structuredData->toScript($structuredData->siteGraph($breadcrumbs)) }}

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

        <x-toast />

        @livewire('quote-request-modal')

        @livewire('property-map-modal')

        @livewire('property-phone-modal')

        <x-layouts.footer />
        @cookieconsentview
        @filamentScripts
        @stack('scripts')

    </body>

</html>
