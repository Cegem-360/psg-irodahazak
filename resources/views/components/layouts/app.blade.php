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
        @isset($meta)
            {{ $meta }}
        @else
            <meta name="robots" content="index, follow">
            <meta name="googlebot" content="index, follow">
            <meta name="description" content="">
            <meta name="keywords" content="">
            <link rel="canonical" href="{{ Request::url() }}">
        @endisset

        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite(['resources/js/app.js', 'resources/css/app.css'])

    </head>

    <body class="antialiased">
        <header>
            <x-layouts.header.top-bar />
            <x-layouts.header.hero />
        </header>
        <div class="relative">
            <x-layouts.header.nav />
        </div>
        {{ $slot }}

        @livewire('notifications')

        <x-layouts.sections.footer />

        @filamentScripts

    </body>

</html>
