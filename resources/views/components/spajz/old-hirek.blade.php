    <!-- News section -->
    <div class="bg-[#F3F3F3]">
        <div class="max-w-7xl mx-auto px-4 py-8 space-y-4">
            <div class="mb-6">
                <span class="bg-secondary text-white text-2xl font-bold py-1 px-3 rounded">{{ __('NEWS') }}</span>
            </div>

            <!-- News post -->
            <div class="grid md:grid-cols-2 gap-4 border-t border-gray-200 p-8 bg-white">
                <div class="">
                    <img src="{{ Vite::asset('resources/images/bakerstreet_irodahaz_1__800x600.jpg') }}" alt="{{ __('Blog image') }}"
                        class="-my-8 w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <h2 class="text-3xl font-semibold text-gray-800">
                        {{ __('The office building in the heart of Újbuda has been sold') }}
                    </h2>
                    <p class="text-md italic text-primary mt-2">2025.05.15</p>
                    <p class="text-gray-700 mt-4 text-lg">
                        {{ __('Atenor has successfully sold its fully leased office and retail development, the BakerStreet I office building in Újbuda, the company announced.') }}
                    </p>
                    <a href="#"
                        class="bg-primary self-end text-white mt-8 px-4 py-2 text-lg font-semibold hover:bg-primary transition">{{ __('Details') }}</a>
                </div>
            </div>

            <!-- News post -->
            <div class="grid md:grid-cols-2 gap-4 border-t border-gray-200 p-8 bg-white">
                <div class="">
                    <img src="{{ Vite::asset('resources/images/home_office_800x600.png') }}" alt="{{ __('Conclave image') }}"
                        class="-my-8 w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <h2 class="text-3xl font-semibold text-gray-800">
                        {{ __('Survey: Has the home office rate peaked in Hungary?') }}
                    </h2>
                    <p class="text-md italic text-primary mt-2">2025.04.30</p>
                    <p class="text-gray-700 mt-4 text-lg">
                        {{ __('The share of time that can be spent working from home within total working hours is approaching its peak – according to a survey conducted among decision-makers of tenants in office buildings managed by ICON. Three out of four tenants do not plan to further increase the number of home office days over the next 1-2 years. International trends already show a decline in hybrid working.') }}
                    </p>
                    <a href="#"
                        class="bg-primary self-end text-white mt-8 px-4 py-2 text-lg font-semibold hover:bg-primary transition">{{ __('Details') }}</a>
                </div>
            </div>

            <!-- News post -->
            <div class="grid md:grid-cols-2 gap-4 border-t border-b border-gray-200 p-8 bg-white">
                <div class="">
                    <img src="{{ Vite::asset('resources/images/hirek_office_800x600.jpg') }}" alt="{{ __('12 points image') }}"
                        class="-my-8 w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <h2 class="text-3xl font-semibold text-gray-800">
                        {{ __('Was last year the low point of the office market?') }}
                    </h2>
                    <p class="text-md italic text-primary mt-2">2025.03.15</p>
                    <p class="text-gray-700 mt-4 text-lg">
                        {{ __('The European office market showed a significant decline in 2024, resulting in the lowest transaction volume in recent years. Investor caution is primarily driven by the spread of remote work and the high costs of upgrading buildings for sustainability. According to MSCI data, the share of office buildings in the European commercial real estate market has fallen to a record low of 22%, Bloomberg reported.') }}
                    </p>
                    <a href="#"
                        class="bg-primary self-end text-white mt-8 px-4 py-2 text-lg font-semibold hover:bg-primary transition">{{ __('Details') }}</a>
                </div>
            </div>
        </div>
    </div>
