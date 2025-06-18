<x-layouts.app>
    <x-slot name="title">{{ $property->title }} - {{ config('app.name') }}</x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Navigation back -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <a href="{{ route('properties.index') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Vissza az ingatlanokhoz
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Image Gallery -->
                <div class="lg:col-span-2">
                    @if ($property->images->count() > 0)
                        <x-cards.ingatlan-gallery-carousel :images="$property->getImageUrls('800x600')" :title="$property->title" />
                    @else
                        <div class="aspect-[4/3] bg-gray-100 rounded-xl flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p class="text-gray-500">Nincs elérhető kép</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Property Details -->
                <div class="space-y-6">
                    <!-- Title and Status -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $property->title }}</h1>
                            @if ($property->status)
                                <span
                                    class="px-3 py-1 text-sm rounded-full {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $property->status === 'active' ? 'Aktív' : 'Inaktív' }}
                                </span>
                            @endif
                        </div>

                        @if ($property->lead)
                            <p class="text-gray-600 mb-4">{{ $property->lead }}</p>
                        @endif
                    </div>

                    <!-- Property Information -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Részletek</h2>

                        <div class="space-y-3">
                            @if ($property->total_area)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Összes terület:</span>
                                    <span class="font-medium">{{ number_format($property->total_area, 0, ',', ' ') }}
                                        {{ $property->osszterulet_addons ?? 'm²' }}</span>
                                </div>
                            @endif

                            @if ($property->jelenleg_kiado)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jelenleg kiadó:</span>
                                    <span
                                        class="font-medium">{{ number_format($property->jelenleg_kiado, 0, ',', ' ') }}
                                        {{ $property->jelenleg_kiado_addons ?? 'm²' }}</span>
                                </div>
                            @endif

                            @if ($property->max_berleti_dij)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Bérleti díj:</span>
                                    <span class="font-medium text-blue-600">{{ $property->max_berleti_dij }}
                                        {{ $property->max_berleti_dij_addons ?? 'EUR/m²/hó' }}</span>
                                </div>
                            @endif

                            @if ($property->uzemeletetesi_dij)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Üzemeltetési díj:</span>
                                    <span
                                        class="font-medium">{{ number_format($property->uzemeletetesi_dij, 0, ',', ' ') }}
                                        {{ $property->uzemeletetesi_dij_addons ?? 'HUF/m²/hó' }}</span>
                                </div>
                            @endif

                            @if ($property->cim_irsz && $property->cim_varos)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Helyszín:</span>
                                    <span class="font-medium">{{ $property->cim_irsz }} {{ $property->cim_varos }},
                                        {{ $property->cim_utca }} {{ $property->cim_hazszam }}</span>
                                </div>
                            @endif

                            @if ($property->construction_year)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Építési év:</span>
                                    <span class="font-medium">{{ $property->construction_year }}</span>
                                </div>
                            @endif

                            @if ($property->images->count() > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Képek száma:</span>
                                    <span class="font-medium">{{ $property->images->count() }} kép</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if ($property->parkolas || $property->raktar_terulet || $property->min_berleti_idoszak)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">További információk</h2>

                            <div class="space-y-3">
                                @if ($property->parkolas)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Parkolás:</span>
                                        <span class="font-medium">{{ $property->parkolas }}</span>
                                    </div>
                                @endif

                                @if ($property->min_parkolas_dija)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Parkolási díj:</span>
                                        <span class="font-medium">{{ $property->min_parkolas_dija }}
                                            {{ $property->min_parkolas_dija_addons ?? 'EUR/hely/hó' }}</span>
                                    </div>
                                @endif

                                @if ($property->raktar_terulet)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Raktár terület:</span>
                                        <span class="font-medium">{{ $property->raktar_terulet }}
                                            {{ $property->raktar_terulet_addons ?? 'm²' }}</span>
                                    </div>
                                @endif

                                @if ($property->raktar_berleti_dij)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Raktár bérleti díj:</span>
                                        <span class="font-medium">{{ $property->raktar_berleti_dij }}
                                            {{ $property->raktar_berleti_dij_addons ?? 'EUR/m²/hó' }}</span>
                                    </div>
                                @endif

                                @if ($property->min_berleti_idoszak)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Min. bérleti időszak:</span>
                                        <span class="font-medium">{{ $property->min_berleti_idoszak }}
                                            {{ $property->min_berleti_idoszak_addons ?? 'év' }}</span>
                                    </div>
                                @endif

                                @if ($property->kozos_teruleti_arany)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Közös területi arány:</span>
                                        <span
                                            class="font-medium">{{ $property->kozos_teruleti_arany }}{{ $property->kozos_teruleti_arany_addons ?? '%' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Services -->
                    @if ($property->services && count($property->services) > 0)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Szolgáltatások</h2>
                            <div class="space-y-2">
                                @foreach ($property->services as $service)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $service }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Tags -->
                    @if ($property->tags && count($property->tags) > 0)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Címkék</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($property->tags as $tag)
                                    <span
                                        class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Contact -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Kapcsolat</h2>
                        <a href="{{ route('kapcsolat') }}"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg transition-colors">
                            Érdeklődés
                        </a>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if ($property->content)
                <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">Leírás</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! $property->content !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
