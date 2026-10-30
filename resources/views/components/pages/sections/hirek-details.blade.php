@php
    $news = [
        [
            'date' => '2025-05-09',
            'title' => __('The office building in the heart of Újbuda has been sold'),
            'url' => __('Details'),
        ],
        [
            'date' => '2025-04-16',
            'title' => __('Survey: Has the home office rate peaked in Hungary?'),
            'url' => __('Details'),
        ],
        [
            'date' => '2025-02-03',
            'title' => __('Was last year the low point of the office market?'),
            'url' => __('Details'),
        ],
        [
            'date' => '2025-01-03',
            'title' => __('The Stock Exchange Palace has changed owners - What will become of the historic building?'),
            'url' => __('Details'),
        ],
        [
            'date' => '2024-12-02',
            'title' =>
                __('Successful investment transaction in Budapest: the Honvéd Center office building was sold to a German investor'),
            'url' => __('Details'),
        ],
        [
            'date' => '2024-11-07',
            'title' => __('In the next two years, Budapest will deliver almost as many offices as the entire region'),
            'url' => __('Details'),
        ],
        [
            'date' => '2024-10-02',
            'title' => __('Monday to Friday in the office - like in the "good old days"?'),
            'url' => __('Details'),
        ],
        [
            'date' => '2024-09-02',
            'title' => __('Who would have thought! In 2024 Budapest became the most popular workcation city in the world'),
            'url' => __('Details'),
        ],
        [
            'date' => '2024-08-08',
            'title' => __('A turnaround in the office market - It seems this will be the new trend'),
            'url' => __('Details'),
        ],
        [
            'date' => '2024-07-02',
            'title' => __('HOP Technology Office Park on Hungária körút is being renovated'),
            'url' => __('Details'),
        ],
    ];
@endphp

<x-page-section>
    <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
        {{ __('News') }}</h2>

    <x-glass-panel>
        @foreach ($news as $newsItem)
            <div
                class="relative flex flex-col md:flex-row justify-start items-center gap-6 p-6 border-b border-gray-300 hover:brightness-95 transition-all duration-300 ease-in-out">
                <p class="text-gray-600">{{ $newsItem['date'] }}</p>
                <h3 class="text-xl font-semibold">{{ $newsItem['title'] }}</h3>
                <div class="md:ml-auto">
                    <a href="#"
                        class="px-3 py-1 text-sm bg-primary/70 text-white rounded hover:bg-primary/90 transition-colors duration-300 ease-in-out after:absolute after:inset-0 after:cursor-pointer">{{ $newsItem['url'] }}</a>
                </div>
            </div>
        @endforeach
    </x-glass-panel>

    <x-glass-panel padding="px-8 py-3" class="flex justify-center gap-8">
        {{-- Pagination --}}
        @include('pages.forms.pagination')
    </x-glass-panel>
</x-page-section>
