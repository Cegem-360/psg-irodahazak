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
    <x-page-section>
        <x-slot:heading>{{ __('News') }}</x-slot:heading>

        <livewire:news-list />
    </x-page-section>
</x-layouts.app>
