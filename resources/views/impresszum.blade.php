<x-layouts.app>
    <x-slot name="title">{{ $impresszum?->title ?? 'Impresszum' }} | PSG-IRODAHÁZAK</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="description" content="PSG-IRODAHÁZAK impresszum - Jogi információk és elérhetőségek.">
        <meta name="keywords" content="impresszum, jogi információk, PSG-IRODAHÁZAK">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>

    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-8 pt-24 pb-20">
            <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ $impresszum?->title ?? 'Impresszum' }}
            </h2>

            <div class="max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="bg-white rounded-lg p-8">
                    @if ($impresszum && $impresszum->content)
                        <div class="prose prose-lg max-w-none text-gray-700">
                            {!! $impresszum->content !!}
                        </div>
                    @else
                        <div class="text-gray-600">
                            <p>Az impresszum tartalma még nem lett beállítva.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
