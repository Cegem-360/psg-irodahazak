@use('App\Enums\BudapestDistrict')
@use('App\Models\Property')
<div>
    <div class="relative">
        <h2 class="text-4xl text-center mt-24 mb-8">
            {{ __('filter.title.first') }}
            <span class="text-primary">
                {{ __('new ideal') }}
            </span>
            {{ __('filter.title.second') }}
        </h2>
        <div class="absolute -right-8 -top-10 z-10 w-1/3 text-accent/40 blur-3xl"><x-svg.psg-irodahazak-symbol-1 />
        </div>
        <div class="absolute -left-8 -top-16 z-10 w-1/3 text-accent/30 blur-3xl"><x-svg.psg-irodahazak-symbol-2 />
        </div>
        <div class="absolute left-[50%] translate-x-[-50%] -bottom-40 z-10 w-96 text-accent/30 blur-3xl">
            <x-svg.psg-irodahazak-symbol-3 />
        </div>
    </div>
    <div class="relative bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ Vite::asset('resources/images/office-building-2025-03-18-12-43-13-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-linear-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto pt-12 pb-20">
            <form id="filterForm" method="GET" action="{{ localized_route('kiado-irodak') }}" class="search-form">
                <!-- Hidden inputs for map selection and parameters -->
                <input type="hidden" name="type" value="rent">
                <input type="hidden" name="districts" id="selectedDistricts" value="">
                <input type="hidden" name="area_min" id="areaMin" value="">
                <input type="hidden" name="area_max" id="areaMax" value="">
                <input type="hidden" name="price_min" id="priceMin" value="">
                <input type="hidden" name="price_max" id="priceMax" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
                    <div
                        class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl border border-white/15">
                        <!-- Térkép -->
                        <h3 class="text-lg mb-4">{{ __('Map Search') }}</h3>
                        <div class="map-container">
                            {{-- Térkép --}}
                            <x-svg.bp-map class="h-96" :districts_properties_count="Property::countByDistrict()" />
                            <div id="selectedDistrictsDisplay" class="mt-2 text-sm text-primary font-semibold hidden">
                                {{ __('Selected Districts') }}: <span id="districtsNames"></span>
                                <button type="button" id="clearSelections"
                                    class="ml-2 text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                    {{ __('Clear All') }}
                                </button>
                            </div>
                        </div>
                        <label class="text-sm text-primary flex items-center">
                            <input type="checkbox" name="include_agglomeration" value="1"
                                class="mr-2 appearance-none checked:bg-accent focus:ring-accent"
                                @checked(request()->boolean('include_agglomeration'))>
                            {{ __('Show agglomeration results only') }}
                        </label>
                    </div>

                    <div
                        class="relative z-10 p-8 space-y-8 bg-black/5 rounded-xl _overflow-hidden_ shadow-xl backdrop-blur-3xl border border-white/15">
                        <!-- Keresőmezők -->
                        <h3 class="text-lg mb-4">{{ __('Search Criteria') }}</h3>
                        <!-- Custom Multi-Select Dropdown -->
                        <div class="relative">
                            <button type="button" id="dropdownButton"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-white text-left focus:ring-2 focus:ring-accent focus:border-accent flex justify-between items-center">
                                <span id="dropdownText">{{ __('Select Districts') }}</span>
                                <svg class="w-5 h-5 transition-transform duration-200" id="dropdownArrow" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="dropdownMenu"
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-xl shadow-lg max-h-48 overflow-y-auto hidden">
                                <div class="p-2">
                                    @foreach (BudapestDistrict::cases() as $budapestDistrict)
                                        <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                            <input type="checkbox" value="{{ $budapestDistrict->value }}" class="district-checkbox mr-2">
                                            <span>{{ __('District :number', ['number' => $budapestDistrict->roman()]) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Office Name Search Dropdown -->
                        <div class="relative">
                            <button type="button" id="officeDropdownButton"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-white text-left focus:ring-2 focus:ring-accent focus:border-accent flex justify-between items-center">
                                <span id="officeDropdownText">{{ __('Office Building Name') }}</span>
                                <svg class="w-5 h-5 transition-transform duration-200" id="officeDropdownArrow"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="office_name" id="selectedOfficeName"
                                value="{{ request('office_name') }}">

                            <!-- Dropdown Menu -->
                            <div id="officeDropdownMenu"
                                class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-xl shadow-lg max-h-64 overflow-hidden hidden">
                                <!-- Search input inside dropdown -->
                                <div class="p-3 border-b border-gray-200">
                                    <input type="text" id="officeSearchInput"
                                        placeholder="{{ __('Search among office buildings...') }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-accent focus:border-accent text-sm">
                                </div>

                                <!-- Results container -->
                                <div class="max-h-48 overflow-y-auto">
                                    <div id="officeResults" class="p-2">
                                        <!-- Static default options (will be replaced with dynamic content) -->
                                        <div class="office-option" data-value="">
                                            <div class="text-gray-500 italic">{{ __('All Office Buildings') }}</div>
                                        </div>
                                    </div>

                                    <div id="officeLoading" class="p-4 text-center text-gray-500 hidden">
                                        <div class="flex items-center justify-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            {{ __('Searching...') }}
                                        </div>
                                    </div>

                                    <div id="officeEmpty" class="p-4 text-center text-gray-500 hidden">
                                        {{ __('No results') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="text" name="search" placeholder="{{ __('Search term') }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2"
                            value="{{ request('search') }}">
                        @auth

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold">{{ __('Min Rent') }}</label>
                                    <select name="min_rent"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-white focus:ring-2 focus:ring-accent focus:border-accent">
                                        <option value="">{{ __('Select') }}</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-sm font-semibold">{{ __('Min Rent Addons') }}</label>
                                    <select name="min_rent_addons"
                                        class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-white focus:ring-2 focus:ring-accent focus:border-accent">
                                        <option value="">{{ __('Select') }}</option>
                                        <option value="év">{{ __('year') }}</option>
                                        <option value="hónap">{{ __('month') }}</option>
                                    </select>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <div
                        class="p-8 space-y-8 bg-black/5 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl border border-white/15">
                        <!-- Range szűrők -->
                        <h3 class="text-lg mb-4">{{ __('Filter by Parameters') }}</h3>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold">{{ __('Floor Area') }} (m2)</label>
                            <input type="text" class="terulet-slider" name="terulet_range" value="" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold">{{ __('Rental Fee') }} (€/m2)</label>
                            <input type="text" class="ar-slider" name="ar_range" value="" />
                        </div>

                        <!-- Keresés gomb -->
                        <div>
                            <button type="submit"
                                class="w-full bg-primary/70 text-white font-semibold px-8 py-2 rounded hover:bg-accent/80 transition">
                                {{ __('SEARCH') }}
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <style>
            /* Custom dropdown styling */
            .district-checkbox {
                accent-color: #16a34a;
            }

            .district-checkbox:checked+span {
                color: #16a34a;
                font-weight: 600;
            }

            #dropdownMenu,
            #officeDropdownMenu {
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            #dropdownMenu label:hover,
            .office-option:hover {
                background-color: rgba(111, 114, 185, 0.05);
            }

            .office-option {
                transition: background-color 0.2s ease;
            }

            .office-option:hover {
                background-color: rgba(111, 114, 185, 0.05) !important;
            }

            /* Map district highlighting */
            .selected-district .kerulet {
                fill: rgba(111, 114, 185, 0.6) !important;
                stroke: #6f72b9 !important;
                stroke-width: 2px !important;
            }

            .selected-district {
                z-index: 10;
            }
        </style>
        @php
            $szuroConfig = [
                'offices' => Property::rent()->active()->orderBy('title')->get(['title', 'cim_irsz'])
                    ->map(fn (Property $office): array => ['title' => $office->title, 'city' => $office->cim_irsz ?? 'Budapest'])
                    ->values(),
                'i18n' => [
                    'selectDistricts' => __('Select Districts'),
                    'districtsSelected' => __(':count districts selected'),
                    'allOfficeBuildings' => __('All Office Buildings'),
                    'officeBuildingName' => __('modal.office_building_name'),
                ],
            ];
        @endphp
        {{-- Read by resources/js/office-search-form.js --}}
        <script type="application/json" id="office-search-form-config">@json($szuroConfig)</script>
    </div>
</div>
