@use('Illuminate\Support\Facades\Storage')
@use('App\Models\News')
<div class="bg-gray-100">
    <div class="max-w-screen-xl mx-auto px-4 py-16 space-y-8">
        <h2 class="">
            <span
                class="uppercase bg-gradient-to-r from-accentdark to-accent text-white text-2xl font-bold py-2 px-6 rounded">{{ __('News') }}</span>
        </h2>

        <div class="grid grid-cols-1 gap-4 md:gap-8 max-w-screen-xl mx-auto">
            <!-- News post -->
            @foreach (News::published()->orderByDesc('published_at')->limit(3)->get() as $news)
                <div class="grid md:grid-cols-2 gap-4 bg-white rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
                    <img src="{{ Storage::url($news->featured_image) }}" alt=""
                        class="md:order-2 w-full h-auto object-cover aspect-[16/9]" />
                    <div class="p-8 pt-10">
                        {!! $news->excerpt !!}
                        <a href="{{ localized_route('news.show', ['slug' => $news->slug]) }}"
                            class="inline-block mt-6 px-6 py-2 bg-primary/70 text-white rounded hover:bg-accent/80 transition-colors">{{ __('Full article') }}</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
