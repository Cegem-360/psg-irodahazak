@php
    $news = [
        [
            'date' => '2025-05-09',
            'title' => 'Eladták az Újbuda szívében épült irodaházat',
            'url' => 'Részletek',
        ],
        [
            'date' => '2025-04-16',
            'title' => 'Felmérés: Tetőzik a home office-arány hazánkban?',
            'url' => 'Részletek',
        ],
        [
            'date' => '2025-02-03',
            'title' => 'A tavalyi év volt az irodapiac mélypontja?',
            'url' => 'Részletek',
        ],
        [
            'date' => '2025-01-03',
            'title' => 'Tulajdonost váltott a Tőzsdepalota - Mi lesz a történelmi épület sorsa?',
            'url' => 'Részletek',
        ],
        [
            'date' => '2024-12-02',
            'title' =>
                'Sikeres befektetési tranzakció Budapesten: német befektetőnek adták el a Honvéd Center irodaházat',
            'url' => 'Részletek',
        ],
        [
            'date' => '2024-11-07',
            'title' => 'A következő két évben annyi irodát adnak át Budapesten, mint szinte az egész régióban',
            'url' => 'Részletek',
        ],
        [
            'date' => '2024-10-02',
            'title' => 'Hétfőtől péntekig az irodában - mint a "régi szép időkben"?',
            'url' => 'Részletek',
        ],
        [
            'date' => '2024-09-02',
            'title' => 'Ezt is megértük! 2024-ben Budapest lett a világ legnépszerűbb workcation városa',
            'url' => 'Részletek',
        ],
        [
            'date' => '2024-08-08',
            'title' => 'Fordulat az irodapiacon - Úgy tűnik, ez lesz az új trend',
            'url' => 'Részletek',
        ],
        [
            'date' => '2024-07-02',
            'title' => 'Megújul a HOP Technology Office Park a Hungária körúton',
            'url' => 'Részletek',
        ],
    ];
@endphp

<div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
    style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
    <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
    <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
        <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
            Hírek</h2>

        <div class="max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
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
        </div>

        <div
            class="flex justify-center gap-8 max-w-screen-xl mx-auto px-8 py-3 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
            {{-- Pagination --}}
            @include('pages.forms.pagination')
        </div>

    </div>
</div>
