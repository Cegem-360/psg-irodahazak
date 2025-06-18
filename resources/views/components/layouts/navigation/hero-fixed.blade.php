<div class="hero overflow-hidden relative bg-white">
    <div class="lang-menu absolute top-8 right-8 flex items-center gap-4 flex-nowrap z-20">
        <a href="https://www.facebook.com/psgirodahazak" target="_blank" title="https://www.facebook.com/psgirodahazak"
            class="text-primary hover:text-logogray">
            <x-svg.fb-icon class="w-6 h-6" />
        </a>
        <div class="lang text-logogray">
            @php
                $currentLocale = app()->getLocale();
            @endphp
            <a href="{{ route('language.switch', 'hu') }}" title="HUN"
                class="{{ $currentLocale === 'hu' ? 'active' : '' }} hover:underline">HUN</a>
            <span> | </span>
            <a href="{{ route('language.switch', 'en') }}" title="ENG"
                class="{{ $currentLocale === 'en' ? 'active' : '' }} hover:underline">ENG</a>
        </div>
    </div>
    <div
        class="flex flex-col sm:flex-row justify-start items-center gap-8 sm:gap-16 lg:gap-32 mx-auto sm:pl-16 py-8 sm:py-16 max-w-screen-xl">
        <div class="absolute -left-56 -top-16 z-10 w-[40%] text-primary/15"><x-svg.psg-irodahazak-symbol />
        </div>
        <div class="logo">
            <a href="/" class="flex items-center">
                <img src="{{ Vite::asset('resources/images/psg-irodahazak-logo.png') }}" class="mr-3 h-12 sm:h-24"
                    alt="PSG Irodaházak logo" />
            </a>
        </div>
        <div class="slogan flex items-end text-center text-2xl sm:text-3xl">
            <h2>{!! __('page.hero.slogan') !!}</h2>
        </div>
    </div>
</div>
