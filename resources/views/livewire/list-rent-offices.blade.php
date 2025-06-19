<div>

    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-4 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('page.title.offices_for_rent') }}
            </h2>
            <h4 class="text-xl text-center mb-8">({{ $totalOffices }} {{ __('page.results') }})</h4>

            <!-- Search and Filter Controls -->
            <div class="max-w-screen-xl mx-auto mb-8 p-6 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keresés</label>
                        <input type="text" wire:model.live="search" placeholder="Keresett kifejezés..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kerület</label>
                        <select wire:model.live="district" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">Összes kerület</option>
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
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Irodaház</label>
                        <input type="text" wire:model.live="officeName" placeholder="Irodaház neve..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rendezés</label>
                        <select wire:model.live="sortField" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="title">{{ __('page.sort.by_name') }}</option>
                            <option value="date">{{ __('page.sort.by_date') }}</option>
                            <option value="ord">{{ __('page.sort.by_order') }}</option>
                        </select>
                    </div>
                </div>

                @if ($search || $district || $officeName)
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="text-sm text-gray-600">Aktív szűrők:</span>
                        @if ($search)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                Keresés: {{ $search }}
                                <button wire:click="$set('search', '')"
                                    class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                            </span>
                        @endif
                        @if ($district)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                {{ $district }}
                                <button wire:click="$set('district', '')"
                                    class="ml-1 text-green-600 hover:text-green-800">×</button>
                            </span>
                        @endif
                        @if ($officeName)
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                                Irodaház: {{ $officeName }}
                                <button wire:click="$set('officeName', '')"
                                    class="ml-1 text-purple-600 hover:text-purple-800">×</button>
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <div
                class="flex justify-end gap-8 max-w-screen-xl mx-auto px-8 py-3 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="text-sm text-gray-600">
                    Találatok száma oldalanként: {{ $perPage }}
                </div>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <div class="relative">
                    <iframe class="sticky top-8 h-[120vh]"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2695.3752330104103!2d19.04358067667799!3d47.502083195188725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741dc15d6bf2925%3A0xd7e6926bead52fbc!2sAcademia%20Offices%20%2F%20Irodah%C3%A1z!5e0!3m2!1shu!2shu!4v1749023556934!5m2!1shu!2shu"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                                '<br><strong>Bérleti díj:</strong> ' .
                                $office->min_berleti_dij .
                                ' - ' .
                                $office->max_berleti_dij .
                                '<br><strong>Üzemeltetési díj: </strong>' .
                                $office->uzemeletetesi_dij" :link="route('properties.show', $office)" />
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

</div>
