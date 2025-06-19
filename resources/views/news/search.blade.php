<x-layouts.app>
    <x-slot name="title">Keresés: "{{ $search }}" | PSG-IRODAHÁZAK Hírek</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="noindex, follow">
        <meta name="description" content="Keresési eredmények: {{ $search }} - PSG-IRODAHÁZAK hírek">
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Search Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-4">Keresési eredmények</h1>
                    @if ($search)
                        <p class="text-xl text-blue-100 max-w-2xl mx-auto mb-2">
                            Keresett kifejezés: <span class="font-semibold">"{{ $search }}"</span>
                        </p>
                        <p class="text-blue-200">{{ $news->total() }} találat</p>
                    @endif
                </div>

                <!-- Search Form -->
                <div class="mt-8 max-w-md mx-auto">
                    <form method="GET" action="{{ localized_route('news.search') }}" class="flex">
                        <input type="text" name="q" value="{{ $search }}"
                            placeholder="Keresés a hírekben..."
                            class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit"
                            class="px-6 py-3 bg-blue-700 hover:bg-blue-800 rounded-r-lg font-medium transition duration-150">
                            Keresés
                        </button>
                    </form>
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
                            <span class="ml-4 text-gray-500">Keresés</span>
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
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Szűrés kategóriák szerint</h3>
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ localized_route('news.search', ['q' => $search]) }}"
                                    class="flex items-center justify-between text-gray-600 hover:text-blue-600 transition duration-150 {{ !request('category') ? 'text-blue-600 font-medium' : '' }}">
                                    <span>Minden kategória</span>
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ localized_route('news.search', ['q' => $search, 'category' => $category->slug]) }}"
                                        class="flex items-center justify-between text-gray-600 hover:text-blue-600 transition duration-150">
                                        <span class="flex items-center">
                                            @if ($category->icon)
                                                <span class="mr-2">{{ $category->icon }}</span>
                                            @endif
                                            {{ $category->name }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="lg:col-span-3">
                    @if ($search && $news->count() > 0)
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
                                            <a href="{{ localized_route('news.show', ['slug' => $article->slug]) }}"
                                                class="hover:text-blue-600 transition duration-150">
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
                                {{ $news->appends(['q' => $search])->links() }}
                            </div>
                        @endif
                    @elseif($search)
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">🔍</div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Nincs találat</h3>
                            <p class="text-gray-600 mb-6">
                                Nem találtunk hírt a következő keresésre: <strong>"{{ $search }}"</strong>
                            </p>
                            <div class="space-y-2 text-sm text-gray-500">
                                <p>Javaslatok:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Ellenőrizze a helyesírást</li>
                                    <li>Próbáljon kevesebb vagy általánosabb kifejezéseket</li>
                                    <li>Használjon szinonimákat</li>
                                </ul>
                            </div>
                            <div class="mt-6">
                                <a href="{{ localized_route('news.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                                    Vissza az összes hírhez
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">🔍</div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Adjon meg keresési kifejezést</h3>
                            <p class="text-gray-600">Használja a fenti keresőmezőt hírek kereséséhez.</p>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-layouts.app>
