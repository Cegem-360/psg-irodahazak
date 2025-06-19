<div>

    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-4 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('page.title.offices_for_rent') }}
            </h2>
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
