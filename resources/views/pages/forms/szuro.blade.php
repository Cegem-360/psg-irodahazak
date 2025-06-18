<div>
    <div class="relative">
        <h2 class="text-4xl text-center mt-24 mb-8">Találja meg velünk vállalkozása <span class="text-primary">új
                ideális</span> otthonát</h2>
        <div class="absolute -right-8 -top-10 z-10 w-1/3 text-accent/40 blur-3xl"><x-svg.psg-irodahazak-symbol-1 />
        </div>
        <div class="absolute -left-8 -top-16 z-10 w-1/3 text-accent/30 blur-3xl"><x-svg.psg-irodahazak-symbol-2 />
        </div>
        <div class="absolute left-[50%] -translate-x-[50%] -bottom-40 z-10 w-96 text-accent/30 blur-3xl">
            <x-svg.psg-irodahazak-symbol-3 />
        </div>
    </div>
    <div class="relative bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ Vite::asset('resources/images/office-building-2025-03-18-12-43-13-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto pt-12 pb-20">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-screen-xl mx-auto">
                <div
                    class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl border border-white/10">
                    <!-- Térkép -->
                    <h3 class="text-lg mb-4">Térképes keresés</h3>
                    <x-svg.bp-map class="h-96" />
                    <label class="text-sm text-primary flex items-center">
                        <input type="checkbox" class="mr-2 appearance-none checked:bg-accent focus:ring-accent ">
                        Agglomeráció találatait is mutassa
                    </label>
                </div>

                <div
                    class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl border border-white/10">
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

                <div
                    class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl border border-white/10">
                    <!-- Range szűrők -->
                    <h3 class="text-lg mb-4">Szűrés paraméterek szerint</h3>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold">Alapterület (m²)</label>
                        <input type="text" class="terulet-slider" name="terulet_range" value="" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold">Bérleti díj (€/m²)</label>
                        <input type="text" class="ar-slider" name="ar_range" value="" />
                    </div>

                    <!-- Keresés gomb -->
                    <div>
                        <button
                            class="w-full bg-primary/70 text-white font-semibold px-8 py-2 rounded hover:bg-accent/80 transition">
                            KERESÉS
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <script>
            document.addEventListener('livewire:initialized', function() {
                // Initialize the range slider
                $('.terulet-slider').ionRangeSlider({
                    type: "double",
                    min: 0,
                    max: 3000,
                    from: 0,
                    to: 3000,
                    grid: true,
                    skin: "round",
                    postfix: "&nbsp;m²"
                });
                $('.ar-slider').ionRangeSlider({
                    type: "double",
                    min: 1,
                    max: 60,
                    from: 1,
                    to: 60,
                    grid: true,
                    skin: "round",
                    postfix: "&nbsp;€/m²"
                });
            });
        </script>
    </div>
</div>
