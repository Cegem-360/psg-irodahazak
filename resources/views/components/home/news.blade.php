<div class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 py-16 space-y-8">
        <h2>
            <span
                class="uppercase bg-linear-to-r from-accentdark to-accent text-white text-2xl font-bold py-2 px-6 rounded">{{ __('News') }}</span>
        </h2>

        <div class="grid grid-cols-1 gap-4 md:gap-8 max-w-7xl mx-auto">
            {{-- News post --}}
            @foreach ($news as $newsItem)
                <div class="grid md:grid-cols-2 gap-4 bg-white rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
                    @if ($newsItem->featured_image)
                        <img src="{{ Storage::url($newsItem->featured_image) }}" alt="{{ $newsItem->title }}" loading="lazy"
                            class="md:order-2 w-full h-auto object-cover aspect-video" />
                    @endif

                    <div class="p-8 pt-10">
                        <div>
                            <div class="md:p-8 md:pt-10 flex flex-col md:flex-row md:items-center md:justify-between">
                                <h3 class="text-xl font-semibold mb-2 md:mb-4">{{ $newsItem->title }}</h3>
                                <span
                                    class="text-orange-500 font-medium mb-4 italic md:not-italic">{{ $newsItem->published_at->format('Y.m.d') }}</span>
                            </div>

                        </div>
                        <div class="text-justify">
                            {!! $newsItem->excerpt !!}
                        </div>

                        <a wire:navigate.hover href="{{ localized_route('news.show', ['news' => $newsItem->slug]) }}"
                            class="inline-block mt-6 px-6 py-2 bg-primary/70 text-white rounded hover:bg-accent/80 transition-colors">{{ __('Full article') }}</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
