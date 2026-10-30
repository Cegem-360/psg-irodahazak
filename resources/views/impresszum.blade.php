<x-layouts.app :breadcrumbs="[
    ['name' => __('Homepage'), 'url' => localized_route('home')],
    ['name' => __('Imprint'), 'url' => localized_route('impressum')],
]">
    <x-slot name="title">{{ __('Imprint') }} | PSG-IRODAHÁZAK</x-slot>
    <x-slot name="meta">
        <meta name="description" content="{{ __('PSG-IRODAHÁZAK imprint - Legal information and contact details.') }}">
        <meta name="keywords" content="{{ __('imprint, legal information, PSG-IRODAHÁZAK') }}">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>

    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-linear-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-8 pt-24 pb-20">
            <h1 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('Imprint') }}
            </h1>

            <div class="max-w-7xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="bg-white rounded-lg p-8">
                    @if ($impresszum && $impresszum->content)
                        <div class="prose prose-lg max-w-none text-gray-700">
                            {!! $impresszum->content !!}
                        </div>
                    @else
                        <div class="text-gray-600">
                            <p>{{ __('The imprint content has not been set yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
