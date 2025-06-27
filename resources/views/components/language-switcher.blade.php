<div class="flex items-center space-x-2">
    @php
        $currentLocale = app()->getLocale();
    @endphp

    <div class="lang-menu absolute top-4 lg:top-8 right-2 lg:right-8 flex items-center gap-4 flex-nowrap z-20">
        <a href="{{ localized_route('favorites') }}" title="{{ __('Favorites') }}"
            class="text-primary hover:text-logogray relative group">
            <svg id="favorites-heart-icon" class="w-6 h-6 transition-all duration-200" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <span id="favorites-count-lang"
                class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 min-w-[1.25rem] h-5 items-center justify-center hidden">0</span>
        </a>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update favorites heart icon and count in language switcher
        function updateFavoritesDisplay() {
            const heartIcon = document.getElementById('favorites-heart-icon');
            const countElement = document.getElementById('favorites-count-lang');

            if (!heartIcon || !countElement) return;

            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
            }

            try {
                const favorites = getCookie('property_favorites') || '[]';
                const favoritesArray = JSON.parse(favorites);
                const count = favoritesArray.length;

                // Update heart icon (filled or empty)
                if (count > 0) {
                    heartIcon.setAttribute('fill', 'currentColor');
                    heartIcon.setAttribute('stroke', 'currentColor');

                    // Show count
                    countElement.textContent = count;
                    countElement.classList.remove('hidden');
                    countElement.classList.add('flex');
                } else {
                    heartIcon.setAttribute('fill', 'none');
                    heartIcon.setAttribute('stroke', 'currentColor');

                    // Hide count
                    countElement.classList.add('hidden');
                    countElement.classList.remove('flex');
                }
            } catch (e) {
                // Error case: show empty heart, hide count
                heartIcon.setAttribute('fill', 'none');
                heartIcon.setAttribute('stroke', 'currentColor');
                countElement.classList.add('hidden');
                countElement.classList.remove('flex');
            }
        }

        // Initial update
        updateFavoritesDisplay();

        // Listen for favorites updates
        window.addEventListener('favorites-updated', function() {
            setTimeout(updateFavoritesDisplay, 100);
        });

        // Listen for navigation favorites updates
        window.addEventListener('nav-favorites-update', function() {
            setTimeout(updateFavoritesDisplay, 100);
        });

        // Check periodically
        setInterval(updateFavoritesDisplay, 3000);
    });
</script>
