<x-slot name="title">{{ __('About Us | PSG Irodaházak') }}</x-slot>
<x-slot name="metaDescription">{{ __('Since 2014, Property Solution Group Kft. has been helping companies as tenants on the Budapest office market: independent tenant representation, office search and negotiation free of charge.') }}</x-slot>

<div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
    <x-page-section>
        <x-slot:heading>{{ __('About Us') }}</x-slot:heading>

        <x-glass-panel>
            <div class="p-6">
                @foreach ($aboutUs as $item)
                    <p class="mb-3 text-gray-600">
                        {!! $item->content !!}<br />
                    </p>
                @endforeach

            </div>
            <img src="{{ Vite::asset('resources/images/psg_montazs.webp') }}"
                class="w-full h-auto mt-6 rounded-lg shadow-lg"
                alt="{{ $aboutUs->first()?->title ?? __('About Us') }}" loading="lazy">
        </x-glass-panel>
    </x-page-section>

</div>
