<div class="relative">
    <nav
        class="fixed lg:absolute lg:-top-0 lg:left-[50%] lg:-translate-x-[50%] lg:-translate-y-[50%] z-10 bg-white lg:bg-transparent px-4 lg:px-0 py-2.5">
        <div class="flex flex-wrap justify-center items-center mx-auto">
            <div class="flex items-center lg:order-2">
                <button data-collapse-toggle="mobile-menu-2" type="button"
                    class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Menü</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul
                    class="flex flex-col mt-4 font-bold lg:flex-row lg:mt-0 text-white text-xl text-nowrap bg-gradient-to-b from-black/30 to-black/5 border border-black/15 backdrop-blur-3xl shadow-lg rounded-md overflow-hidden">
                    <li>
                        <a href="#" class="block py-4 px-8 bg-accent/60 drop-shadow"
                            aria-current="page">Főoldal</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-4 px-8 hover:bg-accent/60 active:bg-accent drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)]">Kiadó
                            irodák</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-4 px-8 hover:bg-accent/60 active:bg-accent drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)]">Eladó
                            irodaházak</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-4 px-8 hover:bg-accent/60 active:bg-accent drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)]">Hírek</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-4 px-8 hover:bg-accent/60 active:bg-accent drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)]">Rólunk</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-4 px-8 hover:bg-accent/60 active:bg-accent drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)]">Blog</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-4 px-8 hover:bg-accent/60 active:bg-accent drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)]">Kapcsolat</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="hero grid grid-cols-1 md:grid-cols-4 font-bold">
        <a href="#" class="hero-image relative group">
            <img src="{{ Vite::asset('resources/images/belvarosi_kiado_irodak.webp') }}" alt="Belvárosi kiadó irodák"
                class="w-full h-auto object-cover" />
            <div
                class="absolute right-0 bottom-0 left-0 flex items-center justify-center text-xl text-center text-white bg-white/30 backdrop-blur-3xl h-[4.5rem] group-hover:bg-accent/40 group-hover:h-24 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    Belvárosi kiadó irodák</h2>
            </div>
        </a>
        <a href="#" class="hero-image relative group">
            <img src="{{ Vite::asset('resources/images/budai_kiado_irodak.webp') }}" alt="Budai kiadó irodák"
                class="w-full h-auto object-cover" />
            <div
                class="absolute right-0 bottom-0 left-0 flex items-center justify-center text-xl text-center text-white bg-white/30 backdrop-blur-3xl h-[4.5rem] group-hover:bg-accent/50 group-hover:h-24 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    Budai kiadó irodák</h2>
            </div>
        </a>
        <a href="#" class="hero-image relative group">
            <img src="{{ Vite::asset('resources/images/vaci_uti_kiado_irodak.webp') }}" alt="Váci úti kiadó irodák"
                class="w-full h-auto object-cover" />
            <div
                class="absolute right-0 bottom-0 left-0 flex items-center justify-center text-xl text-center text-white bg-white/30 backdrop-blur-3xl h-[4.5rem] group-hover:bg-accent/40 group-hover:h-24 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    Váci úti kiadó irodák</h2>
            </div>
        </a>
        <a href="#" class="hero-image relative group">
            <img src="{{ Vite::asset('resources/images/azonnali_szolgaltatott_irodak.webp') }}"
                alt="Azonnali szolgáltatott irodák" class="w-full h-auto object-cover" />
            <div
                class="absolute right-0 bottom-0 left-0 flex items-center justify-center text-xl text-center text-white bg-white/30 backdrop-blur-3xl h-[4.5rem] group-hover:bg-accent/40 group-hover:h-24 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    Azonnali szolgáltatott irodák</h2>
            </div>
        </a>
    </div>
</div>
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
