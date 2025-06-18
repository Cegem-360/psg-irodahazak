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

    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-4">PSG Hírek</h1>
                    <p class="text-xl text-red-100 max-w-2xl mx-auto">
                        Legfrissebb hírek és fejlesztések az irodapiaci világból
                    </p>
                </div>

                <!-- Search Form -->
                <div class="mt-8 max-w-md mx-auto">
                    <form method="GET" action="{{ route('news.search') }}" class="flex">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Keresés a hírekben..."
                            class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <button type="submit"
                            class="px-6 py-3 bg-red-700 hover:bg-red-800 rounded-r-lg font-medium transition duration-150">
                            Keresés
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Breaking News -->
            @if ($breakingNews->count() > 0)
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <span class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium mr-3">
                            🚨 FONTOS HÍREK
                        </span>
                        <div class="flex-1 h-px bg-red-200"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($breakingNews as $breaking)
                            <article
                                class="bg-white rounded-lg shadow-sm border-l-4 border-red-500 overflow-hidden hover:shadow-md transition duration-150">
                                @if ($breaking->featured_image)
                                    <img src="{{ Storage::url($breaking->featured_image) }}"
                                        alt="{{ $breaking->title }}" class="w-full h-48 object-cover">
                                @endif
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        @if ($breaking->category)
                                            <span class="inline-block px-2 py-1 rounded text-xs font-medium mr-2"
                                                style="background-color: {{ $breaking->category->color }}20; color: {{ $breaking->category->color }}">
                                                {{ $breaking->category->name }}
                                            </span>
                                        @endif
                                        <time>{{ $breaking->published_at->format('Y.m.d.') }}</time>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                        <a href="{{ route('news.show', $breaking->slug) }}"
                                            class="hover:text-red-600 transition duration-150">
                                            {{ $breaking->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 text-sm line-clamp-3">{{ $breaking->excerpt }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Kategóriák</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('news.index') }}"
                                    class="flex items-center justify-between text-gray-600 hover:text-red-600 transition duration-150 {{ !request('category') ? 'text-red-600 font-medium' : '' }}">
                                    <span>Összes hír</span>
                                    <span class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $news->total() }}</span>
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('news.category', $category->slug) }}"
                                        class="flex items-center justify-between text-gray-600 hover:text-red-600 transition duration-150">
                                        <span class="flex items-center">
                                            @if ($category->icon)
                                                <span class="mr-2">{{ $category->icon }}</span>
                                            @endif
                                            {{ $category->name }}
                                        </span>
                                        <span
                                            class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $category->published_news_count }}</span>
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
                                            alt="{{ $article->title }}" class="w-full h-48 object-cover">
                                    @endif
                                    <div class="p-6">
                                        <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                            <div class="flex items-center">
                                                @if ($article->category)
                                                    <span
                                                        class="inline-block px-2 py-1 rounded text-xs font-medium mr-2"
                                                        style="background-color: {{ $article->category->color }}20; color: {{ $article->category->color }}">
                                                        {{ $article->category->name }}
                                                    </span>
                                                @endif
                                                <time>{{ $article->published_at->format('Y.m.d.') }}</time>
                                            </div>
                                            @if ($article->is_breaking)
                                                <span
                                                    class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">
                                                    Fontos
                                                </span>
                                            @endif
                                        </div>

                                        <h2 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                                            <a href="{{ route('news.show', $article->slug) }}"
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
                            <div class="text-gray-400 text-6xl mb-4">📰</div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Nincs megjeleníthető hír</h3>
                            <p class="text-gray-600">Próbálkozzon később vagy változtassa meg a keresési feltételeket.
                            </p>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-layouts.app>
