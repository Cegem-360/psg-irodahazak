@use('App\Models\BlogPost')
<div class="max-w-screen-xl mx-auto px-4 pt-6 pb-16 space-y-8">
    <h2 class="">
        <span
            class="bg-gradient-to-r from-accentdark to-accent text-white text-2xl font-bold py-2 px-6 rounded">{{ __('BLOG') }}</span>
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-screen-xl mx-auto">
        <!-- Blog post -->
        @foreach (BlogPost::orderBy('published_at', 'desc')->take(3)->get() as $blogPost)
            <div class="bg-white/10 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
                <img src="{{ $blogPost->featured_image }}" alt=""
                    class="w-full h-auto object-cover aspect-[16/9]" />

                <div class="p-8">
                    <h3 class="min-h-20 text-xl font-bold mb-2">{{ $blogPost->title }}</h3>
                    <p class="text-md italic text-primary my-2">{{ $blogPost->published_at->format('Y.m.d') }}</p>
                    <p class="text-gray-700 min-h-48 text-justify">{{ $blogPost->excerpt }}</p>

                    <a href="#"
                        class="inline-block mb-4 px-6 py-2 bg-primary/70 text-white rounded hover:bg-accent/80 transition-colors">
                        Teljes cikk
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
