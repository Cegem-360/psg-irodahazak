<div>

    <div class="relative">

        <div class="kategoria-valaszto grid grid-cols-1 md:grid-cols-4 font-bold">
            <a wire:navigate.hover href="{{ localized_route('budapest.category', ['category' => 'kiado-belvarosi-irodak']) }}"
                class="hero-image relative group">
                <img src="{{ Vite::asset('resources/images/belvarosi_kiado_irodak-2.webp') }}"
                    alt="{{ __('Downtown offices for rent') }}" class="w-full h-auto object-cover aspect-3/2" loading="lazy" />
                <div
                    class="flex items-center justify-center text-xl text-center text-white _bg-accentdark/90_ bg-primary backdrop-blur-xl h-18 group-hover:bg-accent {{-- group-hover:h-24 --}} duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                        {{ __('Offices for rent in downtown') }}</h2>
                </div>
            </a>
            <a wire:navigate.hover href="{{ localized_route('budapest.category', ['category' => 'kiado-budai-irodak']) }}"
                class="hero-image relative group">
                <img src="{{ Vite::asset('resources/images/budai_kiado_irodak.webp') }}" alt="{{ __('Buda offices for rent') }}"
                    class="w-full h-auto object-cover aspect-3/2" loading="lazy" />
                <div
                    class="flex items-center justify-center text-xl text-center text-white _bg-accentdark/90_ bg-logogray backdrop-blur-xl h-18 group-hover:bg-accent {{-- group-hover:h-24 --}} duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                        {{ __('Offices for rent in Buda') }}</h2>
                </div>
            </a>
            <a wire:navigate.hover href="{{ localized_route('budapest.category', ['category' => 'kiado-vaci-uti-irodak']) }}"
                class="hero-image relative group">
                <img src="{{ Vite::asset('resources/images/vaci-uti-irodak.webp') }}" alt="{{ __('Váci street offices for rent') }}"
                    class="w-full h-auto object-cover aspect-3/2" loading="lazy" />
                <div
                    class="flex items-center justify-center text-xl text-center text-white _bg-accentdark/90_ bg-primary backdrop-blur-xl h-18 group-hover:bg-accent {{-- group-hover:h-24 --}} duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                        {{ __('Offices for rent on Váci street') }}</h2>
                </div>
            </a>
            <a wire:navigate.hover href="{{ localized_route('budapest.category', ['category' => 'kiado-azonnali-szolgaltatott-irodak']) }}"
                class="hero-image relative group">
                <img src="{{ Vite::asset('resources/images/azonnali_szolgaltatott_irodak-2.webp') }}"
                    alt="{{ __('Instant serviced offices') }}" class="w-full h-auto object-cover aspect-3/2"
                    loading="lazy" />
                <div
                    class="flex items-center justify-center text-xl text-center text-white _bg-accentdark/90_ bg-logogray backdrop-blur-xl h-18 group-hover:bg-accent {{-- group-hover:h-24 --}} duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                        {{ __('Serviced offices') }}</h2>
                </div>
            </a>
        </div>

    </div>
    <x-home.stats />

    <x-office-search-form />

    <x-home.featured-offers />

    <x-home.testimonials />

    <x-home.references />

    @if (app()->getLocale() === 'hu')
        <x-home.blog />

        <x-home.news />
    @endif

</div>
