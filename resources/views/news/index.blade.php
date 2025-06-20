<x-layouts.app>
    <x-slot name="title">Hírek | PSG-IRODAHÁZAK</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="description"
            content="PSG-IRODAHÁZAK hírek - Legfrissebb hírek, fejlesztések és szakmai információk az irodapiaci világból.">
        <meta name="keywords" content="hírek, irodapiac, ingatlan hírek, irodaházak, irodabérlet, szakmai hírek">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>
    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                Hírek</h2>

            <div class="max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                @foreach ($news as $index => $article)
                    <div
                        class="relative flex flex-col md:flex-row justify-start items-center gap-6 p-6 border-b border-gray-300 hover:brightness-95 transition-all duration-300 ease-in-out">
                        <p class="text-gray-600">{{-- {{ $article?->published_at->format('Y.m.d.') }} --}}</p>
                        <h3 class="text-xl font-semibold">{{ $article->title }}</h3>
                        <div class="md:ml-auto">
                            <a href="{{ localized_route('news.show', ['slug' => $article->slug]) }}"
                                class="px-3 py-1 text-sm bg-primary/70 text-white rounded hover:bg-primary/90 transition-colors duration-300 ease-in-out after:absolute after:inset-0 after:cursor-pointer">{{ $article->title }}</a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($news->lastPage() > 1)
                <div
                    class="flex justify-center gap-8 max-w-screen-xl mx-auto px-8 py-3 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                    {{-- Pagination --}}
                    {{ $news->links() }}
                </div>
            @endif

        </div>
    </div>
</x-layouts.app>
