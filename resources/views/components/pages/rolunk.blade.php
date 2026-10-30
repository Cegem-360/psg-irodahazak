<div>
    @php
        $language = app()->getLocale() ?? 'hu';
        $aboutUses = \App\Models\AboutUs::active()->byLanguage($language)->get();
    @endphp

    <x-page-section>
        <x-slot:heading>{{ __('About Us') }}</x-slot:heading>

        <x-glass-panel>
            <div class="p-6">
                @foreach ($aboutUses as $item)
                    <p class="mb-3 text-gray-600">
                        {!! $item->content !!}<br />
                    </p>
                @endforeach

            </div>
            <img src="{{ Vite::asset('resources/images/psg_montazs.webp') }}"
                class="w-full h-auto mt-6 rounded-lg shadow-lg"
                alt="{{ $aboutUses->first()?->title ?? __('About Us') }}" loading="lazy">
        </x-glass-panel>
    </x-page-section>

</div>
