<x-layouts.app>
    <x-slot name="title">{{ $news->title }} | PSG-IRODAHÁZAK Hírek</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="description" content="{{ $news->excerpt }}">
        <meta name="keywords" content="hír, irodaház, irodabérlet">
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
        <meta property="article:published_time" content="{{ $news?->published_at?->toISOString() }}">
        <meta property="article:author" content="{{ $news->author->name }}">
        @if ($news->category)
            <meta property="article:section" content="{{ $news->category->name }}">
        @endif
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Breadcrumb -->

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <article class="bg-white rounded-lg shadow-sm overflow-hidden">
                <!-- Article Header -->
                <div class="p-8">

                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>

                </div>

                <!-- Featured Image -->
                @if ($news->featured_image)
                    <div class="px-8 mb-8">
                        <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}"
                            class="w-full h-64 lg:h-96 object-cover rounded-lg" loading="lazy">
                    </div>
                @endif

                <!-- Article Content -->
                <div class="px-8 pb-8">
                    <div class="prose prose-lg max-w-none">
                        {!! $news->excerpt !!}
                    </div>
                </div>

                <!-- Article Content -->
                <div class="px-8 pb-8">
                    <div class="prose prose-lg max-w-none">
                        {!! $news->content !!}
                    </div>
                </div>
                <!-- Article Content -->
                @if ($news->source)
                    <div class="px-8 pb-8">
                        <div class="prose prose-lg max-w-none">
                            <span class="font-semibold text-blue-700 bg-blue-100 px-2 py-1 rounded">
                                Forrás: {{ $news->source }}
                            </span>
                        </div>
                    </div>
                @endif

            </article>

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
