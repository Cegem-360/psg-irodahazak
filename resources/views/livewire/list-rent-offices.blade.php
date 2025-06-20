<div>
    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-4 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('page.title.offices_for_rent') }}
            </h2>
            <h4 class="text-xl text-center mb-8">({{ $totalOffices }} {{ __('page.results') }})</h4>
            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="relative">
                    <div wire:ignore id="map" class="sticky top-8 h-[120vh] rounded-lg border border-gray-300"
                        style="width: 100%;"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($this->getOffices() ?? [] as $office)
                        <x-cards.ingatlan-card image="{{ $office->getFirstImageUrl('800x600') }}" small
                            :title="$office->title" :description="$office->cim_irsz .
                                ' ' .
                                $office->cim_varos .
                                ', ' .
                                $office->cim_utca .
                                ' ' .
                                $office->cim_hazszam .
                                '<br><strong>' .
                                __('Rent:') .
                                '</strong> ' .
                                $office->min_berleti_dij .
                                ' - ' .
                                $office->max_berleti_dij .
                                ' ' .
                                $office->max_berleti_dij_addons .
                                '<br><strong>' .
                                __('Operating Fee:') .
                                '</strong> ' .
                                $office->uzemeletetesi_dij .
                                ' ' .
                                $office->uzemeletetesi_dij_addons"
                            :link="route('properties.show', ['property' => $office])" />
                    @endforeach
                </div>
            </div>

            <div
                class="flex justify-center gap-8 max-w-screen-xl mx-auto px-8 py-3 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                {{-- Pagination --}}
                {{ $this->getOffices()->links() }}
            </div>
        </div>
    </div>

    @script
        <script>
            // Import the rent offices map handler (creates global instance automatically)
            import('{{ Vite::asset('resources/js/rent-offices-map.js') }}').then(module => {
                const apiKey = '{{ config('services.google_maps.api_key') }}';
                const mapId = '{{ config('services.google_maps.map_id') }}';
                let officesData = @json($this->getOfficesForMap());

                // Check if API key and map ID are available
                if (!apiKey || apiKey.trim() === '') {
                    console.warn('Google Maps API key is missing. Please set GOOGLE_MAPS_API_KEY in your .env file.');
                    const mapElement = document.getElementById('map');
                    if (mapElement) {
                        mapElement.innerHTML = `
                        <div class="flex items-center justify-center h-full bg-gray-100 rounded-lg">
                            <div class="text-center p-6">
                                <div class="mb-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 616 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Térkép nem elérhető</h3>
                                <p class="text-gray-500">Google Maps API kulcs szükséges a térkép megjelenítéséhez.</p>
                            </div>
                        </div>
                    `;
                    }
                    return;
                }

                if (!mapId || mapId.trim() === '') {
                    console.warn('Google Maps Map ID is missing. Please set GOOGLE_MAPS_MAP_ID in your .env file.');
                    const mapElement = document.getElementById('map');
                    if (mapElement) {
                        mapElement.innerHTML = `
                        <div class="flex items-center justify-center h-full bg-gray-100 rounded-lg">
                            <div class="text-center p-6">
                                <div class="mb-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 616 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Térkép nem elérhető</h3>
                                <p class="text-gray-500">Google Maps Map ID szükséges a térkép megjelenítéséhez.</p>
                            </div>
                        </div>
                    `;
                    }
                    return;
                }

                // Function to safely initialize map when DOM is ready
                function initializeMapSafely() {
                    const mapElement = document.getElementById('map');
                    if (!mapElement) {
                        console.warn('Map element not found, retrying...');
                        setTimeout(initializeMapSafely, 100);
                        return;
                    }

                    // Initialize map
                    if (window.rentOfficesMapHandler) {
                        window.rentOfficesMapHandler.initialize(apiKey, officesData, mapId);
                    }
                }

                // Start initialization
                initializeMapSafely();

                // Track if we're already updating to prevent infinite loops
                let isUpdating = false;

                // Listen for Livewire updates using $wire hooks
                $wire.$hook('commit', ({
                    succeed
                }) => {
                    succeed(() => {
                        // Prevent infinite loops
                        if (isUpdating) return;

                        setTimeout(() => {
                            if (window.rentOfficesMapHandler && !isUpdating) {
                                isUpdating = true;

                                // Get fresh office data without triggering another morph
                                $wire.$call('getOfficesForMap').then((freshOfficesData) => {
                                    window.rentOfficesMapHandler.refreshMarkers(
                                        freshOfficesData);
                                }).catch((error) => {
                                    console.error('Failed to fetch fresh office data:',
                                        error);
                                    // Fallback to current visible data (no server call)
                                    const currentData = @json($this->getOfficesForMap());
                                    window.rentOfficesMapHandler.refreshMarkers(
                                        currentData);
                                }).finally(() => {
                                    // Reset the flag after a short delay
                                    setTimeout(() => {
                                        isUpdating = false;
                                    }, 500);
                                });
                            }
                        }, 150);
                    });
                });

            }).catch(error => {
                console.error('Failed to load map module:', error);
            });
        </script>
    @endscript

</div>
