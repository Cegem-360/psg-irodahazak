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
                <input type="hidden" name="districts" id="selectedDistricts" value="">
                <input type="hidden" name="area_min" id="areaMin" value="">
                <input type="hidden" name="area_max" id="areaMax" value="">
                <input type="hidden" name="price_min" id="priceMin" value="">
                <input type="hidden" name="price_max" id="priceMax" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-screen-xl mx-auto">
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
                                {{ request('include_agglomeration') ? 'checked' : '' }}>
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
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="1" class="district-checkbox mr-2">
                                        <span>I. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="2" class="district-checkbox mr-2">
                                        <span>II. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="3" class="district-checkbox mr-2">
                                        <span>III. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="4" class="district-checkbox mr-2">
                                        <span>IV. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="5" class="district-checkbox mr-2">
                                        <span>V. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="6" class="district-checkbox mr-2">
                                        <span>VI. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="7" class="district-checkbox mr-2">
                                        <span>VII. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="8" class="district-checkbox mr-2">
                                        <span>VIII. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="9" class="district-checkbox mr-2">
                                        <span>IX. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="10" class="district-checkbox mr-2">
                                        <span>X. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="11" class="district-checkbox mr-2">
                                        <span>XI. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="12" class="district-checkbox mr-2">
                                        <span>XII. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="13" class="district-checkbox mr-2">
                                        <span>XIII. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="14" class="district-checkbox mr-2">
                                        <span>XIV. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="15" class="district-checkbox mr-2">
                                        <span>XV. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="16" class="district-checkbox mr-2">
                                        <span>XVI. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="17" class="district-checkbox mr-2">
                                        <span>XVII. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="18" class="district-checkbox mr-2">
                                        <span>XVIII. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="19" class="district-checkbox mr-2">
                                        <span>XIX. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="20" class="district-checkbox mr-2">
                                        <span>XX. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="21" class="district-checkbox mr-2">
                                        <span>XXI. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="22" class="district-checkbox mr-2">
                                        <span>XXII. {{ __('district') }}</span>
                                    </label>
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" value="23" class="district-checkbox mr-2">
                                        <span>XXIII. {{ __('district') }}</span>
                                    </label>
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
                                            Keresés...
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
                                        <option value="nap">{{ __('day') }}</option>
                                        <option value="simán">{{ __('simply') }}</option>
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
                            <label class="text-sm font-semibold">{{ __('Floor Area') }} (m²)</label>
                            <input type="text" class="terulet-slider" name="terulet_range" value="" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold">{{ __('Rental Fee') }} (€/m²)</label>
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
        <script>
            let selectedDistricts = [];
            // Initialize the range sliders
            document.addEventListener("livewire:navigated", () => {
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
                    max: 30,
                    from: 1,
                    to: 30,
                    grid: true,
                    skin: "round",
                    postfix: "&nbsp;€/m²",
                    onFinish: function(data) {
                        document.getElementById('priceMin').value = data.from;
                        document.getElementById('priceMax').value = data.to;
                    }
                });
            });
            // Initialize selected districts from URL parameters


            document.addEventListener('livewire:livewire:navigated', function() {
                initializeSelectedDistricts();
            });

            // Global array to store selected districts


            // Make selectDistrict function globally accessible
            window.selectDistrict = selectDistrict;

            // Initialize selected districts from URL or form data
            function initializeSelectedDistricts() {
                const urlParams = new URLSearchParams(window.location.search);
                const districtsParam = urlParams.get('districts');

                if (districtsParam) {
                    selectedDistricts = districtsParam.split(',').filter(d => d.trim() !== '');
                    document.getElementById('selectedDistricts').value = selectedDistricts.join(',');

                    // Update dropdown selections
                    updateDropdownSelections();

                    // Update display
                    updateSelectedDistrictsDisplay();

                    // Update map highlights
                    updateMapHighlights();
                }
            }

            // Function to handle map district selection (multiple selection)
            function selectDistrict(districtName, event) {
                // Prevent default behavior and stop event propagation
                if (event) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                // Ensure districtName is a string for consistency
                const districtStr = String(districtName);

                // Toggle district selection
                const index = selectedDistricts.indexOf(districtStr);
                if (index > -1) {
                    // District already selected, remove it
                    selectedDistricts.splice(index, 1);
                } else {
                    // District not selected, add it
                    selectedDistricts.push(districtStr);
                }

                // Update hidden input with comma-separated values
                document.getElementById('selectedDistricts').value = selectedDistricts.join(',');

                // Update dropdown selections
                updateDropdownSelections();

                // Update display
                updateSelectedDistrictsDisplay();

                // Update map highlights to ensure sync
                updateMapHighlights();

                return false; // Prevent default link behavior
            }

            // Function to update dropdown selections
            function updateDropdownSelections() {
                const checkboxes = document.querySelectorAll('.district-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectedDistricts.includes(checkbox.value);
                });
                updateDropdownText();
            }

            // Function to update dropdown button text
            function updateDropdownText() {
                const dropdownText = document.getElementById('dropdownText');
                if (selectedDistricts.length === 0) {
                    dropdownText.textContent = "{{ __('Select Districts') }}";
                } else if (selectedDistricts.length === 1) {
                    dropdownText.textContent = selectedDistricts[0];
                } else {
                    dropdownText.textContent = `${selectedDistricts.length} {{ __('district selected') }}`;
                }
            }

            // Function to update the display of selected districts
            function updateSelectedDistrictsDisplay() {
                const display = document.getElementById('selectedDistrictsDisplay');
                const namesSpan = document.getElementById('districtsNames');

                if (selectedDistricts.length > 0) {
                    display.classList.remove('hidden');
                    namesSpan.textContent = selectedDistricts.join(', ');
                } else {
                    display.classList.add('hidden');
                }
            }

            // Handle dropdown changes
            document.addEventListener('livewire:initialized', function() {
                const dropdownButton = document.getElementById('dropdownButton');
                const dropdownMenu = document.getElementById('dropdownMenu');
                const dropdownArrow = document.getElementById('dropdownArrow');
                const checkboxes = document.querySelectorAll('.district-checkbox');

                // Toggle dropdown visibility
                dropdownButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isHidden = dropdownMenu.classList.contains('hidden');

                    if (isHidden) {
                        dropdownMenu.classList.remove('hidden');
                        dropdownArrow.style.transform = 'rotate(180deg)';
                    } else {
                        dropdownMenu.classList.add('hidden');
                        dropdownArrow.style.transform = 'rotate(0deg)';
                    }
                });

                // Handle checkbox changes
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            if (!selectedDistricts.includes(this.value)) {
                                selectedDistricts.push(this.value);
                            }
                        } else {
                            const index = selectedDistricts.indexOf(this.value);
                            if (index > -1) {
                                selectedDistricts.splice(index, 1);
                            }
                        }

                        // Update hidden input
                        document.getElementById('selectedDistricts').value = selectedDistricts.join(
                            ',');

                        // Update dropdown text
                        updateDropdownText();

                        // Update visual highlights on map
                        updateMapHighlights();

                        // Update display
                        updateSelectedDistrictsDisplay();
                    });
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.add('hidden');
                        dropdownArrow.style.transform = 'rotate(0deg)';
                    }
                });

                // Clear all selections button
                document.getElementById('clearSelections').addEventListener('click', function() {
                    selectedDistricts = [];
                    document.getElementById('selectedDistricts').value = '';
                    updateDropdownSelections();
                    updateSelectedDistrictsDisplay();
                    clearMapHighlights();
                });

                // Office Name Dropdown functionality
                const officeDropdownButton = document.getElementById('officeDropdownButton');
                const officeDropdownMenu = document.getElementById('officeDropdownMenu');
                const officeDropdownArrow = document.getElementById('officeDropdownArrow');
                const officeSearchInput = document.getElementById('officeSearchInput');
                const officeResults = document.getElementById('officeResults');
                const officeLoading = document.getElementById('officeLoading');
                const officeEmpty = document.getElementById('officeEmpty');

                let officeSearchTimeout;

                // Initialize dropdown text based on current value
                const currentOfficeValue = document.getElementById('selectedOfficeName').value;
                if (currentOfficeValue) {
                    document.getElementById('officeDropdownText').textContent = currentOfficeValue;
                }

                // Toggle office dropdown
                officeDropdownButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isHidden = officeDropdownMenu.classList.contains('hidden');

                    if (isHidden) {
                        officeDropdownMenu.classList.remove('hidden');
                        officeDropdownArrow.style.transform = 'rotate(180deg)';
                        officeSearchInput.focus();
                        // Load initial results
                        loadOfficeNames('');
                    } else {
                        officeDropdownMenu.classList.add('hidden');
                        officeDropdownArrow.style.transform = 'rotate(0deg)';
                    }
                });

                // Search functionality
                officeSearchInput.addEventListener('input', function() {
                    const searchTerm = this.value.trim();

                    clearTimeout(officeSearchTimeout);

                    officeSearchTimeout = setTimeout(() => {
                        loadOfficeNames(searchTerm);
                    }, 300);
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!officeDropdownButton.contains(e.target) && !officeDropdownMenu.contains(e.target)) {
                        officeDropdownMenu.classList.add('hidden');
                        officeDropdownArrow.style.transform = 'rotate(0deg)';
                    }
                });
            });

            // Function to load office names
            function loadOfficeNames(searchTerm) {
                const officeLoading = document.getElementById('officeLoading');
                const officeEmpty = document.getElementById('officeEmpty');
                const officeResults = document.getElementById('officeResults');

                // Show loading
                officeLoading.classList.remove('hidden');
                officeEmpty.classList.add('hidden');

                // Static office names for now (later can be replaced with AJAX call)
                const offices = [

                    @foreach (Property::rent()->active()->orderBy('title')->get() as $office)
                        {
                            title: '{{ addslashes($office->title) }}',
                            city: '{{ addslashes($office->cim_irsz ?? 'Budapest') }}'
                        }
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                ];

                // Filter offices based on search term
                const filteredOffices = offices.filter(office =>
                    office.title.toLowerCase().includes(searchTerm.toLowerCase())
                );

                setTimeout(() => {
                    officeLoading.classList.add('hidden');

                    if (filteredOffices.length === 0 && searchTerm) {
                        officeEmpty.classList.remove('hidden');
                        officeResults.innerHTML =
                            '<div class="px-3 py-2 hover:bg-gray-50 rounded cursor-pointer office-option" data-value=""><div class="text-gray-500 italic">Összes irodaház</div></div>';
                    } else {
                        officeEmpty.classList.add('hidden');

                        // Build results HTML
                        let resultsHTML =
                            '<div class="px-3 py-2 hover:bg-gray-50 rounded cursor-pointer office-option" data-value=""><div class="text-gray-500 italic">{{ __('All Office Buildings') }}</div></div>';

                        filteredOffices.forEach(office => {
                            resultsHTML += `
                                <div class="px-3 py-2 hover:bg-gray-50 rounded cursor-pointer office-option" data-value="${office.title}">
                                    <div class="font-medium">${office.title}</div>
                                    <div class="text-sm text-gray-500">${office.city}</div>
                                </div>
                            `;
                        });

                        officeResults.innerHTML = resultsHTML;

                        // Add click listeners to options
                        document.querySelectorAll('.office-option').forEach(option => {
                            option.addEventListener('click', function() {
                                selectOffice(this.dataset.value);
                            });
                        });
                    }
                }, 200);
            }

            // Function to select an office
            function selectOffice(officeName) {
                const officeDropdownButton = document.getElementById('officeDropdownButton');
                const officeDropdownMenu = document.getElementById('officeDropdownMenu');
                const officeDropdownArrow = document.getElementById('officeDropdownArrow');
                const officeDropdownText = document.getElementById('officeDropdownText');
                const selectedOfficeName = document.getElementById('selectedOfficeName');

                // Update hidden input
                selectedOfficeName.value = officeName;

                // Update button text
                if (officeName) {
                    officeDropdownText.textContent = officeName;
                } else {
                    officeDropdownText.textContent = '{{ __('modal.office_building_name') }}';
                }

                // Close dropdown
                officeDropdownMenu.classList.add('hidden');
                officeDropdownArrow.style.transform = 'rotate(0deg)';
            }

            // Function to update map highlights based on selected districts
            function updateMapHighlights() {
                // Clear all highlights first
                clearMapHighlights();

                // Add highlights for selected districts
                selectedDistricts.forEach(district => {
                    // Find the specific district link by onclick attribute
                    const districtLink = document.querySelector(`svg a[onclick*="selectDistrict('${district}',"]`);
                    if (districtLink) {
                        districtLink.classList.add('selected-district');
                    }
                });
            }

            // Function to clear all map highlights
            function clearMapHighlights() {
                const allLinks = document.querySelectorAll('svg a.selected-district');
                allLinks.forEach(link => {
                    link.classList.remove('selected-district');
                });
            }

            // Auto-submit form when ranges change (optional)
            document.addEventListener('livewire:initialized', function() {
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
