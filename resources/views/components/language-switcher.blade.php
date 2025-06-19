<div class="flex items-center space-x-2">
    @php
        $currentLocale = app()->getLocale();
    @endphp

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
</div>
