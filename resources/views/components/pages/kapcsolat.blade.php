<div>

    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                Kapcsolat</h2>

            <div class="max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 border-b border-gray-300 hover:brightness-95 transition-all duration-300 ease-in-out">
                    <div>
                        <h3 class="mb-3 text-logogray/80 text-xl">Propety Solution Group Kft.</h3>
                        <p class="mb-3 text-gray-600">
                            office: 1016 Budapest, Derék u. 2.
                        </p>
                        <p class="mb-3 text-gray-600">
                            Tel.: +36 20 381 3917
                        </p>
                        <p>mail: <a class="text-primary" href="mailto:info@psg-irodahazak.hu">info@psg-irodahazak.hu</a>
                        </p>
                    </div>
                    <div class="flex justify-center"><img class="mb-3"
                            src="{{ Vite::asset('resources/images/kapcsolat.jpg') }}" />
                    </div>
                </div>
            </div>

        </div>
    </div>

    <x-pages.sections.ajanlat />

</div>
