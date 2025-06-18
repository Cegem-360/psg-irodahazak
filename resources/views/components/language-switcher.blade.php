<div class="flex items-center space-x-2">
    @php
        $currentLocale = app()->getLocale();
    @endphp

    <div
        class="flex items-center bg-white/10 lg:bg-white/10 backdrop-blur-sm rounded-md overflow-hidden border border-white/20 lg:border-white/20">
        <a href="{{ route('language.switch', 'hu') }}"
            class="px-3 py-2 text-sm font-medium text-gray-800 lg:text-white hover:bg-gray-200 lg:hover:bg-white/20 transition-colors duration-200 
                  {{ $currentLocale === 'hu' ? 'bg-gray-200 lg:bg-white/20' : '' }}">
            HU
        </a>
        <div class="w-px h-6 bg-gray-300 lg:bg-white/30"></div>
        <a href="{{ route('language.switch', 'en') }}"
            class="px-3 py-2 text-sm font-medium text-gray-800 lg:text-white hover:bg-gray-200 lg:hover:bg-white/20 transition-colors duration-200
                  {{ $currentLocale === 'en' ? 'bg-gray-200 lg:bg-white/20' : '' }}">
            EN
        </a>
    </div>
</div>
