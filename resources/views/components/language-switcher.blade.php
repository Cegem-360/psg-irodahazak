<div class="flex items-center space-x-2">
    @php
        $currentLocale = app()->getLocale();
    @endphp

    <div class="lang-menu absolute top-4 lg:top-8 right-2 lg:right-8 flex items-center gap-4 flex-nowrap z-20">
        @auth
            <a wire:navigate.hover href="{{ localized_route('favorites') }}" title="{{ __('Favorites') }}"
                class="text-primary hover:text-logogray relative group">
                <svg id="favorites-heart-icon" class="w-6 h-6 transition-all duration-200" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span id="favorites-count-lang"
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 min-w-5 h-5 items-center justify-center hidden">0</span>
            </a>
        @endauth

        <a href="https://www.facebook.com/psgirodahazak" target="_blank" title="https://www.facebook.com/psgirodahazak"
            class="text-primary hover:text-logogray">
            <x-svg.fb-icon class="w-6 h-6" />
        </a>
        <div class="lang text-logogray">
            @php
                // The same page in the other language when it has one; otherwise just switch the session.
                $alternateUrls = app(App\Services\LocalizedRoutes::class)->alternates(request()->route());
            @endphp
            <a href="{{ $alternateUrls['hu'] ?? route('language.switch', ['locale' => 'hu']) }}" title="HUN"
                @class(['active' => $currentLocale === 'hu', 'hover:underline'])>HUN</a>
            <span> | </span>
            <a href="{{ $alternateUrls['en'] ?? route('language.switch', ['locale' => 'en']) }}" title="ENG"
                @class(['active' => $currentLocale === 'en', 'hover:underline'])>ENG</a>
        </div>
    </div>
</div>
