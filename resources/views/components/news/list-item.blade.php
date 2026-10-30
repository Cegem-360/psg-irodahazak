@props(['article'])

<div
    class="relative flex flex-col md:flex-row justify-start items-center gap-6 p-6 border-b border-gray-300 hover:brightness-95 transition-all duration-300 ease-in-out">
    <p class="text-gray-600">{{ $article->published_at?->format('Y-m-d') }}</p>
    <h3 class="text-xl font-semibold">{{ $article->title }}</h3>
    <div class="md:ml-auto">
        <a href="{{ localized_route('news.show', ['slug' => $article->slug]) }}"
            class="px-3 py-1 text-sm bg-primary/70 text-white rounded hover:bg-primary/90 transition-colors duration-300 ease-in-out after:absolute after:inset-0 after:cursor-pointer">{{ __('Details') }}</a>
    </div>
</div>
