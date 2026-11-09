<x-layouts.app :with-popups="false">
    <x-page-section>
        <x-slot:heading>@yield('code') · @yield('message')</x-slot:heading>

        <x-glass-panel class="p-8 text-center space-y-8">
            @if (trim($__env->yieldContent('code')) === '404')
                <p class="text-xl text-gray-700">{{ __('The page you are looking for does not exist or has moved.') }}</p>
            @endif
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ localized_route('home') }}"
                    class="px-8 py-3 rounded-lg bg-accent text-white font-bold hover:bg-accent/90 transition-colors">{{ __('Homepage') }}</a>
                <a href="{{ localized_route('kiado-irodak') }}"
                    class="px-8 py-3 rounded-lg bg-white border border-accent text-accent font-bold hover:bg-gray-50 transition-colors">{{ __('Rental Offices') }}</a>
            </div>
        </x-glass-panel>
    </x-page-section>
</x-layouts.app>
