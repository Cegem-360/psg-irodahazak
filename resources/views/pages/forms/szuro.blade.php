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
            <form id="filterForm" method="GET" action="{{ route('kiado-irodak') }}" class="search-form">
                <!-- Hidden inputs for map selection and parameters -->
                <input type="hidden" name="type" value="rent">
                <input type="hidden" name="district" id="selectedDistrict" value="">
                <input type="hidden" name="area_min" id="areaMin" value="">
                <input type="hidden" name="area_max" id="areaMax" value="">
                <input type="hidden" name="price_min" id="priceMin" value="">
                <input type="hidden" name="price_max" id="priceMax" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-screen-xl mx-auto">
                    <div
                        class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl border border-white/10">
                        <!-- Térkép -->
                        <h3 class="text-lg mb-4">Térképes keresés</h3>
                        <div class="map-container">
                            <x-svg.bp-map class="h-96" />
                            <div id="selectedDistrictDisplay" class="mt-2 text-sm text-primary font-semibold hidden">
                                Kiválasztott kerület: <span id="districtName"></span>
                            </div>
                        </div>
                        <label class="text-sm text-primary flex items-center">
                            <input type="checkbox" name="include_agglomeration" value="1"
                                class="mr-2 appearance-none checked:bg-accent focus:ring-accent">
                            Agglomeráció találatait is mutassa
                        </label>
                    </div>

                    <div
                        class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl border border-white/10">
                        <!-- Keresőmezők -->
                        <h3 class="text-lg mb-4">Keresési feltételek</h3>
                        <select name="district_dropdown" id="districtDropdown"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2">
                            <option value="" disabled selected>Válasszon kerületet!</option>
                            <option value="I. kerület">I. kerület</option>
                            <option value="II. kerület">II. kerület</option>
                            <option value="III. kerület">III. kerület</option>
                            <option value="IV. kerület">IV. kerület</option>
                            <option value="V. kerület">V. kerület</option>
                            <option value="VI. kerület">VI. kerület</option>
                            <option value="VII. kerület">VII. kerület</option>
                            <option value="VIII. kerület">VIII. kerület</option>
                            <option value="IX. kerület">IX. kerület</option>
                            <option value="X. kerület">X. kerület</option>
                            <option value="XI. kerület">XI. kerület</option>
                            <option value="XII. kerület">XII. kerület</option>
                            <option value="XIII. kerület">XIII. kerület</option>
                            <option value="XIV. kerület">XIV. kerület</option>
                            <option value="XV. kerület">XV. kerület</option>
                            <option value="XVI. kerület">XVI. kerület</option>
                            <option value="XVII. kerület">XVII. kerület</option>
                            <option value="XVIII. kerület">XVIII. kerület</option>
                            <option value="XIX. kerület">XIX. kerület</option>
                            <option value="XX. kerület">XX. kerület</option>
                            <option value="XXI. kerület">XXI. kerület</option>
                            <option value="XXII. kerület">XXII. kerület</option>
                            <option value="XXIII. kerület">XXIII. kerület</option>
                        </select>

                        <select name="office_name" class="w-full border border-gray-300 rounded-xl px-4 py-2">
                            <option value="" disabled selected>Irodaház neve</option>
                            <option value="Árpád Center">Árpád Center</option>
                            <option value="RiverPark">RiverPark</option>
                            <option value="WestEnd">WestEnd</option>
                            <option value="Millennium Center">Millennium Center</option>
                            <option value="Bank Center">Bank Center</option>
                            <!-- További irodaházak... -->
                        </select>

                        <input type="text" name="search" placeholder="Keresett kifejezés"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2" value="{{ request('search') }}">
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
                            <button type="submit"
                                class="w-full bg-primary/70 text-white font-semibold px-8 py-2 rounded hover:bg-accent/80 transition">
                                KERESÉS
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <script>
            document.addEventListener('livewire:initialized', function() {
                // Initialize the range sliders
                $('.terulet-slider').ionRangeSlider({
                    type: "double",
                    min: 0,
                    max: 3000,
                    from: 0,
                    to: 3000,
                    grid: true,
                    skin: "round",
                    postfix: "&nbsp;m²",
                    onFinish: function(data) {
                        document.getElementById('areaMin').value = data.from;
                        document.getElementById('areaMax').value = data.to;
                    }
                });

                $('.ar-slider').ionRangeSlider({
                    type: "double",
                    min: 1,
                    max: 60,
                    from: 1,
                    to: 60,
                    grid: true,
                    skin: "round",
                    postfix: "&nbsp;€/m²",
                    onFinish: function(data) {
                        document.getElementById('priceMin').value = data.from;
                        document.getElementById('priceMax').value = data.to;
                    }
                });

                // Handle district dropdown changes
                document.getElementById('districtDropdown').addEventListener('change', function() {
                    const selectedDistrict = this.value;
                    document.getElementById('selectedDistrict').value = selectedDistrict;

                    if (selectedDistrict) {
                        document.getElementById('selectedDistrictDisplay').classList.remove('hidden');
                        document.getElementById('districtName').textContent = selectedDistrict;
                    } else {
                        document.getElementById('selectedDistrictDisplay').classList.add('hidden');
                    }
                });
            });

            // Function to handle map district selection
            function selectDistrict(districtName, event) {
                // Prevent default behavior and stop event propagation
                if (event) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                // Update hidden input
                document.getElementById('selectedDistrict').value = districtName;

                // Update dropdown
                document.getElementById('districtDropdown').value = districtName;

                // Show selected district
                document.getElementById('selectedDistrictDisplay').classList.remove('hidden');
                document.getElementById('districtName').textContent = districtName;

                // Add visual feedback to map (optional)
                // You could add a class to highlight the selected district

                return false; // Prevent default link behavior
            }

            // Auto-submit form when ranges change (optional)
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('filterForm');

                // Auto-submit on dropdown changes (optional)
                const selects = form.querySelectorAll('select');
                selects.forEach(select => {
                    select.addEventListener('change', function() {
                        // Uncomment the line below for auto-submit
                        // form.submit();
                    });
                });
            });
        </script>
    </div>
</div>
