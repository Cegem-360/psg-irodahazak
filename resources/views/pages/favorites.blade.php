<x-layouts.app>
    <x-slot name="meta">
        <title>{{ __('My Favorites') }} - PSG Irodaházak</title>
        <meta name="description" content="{{ __('Here you can find all the properties you have marked as favorites') }}">
        <meta name="keywords" content="kedvencek,irodaház,iroda,kedvenc ingatlanok,favorites">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>
    <x-slot name="content">
    </x-slot>
    <div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
        <livewire:favorites-list />

    </div>
</x-layouts.app>
