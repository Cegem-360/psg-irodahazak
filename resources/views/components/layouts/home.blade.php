<div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
    <header>
        <div class="top-bar relative bg-primary text-white text-xl">
            <div class="absolute bg-accentdark/90 inset-0"></div>
            <div class="relative z-10 container flex justify-center items-center mx-auto">
                <a href="tel:+36203813917"
                    class="flex items-center px-6 py-6 bg-gradient-to-b from-accent/80 to-accent/60">
                    +36 20 381 3917
                </a>
                <a href="mailto:info@psg-irodahazak.hu" class="flex items-center px-6 py-6 hover:bg-accent/80">
                    info@psg-irodahazak.hu
                </a>
                <a href="#" class="flex items-center px-6 py-6 hover:bg-accent/80">
                    online kapcsolatfelvétel
                </a>
                <a href="#" class="flex items-center px-6 py-6 hover:bg-accent/80">
                    bejelentkezés|regisztráció
                </a>
            </div>
        </div>
        <div class="overflow-hidden relative ">
            <div class="flex justify-around items-center gap-32 mx-auto py-24 max-w-screen-xl">
                <div class="absolute -left-56 -top-16 z-10 w-[40%] text-primary/15"><x-svg.psg-irodahazak-symbol />
                </div>
                <div class="logo">
                    <a href="/" class="flex items-center">
                        <img src="{{ Vite::asset('resources/images/psg-irodahazak-logo.png') }}"
                            class="mr-3 h-12 sm:h-24" alt="PSG Irodaházak logo" />
                    </a>
                </div>
                <div class="slogan flex items-end text-center text-3xl">
                    <h2>A teljes budapesti <br><strong>„A” kategóriás kiadó irodaház kínálat</strong> <br>egy helyen
                    </h2>
                </div>
            </div>
        </div>
    </header>
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
                <img src="{{ Vite::asset('resources/images/belvarosi_kiado_irodak.webp') }}"
                    alt="Belvárosi kiadó irodák" class="w-full h-auto object-cover" />
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
    <div class="relative">
        <h2 class="text-4xl text-center mt-24 mb-8">Találja meg velünk vállalkozása <span class="text-primary">új
                ideális</span> otthonát</h2>
        <div class="absolute -right-8 -top-10 z-10 w-1/3 text-accent/60 blur-3xl"><x-svg.psg-irodahazak-symbol-1 />
        </div>
        <div class="absolute -left-8 -top-16 z-10 w-1/3 text-accent/60 blur-3xl"><x-svg.psg-irodahazak-symbol-2 /></div>
        <div class="absolute left-[50%] -translate-x-[50%] -bottom-40 z-10 w-96 text-accent/30 blur-3xl">
            <x-svg.psg-irodahazak-symbol-3 />
        </div>
    </div>

    <x-layouts.kiemelt-ajanlatok />

    <x-layouts.rolunk-mondtak />

    <x-layouts.referenciak />

    <x-layouts.blog />

    <x-layouts.hirek />

    <x-layouts.ajanlat />

    <x-layouts.footer />


    {{-- @livewire('house-search') --}}
    <x-layouts.szuro />

</div>
