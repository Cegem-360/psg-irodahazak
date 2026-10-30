<x-layouts.app :breadcrumbs="[
    ['name' => __('Homepage'), 'url' => localized_route('home')],
    ['name' => __('News'), 'url' => localized_route('news.index')],
]">
    <x-slot name="title">{{ __('News') }} | PSG-IRODAHÁZAK</x-slot>
    <x-slot name="meta">
        <meta name="description"
            content="{{ __('PSG-IRODAHÁZAK news - The latest news, developments and professional insights from the office market.') }}">
        <meta name="keywords" content="{{ __('news, office market, real estate news, office buildings, office rental, industry news') }}">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>
    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-linear-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h1 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('News') }}</h1>

            <livewire:news-list />
        </div>
    </div>
</x-layouts.app>
