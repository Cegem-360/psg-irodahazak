<div>
    @php
        $language = app()->getLocale() ?? 'hu';
        $aboutUses = \App\Models\AboutUs::active()->byLanguage($language)->get();
    @endphp

    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('About Us') }}</h2>

            <div class="max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="p-6">
                    @foreach ($aboutUses as $item)
                        <p class="mb-3 text-gray-600">
                            {!! $item->content !!}<br />
                        </p>
                    @endforeach

                </div>
                <img src="{{ Vite::asset('resources/images/psg_montazs.webp') }}"
                    class="w-full h-auto mt-6 rounded-lg shadow-lg"
                    alt="{{ $aboutUses->first()?->title ?? __('About Us') }}" />
            </div>

        </div>
    </div>

</div>
