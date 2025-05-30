    <div class="relative bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ Vite::asset('resources/images/details-in-the-facade-of-modern-architecture-2025-03-23-22-01-52-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white to-white/70"></div>
        <div class="relative z-10 container mx-auto pt-12 pb-20">
            {{-- <h2
                class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow bg-clip-text text-transparent bg-gradient-to-r from-indigo-950 to-violet-600">
                Kereső</h2> --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-screen-xl mx-auto">
                <div class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
                    <!-- Térkép -->
                    <h3 class="text-lg mb-4">Térképes keresés</h3>
                    <x-svg.bp-map class="h-96" />
                    <label class="text-sm text-primary flex items-center">
                        <input type="checkbox" class="mr-2 appearance-none checked:bg-accent focus:ring-accent ">
                        Agglomeráció találatait is mutassa
                    </label>
                </div>

                <div class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
                    <!-- Keresőmezők -->
                    <h3 class="text-lg mb-4">Keresési feltételek</h3>
                    <select class="w-full border border-gray-300 rounded-xl px-4 py-2">
                        <option disabled selected>Válasszon kerületet!</option>
                        <option>I. kerület</option>
                        <option>II. kerület</option>
                        <!-- Továbbiak... -->
                    </select>

                    <select class="w-full border border-gray-300 rounded-xl px-4 py-2">
                        <option disabled selected>Irodaház neve</option>
                        <option>Árpád Center</option>
                        <option>RiverPark</option>
                        <!-- Továbbiak... -->
                    </select>

                    <input type="text" placeholder="Keresett kifejezés"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2">
                </div>

                <div class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
                    <!-- Range szűrők -->
                    <h3 class="text-lg mb-4">Szűrés paraméterek szerint</h3>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold">Alapterület (m²)</label>
                        <input type="range" min="0" max="3000" value="0"
                            class="w-full accent-blue-600">
                        <div class="flex justify-between text-sm">
                            <span>0</span>
                            <span>3000+</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold">Bérleti díj (€/m²)</label>
                        <input type="range" min="1" max="30" value="1"
                            class="w-full accent-blue-600">
                        <div class="flex justify-between text-sm">
                            <span>1</span>
                            <span>30+</span>
                        </div>
                    </div>

                    <!-- Keresés gomb -->
                    <div>
                        <button
                            class="w-full bg-primary text-white font-semibold px-8 py-2 rounded hover:bg-accent/80 transition">
                            KERESÉS
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
