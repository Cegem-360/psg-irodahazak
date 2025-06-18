<x-layouts.app>
    <x-slot name="title">{{ $post->title }} | PSG-IRODAHÁZAK Blog</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="description" content="{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 160) }}">
        <meta name="keywords" content="{{ $post->meta_data['meta_keywords'] ?? 'blog, irodapiac, ingatlan' }}">
        <link rel="canonical" href="{{ Request::url() }}">

        <!-- Open Graph -->
        <meta property="og:title" content="{{ $post->title }}">
        <meta property="og:description" content="{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 160) }}">
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ Request::url() }}">
        @if ($post->featured_image)
            <meta property="og:image" content="{{ Storage::url($post->featured_image) }}">
        @endif

        <!-- Article Schema -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "headline": "{{ $post->title }}",
            "description": "{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 160) }}",
            "author": {
                "@type": "Person",
                "name": "{{ $post->author->name }}"
            },
            "datePublished": "{{ $post->published_at->toISOString() }}",
            "dateModified": "{{ $post->updated_at->toISOString() }}",
            @if($post->featured_image)
            "image": "{{ Storage::url($post->featured_image) }}",
            @endif
            "publisher": {
                "@type": "Organization",
                "name": "PSG-IRODAHÁZAK"
            }
        }
        </script>
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb -->
        <div class="bg-white border-b">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex items-center space-x-2 text-sm text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-blue-600">Főoldal</a>
                    <span>/</span>
                    <a href="{{ route('blog.index') }}" class="hover:text-blue-600">Blog</a>
                    <span>/</span>
                    <a href="{{ route('blog.category', $post->category->slug) }}"
                        class="hover:text-blue-600">{{ $post->category->name }}</a>
                    <span>/</span>
                    <span class="text-gray-900">{{ Str::limit($post->title, 50) }}</span>
                </nav>
            </div>
        </div>

        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Article Header -->
            <header class="mb-8">
                <div class="flex items-center mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white"
                        style="background-color: {{ $post->category->color }}">
                        {{ $post->category->name }}
                    </span>
                    <span class="ml-3 text-sm text-gray-500">{{ $post->reading_time }}</span>
                </div>

                <h1 class="text-4xl font-bold text-gray-900 leading-tight mb-6">{{ $post->title }}</h1>

                <div class="flex items-center justify-between text-sm text-gray-600 pb-6 border-b">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-medium">
                                {{ strtoupper(substr($post->author->name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">{{ $post->author->name }}</p>
                                <p class="text-gray-500">Szerző</p>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <p class="font-medium">{{ $post->published_at->format('Y. F j.') }}</p>
                            <p class="text-gray-500">Publikálva</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center text-gray-500">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ number_format($post->views_count) }} megtekintés
                        </div>
                    </div>
                </div>
            </header>

            <!-- Featured Image -->
            @if ($post->featured_image)
                <div class="mb-8">
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                        class="w-full h-auto rounded-lg shadow-lg">
                </div>
            @endif

            <!-- Article Content -->
            <div class="prose prose-lg max-w-none">
                @if ($post->excerpt)
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-8">
                        <p class="text-lg text-blue-800 font-medium italic">{{ $post->excerpt }}</p>
                    </div>
                @endif

                <div class="article-content">
                    {!! $post->content !!}
                </div>
            </div>

            <!-- Article Footer -->
            <footer class="mt-12 pt-8 border-t">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Kategória:</p>
                        <a href="{{ route('blog.category', $post->category->slug) }}"
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white hover:opacity-90 transition duration-150"
                            style="background-color: {{ $post->category->color }}">
                            {{ $post->category->name }}
                        </a>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 mb-2">Megosztás:</p>
                        <div class="flex space-x-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
                                target="_blank"
                                class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{ urlencode($post->title) }}"
                                target="_blank"
                                class="p-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition duration-150">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(Request::url()) }}"
                                target="_blank"
                                class="p-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition duration-150">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </article>

        <!-- Related Posts -->
        @if ($relatedPosts->count() > 0)
            <section class="bg-white border-t py-16">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Kapcsolódó cikkek</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($relatedPosts as $relatedPost)
                            <article
                                class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-md transition duration-300">
                                @if ($relatedPost->featured_image)
                                    <div class="aspect-w-16 aspect-h-9">
                                        <img src="{{ Storage::url($relatedPost->featured_image) }}"
                                            alt="{{ $relatedPost->title }}" class="w-full h-48 object-cover">
                                    </div>
                                @else
                                    <div
                                        class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <div class="flex items-center mb-3">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-white"
                                            style="background-color: {{ $relatedPost->category->color }}">
                                            {{ $relatedPost->category->name }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('blog.show', $relatedPost->slug) }}"
                                            class="hover:text-blue-600 transition duration-150">
                                            {{ $relatedPost->title }}
                                        </a>
                                    </h3>

                                    @if ($relatedPost->excerpt)
                                        <p class="text-gray-600 text-sm line-clamp-2">{{ $relatedPost->excerpt }}</p>
                                    @endif

                                    <div class="mt-4 text-xs text-gray-500">
                                        {{ $relatedPost->published_at->format('Y. m. d.') }}
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>

    <style>
        .article-content h2 {
            @apply text-2xl font-bold text-gray-900 mt-8 mb-4;
        }

        .article-content h3 {
            @apply text-xl font-semibold text-gray-900 mt-6 mb-3;
        }

        .article-content p {
            @apply text-gray-700 leading-relaxed mb-4;
        }

        .article-content ul,
        .article-content ol {
            @apply pl-6 mb-4;
        }

        .article-content li {
            @apply text-gray-700 leading-relaxed mb-2;
        }

        .article-content blockquote {
            @apply border-l-4 border-blue-400 pl-4 py-2 my-6 bg-blue-50 text-blue-800 italic;
        }

        .article-content img {
            @apply rounded-lg shadow-md my-6;
        }

        .article-content a {
            @apply text-blue-600 hover:text-blue-800 underline;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layouts.app>
