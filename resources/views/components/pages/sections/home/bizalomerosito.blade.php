<div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8 pt-32 pb-0">

    {{-- 1. oszlop --}}
    <div class="flex flex-col items-center text-center space-y-4">
        <x-svg.office class="text-primary brightness-75 w-20 h-20" />
        <div class="text-5xl font-bold text-primary">
            <span class="counter" data-to="4" data-suffix=" {{ __('million') }}">4 {{ __('million') }}</span>
        </div>
        <div class="text-lg font-semibold text-gray-700">m2 {{ __('of office space') }} <br>{{ __('in Budapest') }}</div>
        <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
    </div>
    {{-- 2. oszlop --}}
    <div class="flex flex-col items-center text-center space-y-4">
        <x-svg.experience class="text-primary brightness-75 w-20 h-20" />
        <div class="text-5xl font-bold text-primary">
            <span class="counter" data-to="25" data-suffix="+">25+</span>
        </div>
        <div class="text-lg font-semibold text-gray-700">{{ __('years') }} <br>{{ __('experience') }}</div>
        <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
    </div>
    {{-- 3. oszlop --}}
    <div class="flex flex-col items-center text-center space-y-4">
        <x-svg.market class="text-primary brightness-75 w-20 h-20" />
        <div class="text-5xl font-bold text-primary">
            <span class="counter" data-to="90" data-suffix="%">90%</span>
        </div>
        <div class="text-lg font-semibold text-gray-700">{{ __('above') }}<br> {{ __('market knowledge') }}</div>
        <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
    </div>
    {{-- 4. oszlop --}}
    <div class="flex flex-col items-center text-center space-y-4">
        <x-svg.handshake class="text-primary brightness-75 w-20 h-20" />
        <div class="text-5xl font-bold text-primary">
            <span class="counter" data-to="100" data-suffix="{{ __('thousand') }} +">100{{ __('thousand') }} +</span>
        </div>
        <div class="text-lg font-semibold text-gray-700">m2 {{ __('leased') }} <br>{{ __('Class A office space') }}
        </div>
        <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
    </div>
</div>

{{-- Számláló animáció --}}

<script>
    document.addEventListener('livewire:initialized', function() {
        let animated = false;
        const counters = document.querySelectorAll('.counter');
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !animated) {
                    animated = true;
                    counters.forEach(function(el) {
                        const to = parseInt(el.getAttribute('data-to'));
                        const suffix = el.getAttribute('data-suffix') || '';
                        let current = 0;
                        el.textContent = current + suffix;
                        const duration = 1500;
                        const stepTime = Math.max(Math.floor(duration / to), 30);
                        const increment = to / (duration / stepTime);

                        function updateCounter() {
                            current += increment;
                            if (current < to) {
                                el.textContent = Math.floor(current) + suffix;
                                setTimeout(updateCounter, stepTime);
                            } else {
                                el.textContent = to + suffix;
                            }
                        }
                        updateCounter();
                    });
                    observer.disconnect();
                }
            });
        }, {
            threshold: 0.8
        }); // 30% láthatóság után indul

        if (counters.length > 0) {
            observer.observe(counters[0].closest('.grid'));
        }
    });
</script>
