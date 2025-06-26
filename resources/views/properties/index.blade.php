<x-layouts.app>
    <x-slot name="title">{{ __('Properties') }} - {{ config('app.name') }}</x-slot>

    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Properties') }}</h1>
                <p class="mt-2 text-gray-600">{{ __('Browse our offerings and find the ideal property.') }}</p>
            </div>
        </div>

        <!-- Properties Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if ($properties->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($properties as $property)
                        <x-cards.property-card :property="$property" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('No properties available') }}</h3>
                    <p class="text-gray-600">{{ __('There are currently no properties to display in the system.') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
