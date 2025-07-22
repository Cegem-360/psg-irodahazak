<div>

    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-4 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('page.title.office_buildings_for_sale') }}</h2>
            <h4 class="text-xl text-center mb-16">({{ $totalOffices }} {{ __('page.results') }})</h4>
            <div
                class="flex justify-end gap-8 max-w-screen-xl mx-auto px-8 py-3 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="">
                    <form action="#" class="">
                        <div>
                            <select id="szuro" wire:model.live="sortField"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <option value="title">{{ __('page.sort.by_name') }}</option>
                                <option value="date">{{ __('page.sort.by_date') }}</option>
                                <option value="ord">{{ __('page.sort.by_order') }}</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="relative">
                    <!-- Google Maps Container -->
                    <div wire:ignore id="map"
                        class="sticky top-8 h-[120vh] rounded-lg shadow-lg bg-gray-100 flex items-center justify-center">
                        <div class="text-center text-gray-500" id="map-placeholder">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p>{{ __('Térkép betöltése...') }}</p>
                        </div>
                    </div>

                    <!-- Map Error Display -->
                    <div id="map-error"
                        class="sticky top-8 h-[120vh] rounded-lg shadow-lg bg-red-50 border-2 border-red-200 items-center justify-center text-center p-8 hidden">
                        <div class="text-red-600">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                            <h3 class="text-lg font-semibold mb-2">{{ __('Térkép betöltési hiba') }}</h3>
                            <p id="map-error-message" class="text-sm"></p>
                        </div>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($offices ?? [] as $office)
                            <livewire:ingatlan-card :property="$office" :image="$office->getFirstImageUrl()" :title="$office->title"
                                :title="$office->title" :description="$office->getAddressFormatedForSale()" :link="localized_route('properties.show-for-sale', [
                                    'property' => $office->slug,
                                ])" :key="$office->id"
                                :small="true" />
                        @endforeach
                    </div>
                </div>
            </div>

            <div
                class="flex justify-center gap-8 max-w-screen-xl mx-auto px-8 py-3 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                {{-- Pagination --}}
                {{ $this->getOffices()->links() }}
            </div>
        </div>
    </div>

</div>
@script
    <script>
        // Import the sale offices map handler (creates global instance automatically)
        import('{{ Vite::asset('resources/js/sale-offices-map.js') }}').then(module => {
            const apiKey = @js(config('services.google_maps.api_key'));
            const mapId = @js(config('services.google_maps.map_id'));
            let officesData = @json($this->getOfficesForMap());

            // Check if API key is available
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
                if (window.saleOfficesMapHandler) {
                    window.saleOfficesMapHandler.initialize(apiKey, officesData, mapId);
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
                        if (window.saleOfficesMapHandler && !isUpdating) {
                            isUpdating = true;

                            // Get fresh office data without triggering another morph
                            $wire.$call('getOfficesForMap').then((freshOfficesData) => {
                                window.saleOfficesMapHandler.refreshMarkers(
                                    freshOfficesData);
                            }).catch((error) => {
                                console.error('Failed to fetch fresh office data:',
                                    error);
                                // Fallback to current visible data (no server call)
                                const currentData = @json($this->getOfficesForMap());
                                window.saleOfficesMapHandler.refreshMarkers(
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
