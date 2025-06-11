<div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pt-32 pb-0">
    {{-- 1. oszlop --}}
    <div class="flex flex-col items-center text-center space-y-4">
        <x-svg.office class="text-primary brightness-75 w-20 h-20" />
        <div class="text-5xl font-bold text-primary">
            <span class="counter" data-to="4" data-suffix=" millió">0</span>
        </div>
        <div class="text-lg font-semibold text-gray-700">m² iroda <br>Budapesten</div>
        <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
    </div>
    {{-- 2. oszlop --}}
    <div class="flex flex-col items-center text-center space-y-4">
        <x-svg.experience class="text-primary brightness-75 w-20 h-20" />
        <div class="text-5xl font-bold text-primary">
            <span class="counter" data-to="25" data-suffix="+">0</span>
        </div>
        <div class="text-lg font-semibold text-gray-700">év <br>tapasztalat</div>
        <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
    </div>
    {{-- 3. oszlop --}}
    <div class="flex flex-col items-center text-center space-y-4">
        <x-svg.market class="text-primary brightness-75 w-20 h-20" />
        <div class="text-5xl font-bold text-primary">
            <span class="counter" data-to="90" data-suffix="%">0</span>
        </div>
        <div class="text-lg font-semibold text-gray-700">feletti<br> piaci ismeret</div>
        <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
    </div>
    {{-- 4. oszlop --}}
    <div class="flex flex-col items-center text-center space-y-4">
        <x-svg.handshake class="text-primary brightness-75 w-20 h-20" />
        <div class="text-5xl font-bold text-primary">
            <span class="counter" data-to="50" data-suffix="+">0</span>
        </div>
        <div class="text-lg font-semibold text-gray-700">tranzakció<br> évente</div>
        <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
    </div>
</div>

{{-- Számláló animáció --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
