<div>

    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('About Us') }}</h2>

            <div class="max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="p-6">
                    <p class="mb-3 text-gray-600">
                        {{ __('About us page content 1') }}
                    </p>
                    <p class="mb-3 text-gray-600">
                        {{ __('About us page content 2') }}
                    </p>
                    <p class="mb-3 text-gray-600">
                        {{ __('About us page content 3') }}
                    </p>
                </div>
                <img src="{{ Vite::asset('resources/images/psg_montazs.webp') }}"
                    class="w-full h-auto mt-6 rounded-lg shadow-lg" alt="Rólunk" />
            </div>

        </div>
    </div>

</div>
