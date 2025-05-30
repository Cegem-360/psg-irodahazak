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
                    <a href="https://flowbite.com" class="flex items-center">
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
    <div class="relative bg-cover bg-center bg-no-repeat"
        style="background-image: url({{ Vite::asset('resources/images/reflections-in-modern-dutch-design-architecture-2025-03-23-22-04-59-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white to-white/30"></div>
        </ </div>
        <div class="kiemelt-ajanlatok relative z-10 container mx-auto pt-12 pb-20">
            <h2
                class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow bg-clip-text text-transparent bg-gradient-to-r from-indigo-950 to-violet-600">
                Kiemelt ajánlatok</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-w-screen-xl mx-auto">
                <div class="bg-white/10 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
                    <img src="{{ Vite::asset('resources/images/andrassy_palace_iroda_5__384x246.jpg') }}"
                        alt="Kiemelt ajánlatok" class="w-full h-auto object-cover" />
                    <div class="p-6 pl-8">
                        <h3 class="text-xl font-bold mb-2">Andrássy Palace Iroda</h3>
                        <p class="text-gray-700 min-h-24">1061 Budapest, Andrássy út 9.<br><strong>Bérleti díj:
                            </strong>16 - 17
                            EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2990 HUF/m2/hó</p>
                        <a href="#"
                            class="inline-block mb-4 px-6 py-2 bg-primary text-white rounded hover:bg-secondary transition-colors">További
                            részletek</a>
                    </div>
                </div>
                <div class="bg-white/10 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
                    <img src="{{ Vite::asset('resources/images/arena_corner_irodahaz_1__384x246.jpg') }}"
                        alt="Kiemelt ajánlatok" class="w-full h-auto object-cover" />
                    <div class="p-6 pl-8">
                        <h3 class="text-xl font-bold mb-2">Arena Corner</h3>
                        <p class="text-gray-700 min-h-24">1087 Budapest, Hungária körút 40.<br><strong>Bérleti
                                díj:
                            </strong>14.5 - 15.5 EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2200 HUF/m2/hó</p>
                        <a href="#"
                            class="inline-block mb-4 px-6 py-2 bg-primary text-white rounded hover:bg-secondary transition-colors">További
                            részletek</a>
                    </div>
                </div>
                <div class="bg-white/10 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
                    <img src="{{ Vite::asset('resources/images/bank_center_1_2_3_4_5_384x246.jpg') }}"
                        alt="Kiemelt ajánlatok" class="w-full h-auto object-cover" />
                    <div class="p-6 pl-8">
                        <h3 class="text-xl font-bold mb-2">Bank Center</h3>
                        <p class="text-gray-700 min-h-24">1054 Budapest, Szabadság tér 7.<br><strong>Bérleti díj:
                            </strong>22 - 26 EUR/m2/hó<br><strong>Üzemeltetési díj: </strong>2700 HUF/m2/hó</p>
                        <a href="#"
                            class="inline-block mb-4 px-6 py-2 bg-primary text-white rounded hover:bg-secondary transition-colors">További
                            részletek</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rolunk-mondtak my-12">
        <div class="relative">
            <h2
                class="my-16 font-bold text-gray-500 text-5xl text-center drop-shadow bg-clip-text text-transparent bg-gradient-to-r from-indigo-950 to-violet-600">
                Rólunk mondták</h2>
            <div class="absolute -right-8 -top-10 z-10 w-1/3 text-accent/60 blur-3xl">
                <x-svg.psg-irodahazak-symbol-1 />
            </div>
            <div class="absolute -left-8 -top-16 z-10 w-1/3 text-accent/60 blur-3xl">
                <x-svg.psg-irodahazak-symbol-2 />
            </div>
            <div class="absolute left-[50%] -translate-x-[50%] -bottom-40 z-10 w-96 text-accent/30 blur-3xl">
                <x-svg.psg-irodahazak-symbol-3 />
            </div>
        </div>
        <div class="py-8 bg-gradient-to-b from-gray-400 to-accent/20">
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-2 max-w-screen-xl mx-auto">
                <div class="flex flex-col md:flex-row gap-8 p-12">
                    <img src="{{ Vite::asset('resources/images/centrica_800x600.png') }}" alt=""
                        class="w-1/3 h-fit object-contain rounded-lg mb-4 p-2 bg-white" />
                    <p class="w-2/3 text-md italic">
                        “Januárban kezdtük el az új irodánk felkutatását, melyre a PSG képviselőjét kértük fel. A
                        cél
                        egy presztízs iroda megtalálása volt budai lokációban. Közel egy tucat irodát tekintettünk
                        meg,
                        de a MOM környéke lett végül a befutó, mely mind a közelben lévő szolgáltatásokat tekintve,
                        mind
                        az irodaház adottságait figyelembe véve tökéletesen megfelelt az igényeinknek. A korábbi
                        irodánk
                        értékesítésével is Richárdot bíztuk meg, aki a megbízástól számítva kevesebb mint fél év
                        alatt
                        vevőt talált az ingatlanokra és a tranzakció már le is zárul. Köszönjük a közreműködést!“
                        <br>
                        <br>
                        <strong>Szabó Péter, Centica Business Solutions Zrt.</strong>
                    </p>
                </div>
                <div class="flex flex-col md:flex-row gap-8 p-12">
                    <img src="{{ Vite::asset('resources/images/aegon_logo_800x600.png') }}" alt=""
                        class="w-1/3 h-fit object-contain rounded-lg mb-4 p-2 bg-white" />
                    <p class="w-2/3 text-md italic">
                        “Több mint 1 éves irodakeresési folyamatot tudtunk lezárni a PSG és azon belül is Fekete
                        Richárd
                        segítségével. Bár többször is úgy tűnt nem sikerült megtalálni a csapatunk számára a
                        legideálisabb irodát, Richárd kitartó és támogató hozzáállásával mégis sikerült! Így a
                        közlekedés szempontjából frekventált és üzletileg kiemelt helyen találtuk meg új irodánkat.
                        Köszönjük a mindenre kiterjedő szervezést és a folyamatok végéig a
                        koordinálást.&nbsp;&nbsp;“
                        <br>
                        <br>
                        <strong>Orosz Zoltán üv., United Insurance Company Kft., mint az Aegon Biztosító Zrt.
                            kiemelt
                            üzleti partnere</strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="referenciak my-12">
            <h2
                class="my-16 font-bold text-gray-500 text-5xl text-center drop-shadow bg-clip-text text-transparent bg-gradient-to-r from-indigo-950 to-violet-600">
                Referenciák, akik velünk költöztek</h2>
            <div class=" py-8 bg-[#EFEFEF]">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 max-w-screen-xl mx-auto">
                    <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                        <img class="max-w-[90%] object-contain"
                            src="{{ Vite::asset('resources/images/aip_logo_800x600.jpg') }}" />
                    </div>
                    <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                        <img class="max-w-[90%] object-contain"
                            src="{{ Vite::asset('resources/images/datapao_logo_800x600.png') }}" />
                    </div>
                    <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                        <img class="max-w-[90%] object-contain"
                            src="{{ Vite::asset('resources/images/collabit_logo_800x600.png') }}" />
                    </div>
                    <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                        <img class="max-w-[90%] object-contain"
                            src="{{ Vite::asset('resources/images/welsec_logo_800x600.png') }}" />
                    </div>
                    <div class="flex items-center justify-center p-4 bg-white rounded-xl">
                        <img class="max-w-[90%] object-contain"
                            src="{{ Vite::asset('resources/images/artera_800x600.jpg') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Blog section -->
    <div class="max-w-screen-xl mx-auto px-4 py-8 space-y-4">
        <div class="mb-6">
            <span
                class="bg-gradient-to-r from-accentdark to-indigo-800 text-white text-2xl font-bold py-1 px-3 rounded">BLOG</span>
        </div>

        <!-- Blog post -->
        <div class="grid md:grid-cols-2 gap-4 border-t border-gray-200 p-8 bg-[#F3F3F3]">
            <div>
                <h2 class="text-3xl font-semibold text-gray-800">
                    Mindig éjszakába nyúlóan dolgozik? Ne tegye! - súlyos károkat okoz az agyban
                </h2>
                <p class="text-md italic text-primary mt-2">2025.05.15</p>
                <p class="text-gray-700 mt-4 text-lg">
                    Ma már kutatások sora bizonyítja, hogy rendkívül súlyos károkat okoz az ember agyában, hogyha
                    túl sokat dolgozik, túlhajszolja magát. Fiatal felnőttként még nem tűnhet fel, de évtizedekkel
                    később megbosszulhatja magát a rendszertelen munka. Tudósok most riadót fújnak, túl sok ember
                    hal bele ebbe évente.
                </p>
            </div>
            <div class="relative">
                <img src="{{ Vite::asset('resources/images/ai-generated-8614999_1280.jpg') }}" alt="Blog image"
                    class="-my-8 w-full h-full object-cover">
                <a href="#"
                    class="absolute bottom-4 right-0 bg-primary text-white px-3 py-1 text-xl font-semibold hover:bg-primary transition">TELJES
                    CIKK >></a>
            </div>
        </div>

        <!-- Blog post -->
        <div class="grid md:grid-cols-2 gap-4 border-t border-gray-200 p-8 bg-[#F3F3F3]">
            <div>
                <h2 class="text-3xl font-semibold text-gray-800">
                    Volt, hogy a pápaválasztó bíborosok feje fölül lebontották a tetőt – történelmi konklávék
                </h2>
                <p class="text-md italic text-primary mt-2">2025.04.30</p>
                <p class="text-gray-700 mt-4 text-lg">
                    Miközben napokon belül megkezdődik a konklávé a Vatikánban, érdemes felidézni, hogy milyen
                    megdöbbentő pápaválasztások voltak a katolikus egyház történetében.
                </p>
            </div>
            <div class="relative">
                <img src="{{ Vite::asset('resources/images/conclave-mas-largo-1268_1200_800.webp') }}"
                    alt="Conclave image" class="-my-8 w-full h-full object-cover">
                <a href="#"
                    class="absolute bottom-4 right-0 bg-primary text-white px-3 py-1 text-xl font-semibold hover:bg-primary transition">TELJES
                    CIKK >></a>
            </div>
        </div>

        <!-- Blog post -->
        <div class="grid md:grid-cols-2 gap-4 border-t border-b border-gray-200 p-8 bg-[#F3F3F3]">
            <div>
                <h2 class="text-3xl font-semibold text-gray-800">A 12 pont születésének története</h2>
                <p class="text-md italic text-primary mt-2">2025.03.15</p>
                <p class="text-gray-700 mt-4 text-lg">
                    Kossuth Lajostól indult el, volt hozzá külön bevezető magyarázat, először aláírásgyűjtő
                    petícióként akarták elindítani. A 12 pont születésének története.
                </p>
            </div>
            <div class="relative">
                <img src="{{ Vite::asset('resources/images/12_pont_0_jpg.jpg') }}" alt="12 pont image"
                    class="-my-8 w-full h-full object-cover">
                <a href="#"
                    class="absolute bottom-4 right-0 bg-primary text-white px-3 py-1 text-xl font-semibold hover:bg-primary transition">TELJES
                    CIKK >></a>
            </div>
        </div>
    </div>




    <!-- News section -->
    <div class="bg-[#F3F3F3]">
        <div class="max-w-screen-xl mx-auto px-4 py-8 space-y-4">
            <div class="mb-6">
                <span class="bg-secondary text-white text-2xl font-bold py-1 px-3 rounded">HÍREK</span>
            </div>

            <!-- News post -->
            <div class="grid md:grid-cols-2 gap-4 border-t border-gray-200 p-8 bg-white">
                <div class="">
                    <img src="{{ Vite::asset('resources/images/bakerstreet_irodahaz_1__800x600.jpg') }}"
                        alt="Blog image" class="-my-8 w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <h2 class="text-3xl font-semibold text-gray-800">
                        Eladták az Újbuda szívében épült irodaházat
                    </h2>
                    <p class="text-md italic text-primary mt-2">2025.05.15</p>
                    <p class="text-gray-700 mt-4 text-lg">
                        Az Atenor sikeresen eladta a teljesen bérbe adott irodai és kiskereskedelmi fejlesztését, az
                        újbudai
                        BakerStreet I. irodaházat - közölte a társaság.
                    </p>
                    <a href="#"
                        class="bg-primary self-end text-white mt-8 px-4 py-2 text-lg font-semibold hover:bg-primary transition">Részletek</a>
                </div>
            </div>

            <!-- News post -->
            <div class="grid md:grid-cols-2 gap-4 border-t border-gray-200 p-8 bg-white">
                <div class="">
                    <img src="{{ Vite::asset('resources/images/home_office_800x600.png') }}" alt="Conclave image"
                        class="-my-8 w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <h2 class="text-3xl font-semibold text-gray-800">
                        Felmérés: Tetőzik a home office-arány hazánkban?
                    </h2>
                    <p class="text-md italic text-primary mt-2">2025.04.30</p>
                    <p class="text-gray-700 mt-4 text-lg">
                        Csúcsához közelít a home office-ban tölthető idő aránya a teljes munkaidőn belül – ez derült
                        ki
                        az
                        ICON által kezelt irodaépületek bérlőinek döntéshozói körében készített felmérésből. Négy
                        bérlőből
                        három nem tervezi tovább növelni az eddigi HO-napok számát a következő 1-2 évben. A
                        nemzetközi
                        trendek már a hibrid munkavégzés csökkenését mutatják.
                    </p>
                    <a href="#"
                        class="bg-primary self-end text-white mt-8 px-4 py-2 text-lg font-semibold hover:bg-primary transition">Részletek</a>
                </div>
            </div>

            <!-- News post -->
            <div class="grid md:grid-cols-2 gap-4 border-t border-b border-gray-200 p-8 bg-white">
                <div class="">
                    <img src="{{ Vite::asset('resources/images/hirek_office_800x600.jpg') }}" alt="12 pont image"
                        class="-my-8 w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <h2 class="text-3xl font-semibold text-gray-800">A tavalyi év volt az irodapiac mélypontja?
                    </h2>
                    <p class="text-md italic text-primary mt-2">2025.03.15</p>
                    <p class="text-gray-700 mt-4 text-lg">
                        Az európai irodapiac jelentős visszaesést mutatott 2024-ban, ami az elmúlt évek
                        legalacsonyabb
                        tranzakciós volumenét eredményezte. A befektetők óvatossága mögött elsősorban a távmunka
                        terjedése
                        és az épületek fenntarthatósági korszerűsítésének magas költségei állnak. Az MSCI adatai
                        szerint
                        az
                        irodaházak részesedése az európai kereskedelmi ingatlanpiacon rekordalacsony szintre, 22%-ra
                        csökkent - közölte a Bloomberg.
                    </p>
                    <a href="#"
                        class="bg-primary self-end text-white mt-8 px-4 py-2 text-lg font-semibold hover:bg-primary transition">Részletek</a>
                </div>
            </div>
        </div>
    </div>





    <!-- Felső narancssárga sáv -->
    <div class="bg-secondary text-white py-4 text-center">
        <p class="text-lg md:text-3xl font-bold">
            <a href="tel:+36203813917" class="">Kérjen ajánlatot most!</a>
            <span class="inline-block ml-4"><i class="fas fa-phone-alt"></i> +36 20 381 3917</span>
        </p>
    </div>

    <!-- Linklista -->
    <div class="bg-[#EFEFEF] py-8 px-4">
        <div
            class="max-w-screen-xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-gray-800 text-lg">

            <ul class="space-y-2">
                <li>Kiadó azonnali szolgáltatott irodák</li>
                <li>Kiadó pesti irodák</li>
                <li>Kiadó belvárosi irodák</li>
                <li>Kiadó irodák V. kerület</li>
            </ul>

            <ul class="space-y-2">
                <li>Kiadó Váci úti irodák</li>
                <li>Kiadó budai irodák</li>
                <li>Kiadó bel-budai irodák</li>
                <li>Kiadó irodák XI. kerület</li>
            </ul>

            <ul class="space-y-2">
                <li>Kiadó zöld irodák</li>
                <li>Kiadó klasszikus irodaházak</li>
                <li>Kiadó új irodaházak</li>
                <li>Eladó irodák</li>
            </ul>

        </div>
    </div>








    <div class="relative bg-cover bg-center" style="background-image: url('/path/to/irodahatter.jpg');">
        <div
            class="bg-white/70 backdrop-blur-sm py-8 px-6 md:px-12 flex flex-col md:flex-row items-start justify-center gap-8 max-w-7xl mx-auto">

            <!-- Térkép -->
            <div class="w-full md:w-1/3 flex flex-col items-center">
                <img src="/path/to/budapest-terkep.png" alt="Budapest térkép" class="w-64 md:w-full">
                <label class="mt-2 text-sm text-blue-600 flex items-center">
                    <input type="checkbox" class="mr-2">
                    Agglomeráció találatait is mutassa
                </label>
            </div>

            <!-- Keresőmezők -->
            <div class="w-full md:w-2/3 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select class="w-full border border-gray-300 rounded px-4 py-2">
                        <option disabled selected>Válasszon kerületet!</option>
                        <option>I. kerület</option>
                        <option>II. kerület</option>
                        <!-- Továbbiak... -->
                    </select>

                    <select class="w-full border border-gray-300 rounded px-4 py-2">
                        <option disabled selected>Irodaház neve</option>
                        <option>Árpád Center</option>
                        <option>RiverPark</option>
                        <!-- Továbbiak... -->
                    </select>
                </div>

                <input type="text" placeholder="Keresett kifejezés"
                    class="w-full border border-gray-300 rounded px-4 py-2">

                <!-- Range szűrők -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold">Alapterület (m²)</label>
                    <input type="range" min="0" max="3000" value="0"
                        class="w-full accent-blue-600">
                    <div class="flex justify-between text-sm">
                        <span>0</span>
                        <span>3000+</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold">Bérleti díj (€/m²)</label>
                    <input type="range" min="1" max="30" value="1"
                        class="w-full accent-blue-600">
                    <div class="flex justify-between text-sm">
                        <span>1</span>
                        <span>30+</span>
                    </div>
                </div>

                <!-- Keresés gomb -->
                <div>
                    <button
                        class="bg-blue-600 text-white font-semibold px-8 py-2 rounded hover:bg-blue-700 transition">
                        KERESÉS
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
