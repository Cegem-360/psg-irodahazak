<x-layouts.app>
    <x-slot name="title">{{ $news->title }} | PSG-IRODAHÁZAK Hírek</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="description" content="{{ $news->excerpt }}">
        <meta name="keywords" content="hír, {{ $news->category?->name }}, irodaház, irodabérlet">
        <link rel="canonical" href="{{ Request::url() }}">

        <!-- Open Graph -->
        <meta property="og:title" content="{{ $news->title }}">
        <meta property="og:description" content="{{ $news->excerpt }}">
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ Request::url() }}">
        @if ($news->featured_image)
            <meta property="og:image" content="{{ Storage::url($news->featured_image) }}">
        @endif

        <!-- Article specific -->
        <meta property="article:published_time" content="{{ $news->published_at->toISOString() }}">
        <meta property="article:author" content="{{ $news->author->name }}">
        @if ($news->category)
            <meta property="article:section" content="{{ $news->category->name }}">
        @endif
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb -->
        <div class="bg-white border-b">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <a href="{{ localized_route('home') }}"
                                class="text-gray-500 hover:text-gray-700 transition duration-150">
                                Főoldal
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ localized_route('news.index') }}"
                                class="ml-4 text-gray-500 hover:text-gray-700 transition duration-150">
                                Hírek
                            </a>
                        </li>
                        @if ($news->category)
                            <li class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ localized_route('news.category', ['slug' => $news->category->slug]) }}"
                                    class="ml-4 text-gray-500 hover:text-gray-700 transition duration-150">
                                    {{ $news->category->name }}
                                </a>
                            </li>
                        @endif
                        <li class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-4 text-gray-500 truncate">{{ $news->title }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Article Header -->
                <div class="p-8">
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            @if ($news->category)
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium mr-3"
                                    style="background-color: {{ $news->category->color }}20; color: {{ $news->category->color }}">
                                    {{ $news->category->icon }} {{ $news->category->name }}
                                </span>
                            @endif
                            <time>{{ $news->published_at->format('Y. F j. H:i') }}</time>
                        </div>
                        @if ($news->is_breaking)
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                🚨 Fontos hír
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>

                    @if ($news->excerpt)
                        <p class="text-xl text-gray-600 leading-relaxed mb-6">{{ $news->excerpt }}</p>
                    @endif

                    <div class="flex items-center justify-between border-b pb-6 mb-8">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-600">
                                        {{ substr($news->author->name, 0, 2) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $news->author->name }}</p>
                                <p class="text-sm text-gray-500">Szerző</p>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 space-x-4">
                            <span>{{ $news->views_count }} megtekintés</span>
                            <span>{{ $news->reading_time }}</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                @if ($news->featured_image)
                    <div class="px-8 mb-8">
                        <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}"
                            class="w-full h-64 lg:h-96 object-cover rounded-lg">
                    </div>
                @endif

                <!-- Article Content -->
                <div class="px-8 pb-8">
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>
            </article>

            <!-- Related News -->
            @if ($relatedNews->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kapcsolódó hírek</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($relatedNews as $related)
                            <article
                                class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-150">
                                @if ($related->featured_image)
                                    <img src="{{ Storage::url($related->featured_image) }}"
                                        alt="{{ $related->title }}" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        @if ($related->category)
                                            <span class="inline-block px-2 py-1 rounded text-xs font-medium mr-2"
                                                style="background-color: {{ $related->category->color }}20; color: {{ $related->category->color }}">
                                                {{ $related->category->name }}
                                            </span>
                                        @endif
                                        <time>{{ $related->published_at->format('Y.m.d.') }}</time>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                        <a href="{{ localized_route('news.show', ['slug' => $related->slug]) }}"
                                            class="hover:text-red-600 transition duration-150">
                                            {{ $related->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 text-sm line-clamp-3">{{ $related->excerpt }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Back to News -->
            <div class="mt-12 text-center">
                <a href="{{ localized_route('news.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Vissza a hírekhez
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
