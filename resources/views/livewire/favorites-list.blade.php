<div>
    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-4 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('My Favorites') }}
            </h2>
            @if ($favoriteCount > 0)
                <h4 class="text-xl text-center mb-8">
                    {{ __('You have') }} {{ $favoriteCount }} {{ __('favorite properties') }}
                </h4>
                <p class="text-center text-gray-600 mb-16">
                    {{ __('Here you can find all the properties you have marked as favorites') }}
                </p>
            @else
                <h4 class="text-xl text-center mb-8">
                    {{ __('No favorites yet') }}
                </h4>
                <p class="text-center text-gray-600 mb-16">
                    {{ __('Start adding properties to your favorites by clicking the heart icon on property cards.') }}
                </p>
            @endif
        </div>
    </div>
    @if ($favoriteCount > 0)
        <div class="flex justify-end max-w-screen-xl mx-auto px-8 pt-8">
            <button wire:click="$dispatch('openSendFavoritesModal')"
                class="flex items-center gap-2 px-6 py-2 bg-primary text-white rounded hover:bg-primary/90 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v4m0-4V8"></path>
                </svg>
                Kedvencek elküldése e-mailben
            </button>
        </div>
    @endif

    @if ($favoriteCount > 0)
        <div class="relative bg-white">
            <div class="container mx-auto py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-screen-xl mx-auto px-8">
                    @foreach ($favoriteProperties as $property)
                        @if ($property->isRent())
                            <livewire:ingatlan-card :property="$property" :image="$property->getFirstImageUrl()" :title="$property->title"
                                :description="$property->getAddressFormated()" :link="localized_route('properties.show', ['property' => $property->slug])" :small="false" :key="'favorite-' . $property->id" />
                        @else
                            <livewire:ingatlan-card :property="$property" :image="$property->getFirstImageUrl()" :title="$property->title"
                                :description="$property->getAddressFormated()" :link="localized_route('properties.show-for-sale', ['property' => $property->slug])" :small="false" :key="'favorite-' . $property->id" />
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="relative bg-white">
            <div class="container mx-auto py-16">
                <div class="text-center">
                    <div class="mb-8">
                        <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">{{ __('No favorites yet') }}</h3>
                    <p class="text-gray-600 mb-8">
                        {{ __('Start adding properties to your favorites by clicking the heart icon on property cards.') }}
                    </p>
                    <a href="{{ route('kiado-irodak') }}"
                        class="inline-block px-8 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors duration-300">
                        {{ __('Browse Properties') }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    <livewire:favorites-send-modal />

</div>
