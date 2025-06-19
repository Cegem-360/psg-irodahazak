<div>

    <div class="relative">

        <div class="kategoria-valaszto grid grid-cols-1 md:grid-cols-4 font-bold">
            <a href="#" class="hero-image relative group">
                <img src="{{ Vite::asset('resources/images/belvarosi_kiado_irodak-2.webp') }}"
                    alt="Belvárosi kiadó irodák" class="w-full h-auto object-cover aspect-[3/2]" />
                <div
                    class="{{-- absolute right-0 bottom-0 left-0  --}}flex items-center justify-center text-xl text-center text-white bg-accentdark/90 backdrop-blur-xl h-[4.5rem] group-hover:bg-accent {{-- group-hover:h-24 --}} duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                        Belvárosi kiadó irodák</h2>
                </div>
            </a>
            <a href="#" class="hero-image relative group">
                <img src="{{ Vite::asset('resources/images/budai_kiado_irodak.webp') }}" alt="Budai kiadó irodák"
                    class="w-full h-auto object-cover aspect-[3/2]" />
                <div
                    class="{{-- absolute right-0 bottom-0 left-0  --}}flex items-center justify-center text-xl text-center text-white bg-accentdark/90 backdrop-blur-xl h-[4.5rem] group-hover:bg-accent {{-- group-hover:h-24 --}} duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                        Budai kiadó irodák</h2>
                </div>
            </a>
            <a href="#" class="hero-image relative group">
                <img src="{{ Vite::asset('resources/images/vaci-uti-irodak.webp') }}" alt="Váci úti kiadó irodák"
                    class="w-full h-auto object-cover aspect-[3/2]" />
                <div
                    class="{{-- absolute right-0 bottom-0 left-0  --}}flex items-center justify-center text-xl text-center text-white bg-accentdark/90 backdrop-blur-xl h-[4.5rem] group-hover:bg-accent {{-- group-hover:h-24 --}} duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                        Váci úti kiadó irodák</h2>
                </div>
            </a>
            <a href="#" class="hero-image relative group">
                <img src="{{ Vite::asset('resources/images/azonnali_szolgaltatott_irodak-2.webp') }}"
                    alt="Azonnali szolgáltatott irodák" class="w-full h-auto object-cover aspect-[3/2]" />
                <div
                    class="{{-- absolute right-0 bottom-0 left-0  --}}flex items-center justify-center text-xl text-center text-white bg-accentdark/90 backdrop-blur-xl h-[4.5rem] group-hover:bg-accent {{-- group-hover:h-24 --}} duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                    <h2 class="group-hover:scale-110 duration-1000 transition-all ease-[cubic-bezier(0.19,1,0.22,1)]">
                        Azonnali szolgáltatott irodák</h2>
                </div>
            </a>
        </div>

    </div>
    <x-pages.sections.home.bizalomerosito />

    @include('pages.forms.szuro')

    <x-pages.sections.home.kiemelt-ajanlatok />

    <x-pages.sections.home.rolunk-mondtak />

    <x-pages.sections.home.referenciak />

    <x-pages.sections.home.blog-section />

    <x-pages.sections.home.hirek-section />

    <x-pages.sections.ajanlat />

</div>
