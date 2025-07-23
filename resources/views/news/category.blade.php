<x-layouts.app>
    <x-slot name="title">{{ $category->name }} Hírek | PSG-IRODAHÁZAK</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="description"
            content="{{ $category->description ?: $category->name . ' kategória hírei a PSG-IRODAHÁZAK oldalán.' }}">
        <meta name="keywords" content="{{ $category->name }}, hírek, irodaház, irodabérlet">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Category Header -->
        <div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-4">
                        @if ($category->icon)
                            <span class="text-4xl mr-3">{{ $category->icon }}</span>
                        @endif
                        <h1 class="text-4xl font-bold">{{ $category->name }}</h1>
                    </div>
                    @if ($category->description)
                        <p class="text-xl text-gray-300 max-w-2xl mx-auto">{{ $category->description }}</p>
                    @endif
                    <p class="text-gray-400 mt-2">{{ $news->total() }} hír ebben a kategóriában</p>
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
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
                        <li class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-4 text-gray-500">{{ $category->name }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Kategóriák</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ localized_route('news.index') }}"
                                    class="flex items-center justify-between text-gray-600 hover:text-red-600 transition duration-150">
                                    <span>Összes hír</span>
                                </a>
                            </li>
                            @foreach ($allCategories as $cat)
                                <li>
                                    <a href="{{ localized_route('news.category', ['slug' => $cat->slug]) }}"
                                        class="flex items-center justify-between text-gray-600 hover:text-red-600 transition duration-150 {{ $cat->id === $category->id ? 'text-red-600 font-medium' : '' }}">
                                        <span class="flex items-center">
                                            @if ($cat->icon)
                                                <span class="mr-2">{{ $cat->icon }}</span>
                                            @endif
                                            {{ $cat->name }}
                                        </span>
                                        <span
                                            class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $cat->published_news_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="lg:col-span-3">
                    @if ($news->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach ($news as $article)
                                <article
                                    class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-150">
                                    @if ($article->featured_image)
                                        <img src="{{ Storage::url($article->featured_image) }}"
                                            alt="{{ $article->title }}" class="w-full h-48 object-cover"
                                            loading="lazy">
                                    @endif
                                    <div class="p-6">
                                        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                            <div class="flex items-center">
                                                <span class="inline-block px-2 py-1 rounded text-xs font-medium mr-2"
                                                    style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                                                    {{ $category->name }}
                                                </span>
                                                <time>{{ $article?->published_at->format('Y.m.d.') }}</time>
                                            </div>
                                            @if ($article->is_breaking)
                                                <span
                                                    class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">
                                                    Fontos
                                                </span>
                                            @endif
                                        </div>

                                        <h2 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                                            <a href="{{ localized_route('news.show', $article->slug) }}"
                                                class="hover:text-red-600 transition duration-150">
                                                {{ $article->title }}
                                            </a>
                                        </h2>

                                        <p class="text-gray-600 line-clamp-3 mb-4">{{ $article->excerpt }}</p>

                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <span class="mr-4">{{ $article->author->name }}</span>
                                                <span>{{ $article->views_count }} megtekintés</span>
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $article->reading_time }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if ($news->hasPages())
                            <div class="mt-12">
                                {{ $news->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">{{ $category->icon ?: '📰' }}</div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Nincs hír ebben a kategóriában</h3>
                            <p class="text-gray-600">Jelenleg nincs publikált hír a {{ $category->name }} kategóriában.
                            </p>
                            <div class="mt-6">
                                <a href="{{ localized_route('news.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                                    Vissza az összes hírhez
                                </a>
                            </div>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-layouts.app>
