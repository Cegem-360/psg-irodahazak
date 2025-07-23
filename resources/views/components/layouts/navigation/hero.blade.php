<div class="hero overflow-hidden relative bg-white">
    <x-language-switcher />
    <div
        class="flex flex-col sm:flex-row justify-start items-center gap-8 sm:gap-16 lg:gap-32 mx-auto sm:pl-16 py-8 sm:py-16 max-w-screen-xl">
        <div class="absolute -left-56 -top-16 z-10 w-[40%] text-primary/15">
            <x-svg.psg-irodahazak-symbol />
        </div>
        <div class="logo pt-8 sm:pt-0">
            <a href="{{ localized_route('home') }}" class="flex items-center">
                <img src="{{ Vite::asset('resources/images/psg-irodahazak-logo.png') }}" class="mr-3 h-12 sm:h-24"
                    alt="PSG Irodaházak logo" loading="lazy">
            </a>
        </div>
        <div class="slogan flex items-end text-center text-2xl sm:text-3xl">
            <h2>{!! __('page.hero.slogan') !!}</h2>
        </div>
    </div>
</div>
