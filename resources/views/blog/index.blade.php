<x-layouts.app>
    <x-slot name="title">Blog | PSG-IRODAHÁZAK</x-slot>
    <x-slot name="meta">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="description"
            content="PSG-IRODAHÁZAK blog - Legfrissebb hírek, útmutatók és szakmai cikkek az irodapiaci világból.">
        <meta name="keywords" content="blog, irodapiac, ingatlan hírek, irodaházak, irodák bérlése">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-4">PSG Blog</h1>
                    <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                        Legfrissebb hírek, szakmai tanácsok és irodapiaci trendek
                    </p>
                </div>

                <!-- Search Form -->
                <div class="mt-8 max-w-md mx-auto">
                    <form method="GET" action="{{ route('blog.index') }}" class="flex">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Keresés..."
                            class="flex-1 px-4 py-3 rounded-l-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit"
                            class="px-6 py-3 bg-blue-700 hover:bg-blue-800 rounded-r-lg font-medium transition duration-150">
                            Keresés
                        </button>
                    </form>
                </div>
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
                                <a href="{{ route('blog.index') }}"
                                    class="flex items-center justify-between text-gray-600 hover:text-blue-600 transition duration-150 {{ !request('category') ? 'text-blue-600 font-medium' : '' }}">
                                    <span>Összes bejegyzés</span>
                                    <span class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $posts->total() }}</span>
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('blog.category', $category->slug) }}"
                                        class="flex items-center justify-between text-gray-600 hover:text-blue-600 transition duration-150">
                                        <span class="flex items-center">
                                            <span class="w-3 h-3 rounded-full mr-2"
                                                style="background-color: {{ $category->color }}"></span>
                                            {{ $category->name }}
                                        </span>
                                        <span
                                            class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $category->blog_posts_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="lg:col-span-3">
                    @if ($posts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach ($posts as $post)
                                <article
                                    class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
                                    @if ($post->featured_image)
                                        <div class="aspect-w-16 aspect-h-9">
                                            <img src="{{ Storage::url($post->featured_image) }}"
                                                alt="{{ $post->title }}" class="w-full h-48 object-cover">
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
                                                style="background-color: {{ $post->category->color }}">
                                                {{ $post->category->name }}
                                            </span>
                                            <span class="ml-2 text-sm text-gray-500">{{ $post->reading_time }}</span>
                                        </div>

                                        <h2 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                                            <a href="{{ route('blog.show', $post->slug) }}"
                                                class="hover:text-blue-600 transition duration-150">
                                                {{ $post->title }}
                                            </a>
                                        </h2>

                                        @if ($post->excerpt)
                                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                        @endif

                                        <div class="flex items-center justify-between text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <span>{{ $post->author->name }}</span>
                                                <span class="mx-2">•</span>
                                                <time>{{ $post->published_at->format('Y. m. d.') }}</time>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                {{ $post->views_count }}
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Nincs találat</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if (request('search'))
                                    Nem találtunk bejegyzést a "{{ request('search') }}" keresőkifejezésre.
                                @else
                                    Jelenleg nincsenek publikált blog bejegyzések.
                                @endif
                            </p>
                            @if (request('search'))
                                <div class="mt-6">
                                    <a href="{{ route('blog.index') }}"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-600 bg-blue-100 hover:bg-blue-200 transition duration-150">
                                        Összes bejegyzés megtekintése
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-layouts.app>
