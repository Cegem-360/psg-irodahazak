@php
    // Get the images ftom storage/app/public/ingatlan/gallery
    $images = [
        Storage::url('ingatlan/gallery/akademia_business_center_1__1_800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_1__800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_5__1_800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_6__1_800x600.webp'),
        Storage::url('ingatlan/gallery/academia_irodahaz_3__800x600.webp'),
    ];
@endphp
<div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
    style="background-image: url({{ Vite::asset('resources/images/reflections-in-modern-dutch-design-architecture-2025-03-23-22-04-59-utc.webp') }});">
    <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
    <div class="relative z-10 container mx-auto space-y-8 pt-24 pb-20">
        <h2
            class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow bg-clip-text text-transparent bg-gradient-to-r from-accentdark to-accent">
            Academia irodaház</h2>
        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
            <div>
                <x-layouts.cards.ingatlan-gallery-carousel :images="$images" title="Academia Irodaház" />
            </div>
            <div class="p-4">
                <h2 class="text-3xl">Adatok</h2>
                <table class="table-auto w-full mt-4">
                    <tbody>
                        <tr>
                            <td class="bold head">Név:</td>
                            <td class="head">Academia irodaház</td>
                        </tr>
                        <tr>
                            <td class="bold">Cím:</td>
                            <td>1054 Budapest, Akadémia utca 6.</td>
                        </tr>
                        <tr>
                            <td class="bold">Építés éve:</td>
                            <td>2000 </td>
                        </tr>
                        <tr>
                            <td class="bold">Összterület:</td>
                            <td>12.500 m<sup>2</sup></td>
                        </tr>
                        <tr>
                            <td class="bold">Jelenleg kiadó:</td>
                            <td>1630 m<sup>2</sup></td>
                        </tr>
                        <tr>
                            <td class="bold">Min. kiadó:</td>
                            <td>209 m<sup>2</sup></td>
                        </tr>
                        <tr>
                            <td class="bold">Bérleti díj:</td>
                            <td>25 - 27 EUR/m2/hó</td>
                        </tr>
                        <tr>
                            <td class="bold">Üzemeltetési díj:</td>
                            <td>6.4 EUR/m<sup>2</sup>/hó</td>
                        </tr>
                        <tr>
                            <td class="bold">Raktár terület:</td>
                            <td>65 m<sup>2</sup></td>
                        </tr>
                        <tr>
                            <td class="bold">Raktár bérleti díj:</td>
                            <td>9 EUR/m<sup>2</sup>/hó</td>
                        </tr>
                        <tr>
                            <td class="bold">Parkolás:</td>
                            <td>teremgarázs </td>
                        </tr>
                        <tr>
                            <td class="bold">Parkolás díja:</td>
                            <td>170 EUR/hely/hó</td>
                        </tr>
                        <tr>
                            <td class="bold">Közös területi arány:</td>
                            <td>8.22%</td>
                        </tr>
                        <tr>
                            <td class="bold">Min. bérleti időszak:</td>
                            <td>5 év</td>
                        </tr>
                        <tr>
                            <td class="bold">Kódszám:</td>
                            <td>PSG001 </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 20px" class="bold" colspan="2">A fenti díjakra még 27% ÁFA
                                tevődik!</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
            <div>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2695.3752330104103!2d19.04358067667799!3d47.502083195188725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741dc15d6bf2925%3A0xd7e6926bead52fbc!2sAcademia%20Offices%20%2F%20Irodah%C3%A1z!5e0!3m2!1shu!2shu!4v1749023556934!5m2!1shu!2shu"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="p-4">
                <h2 class="text-3xl">Academia irodaház bemutató</h2>
                <div class="space-y-4 mt-4">
                    <p>TRADÍCIÓ ÉS MODERNITÁS</p>

                    <p>ACADEMIA néven születik újjá Budapest egyik legjobb elhelyezkedésű, közvetlen Duna-parti
                        kereskedelmi ingatlana.</p>

                    <p>A tömegközlekedéssel és kerékpárral egyaránt könnyen megközelíthető épületegyüttestől
                        karnyújtásnyira található számos minőségi étterem, kávézó, szálloda, konferenciaterem és
                        kiskereskedelmi egység.</p>

                    <p>A főváros üzleti, kormányzati, turisztikai és kulturális negyedében álló, belvárosi irodaház az
                        ESG szellemében kiemelkedő digitális kapcsolatokat, okos megoldásokat, akadálymentességet és
                        közösségi funkciókat is biztosít. A tervezett belsőépítészeti és műszaki megoldások, a közös
                        területek és az irodahelyiségek megújulása a fenntarthatóság jegyében zajlik, a környezettudatos
                        minősítések megszerzése mellett pedig az épület a nettó zéró kibocsátást is megcélozza.</p>

                    <p>Az átalakítással és újrapozicionálással a legújabb bérlői elvárásoknak megfelelő épület&nbsp;jön
                        létre, amely innovatív üzemeltetést, kényelmi „concierge” szolgáltatásokat és flexibilisen
                        alakítható irodaterületeket kínál. Az Academia a klasszikus luxust a modern technikával ötvözve
                        nyújt professzionális munkakörnyezetet és kimagasló ügyfélélményt.</p>

                    <p>WELL –– BREEAM –– WiredScore –– Access4You</p>
                </div>
                <h2>Szolgáltatások</h2>
                <div class="space-y-4 mt-4">
                    <a href="/talalatok?tag=24 órás recepció és biztonsági szolgálat" class="label label_szolg">24 órás
                        recepció és biztonsági szolgálat</a><a
                        href="/talalatok?tag=bérlői igényeknek megfelelő alaprajzi kialakítás"
                        class="label label_szolg">bérlői igényeknek megfelelő alaprajzi kialakítás</a><a
                        href="/talalatok?tag=étterem" class="label label_szolg">étterem</a><a
                        href="/talalatok?tag=tárgyaló bérlés lehetősége" class="label label_szolg">tárgyaló bérlés
                        lehetősége</a><a href="/talalatok?tag=raktár bérlési lehetőség" class="label label_szolg">raktár
                        bérlési lehetőség</a><a href="/talalatok?tag=konferenciaterem bérlés lehetősége"
                        class="label label_szolg">konferenciaterem bérlés lehetősége</a><a
                        href="/talalatok?tag=cégtábla kihelyezési lehetőség" class="label label_szolg">cégtábla
                        kihelyezési lehetőség</a><a href="/talalatok?tag=kávézó" class="label label_szolg">kávézó</a><a
                        href="/talalatok?tag=zuhanyzó, öltöző a kerékpárosoknak" class="label label_szolg">zuhanyzó,
                        öltöző a kerékpárosoknak</a><a href="/talalatok?tag=elektromos autó töltő"
                        class="label label_szolg">elektromos autó töltő</a><a
                        href="/talalatok?tag=Concierge szolgáltatások" class="label label_szolg">Concierge
                        szolgáltatások</a><a href="/talalatok?tag=állatbarát épület"
                        class="label label_szolg">állatbarát épület</a>
                </div>
                <h2>Műszaki paraméterek</h2>
                <div class="space-y-4 mt-4">
                    <a href="/talalatok?stag=4 csöves fan-coil légkondicionálás" class="label label_muszaki">4 csöves
                        fan-coil légkondicionálás</a><a href="/talalatok?stag=belső árnyékolók"
                        class="label label_muszaki">belső árnyékolók</a><a
                        href="/talalatok?stag=épületfelügyeleti rendszer" class="label label_muszaki">épületfelügyeleti
                        rendszer</a><a href="/talalatok?stag=frisslevegő ellátás"
                        class="label label_muszaki">frisslevegő ellátás</a><a
                        href="/talalatok?stag=kiváló tömegközlekedési lehetőség" class="label label_muszaki">kiváló
                        tömegközlekedési lehetőség</a><a href="/talalatok?stag=emelt padló"
                        class="label label_muszaki">emelt padló</a><a
                        href="/talalatok?stag=korszerű, kényelmes és gyors liftek" class="label label_muszaki">korszerű,
                        kényelmes és gyors liftek</a><a href="/talalatok?stag=nyitható ablakok"
                        class="label label_muszaki">nyitható ablakok</a><a
                        href="/talalatok?stag=kettős elektromos betáp." class="label label_muszaki">kettős elektromos
                        betáp.</a><a href="/talalatok?stag=álmennyezet" class="label label_muszaki">álmennyezet</a><a
                        href="/talalatok?stag=teherlift" class="label label_muszaki">teherlift</a><a
                        href="/talalatok?stag=akadálymentesített épület" class="label label_muszaki">akadálymentesített
                        épület</a><a href="/talalatok?stag=Access4You" class="label label_muszaki">Access4You</a><a
                        href="/talalatok?stag=elektromos és hibrid autós töltők" class="label label_muszaki">elektromos
                        és hibrid autós töltők</a><a href="/talalatok?stag=magas minőségű kivitelezés és anyaghasználat"
                        class="label label_muszaki">magas minőségű kivitelezés és anyaghasználat</a><a
                        href="/talalatok?stag=optikai kábel-csatlakozás" class="label label_muszaki">optikai
                        kábel-csatlakozás</a><a href="/talalatok?stag=BREEAM minősítés"
                        class="label label_muszaki">BREEAM minősítés</a><a href="/talalatok?stag=WELL-being"
                        class="label label_muszaki">WELL-being</a>
                </div>

            </div>
        </div>
        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
            <div class="">
                <section class="bg-white rounded-xl">
                    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-accent">Lépjen velünk
                            kapcsolatba!</h2>
                        <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 sm:text-xl">Kérjen személyre
                            szabott ajánlatot online!</p>
                        <form action="#" class="space-y-8">
                            <div>
                                <label for="nev" class="block mb-2 text-sm font-medium text-gray-900">Az Ön
                                    neve</label>
                                <input type="text" id="nev"
                                    class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="Az Ön neve" required>
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Az Ön email
                                    címe</label>
                                <input type="email" id="email"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    placeholder="email@email.hu" required>
                            </div>
                            <div>
                                <label for="tel" class="block mb-2 text-sm font-medium text-gray-900">Az Ön
                                    telefonszáma</label>
                                <input type="phone" id="tel"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    placeholder="+36 00 000 0000" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="message"
                                    class="block mb-2 text-sm font-medium text-gray-900">Üzenet</label>
                                <textarea id="message" rows="6"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="Miben lehetünk a segítségére?"></textarea>
                            </div>
                            <button type="submit"
                                class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-primary/70 sm:w-fit hover:bg-accent/70 focus:ring-4 focus:outline-none focus:ring-primary-300">Küldés</button>
                        </form>
                    </div>
                </section>

            </div>
            <div class="space-y-4 p-4">
                <div class="space-y-4">
                    <h2 class="text-3xl">Jellemzők</h2>
                    <ul class="sm:columns-2 gap-x-8 gap-y-3 list-disc text-lg">
                        <li class="pb-1">24 órás recepció és biztonsági szolgálat</li>
                        <li class="pb-1">bérlői igényeknek megfelelő alaprajzi kialakítás</li>
                        <li class="pb-1">étterem</li>
                        <li class="pb-1">tárgyaló bérlés lehetősége</li>
                        <li class="pb-1">raktár bérlési lehetőség</li>
                        <li class="pb-1">konferenciaterem bérlés lehetősége</li>
                        <li class="pb-1">cégtábla kihelyezési lehetőség</li>
                        <li class="pb-1">kávézó</li>
                        <li class="pb-1">zuhanyzó, öltöző a kerékpárosoknak</li>
                        <li class="pb-1">elektromos autó töltő</li>
                        <li class="pb-1">Concierge szolgáltatások</li>
                        <li class="pb-1">állatbarát épület</li>
                    </ul>
                </div>
                {{-- <div class="space-y-4">
                    <h2 class="text-3xl">Műszaki paraméterek</h2>
                    <ul class="sm:columns-2 gap-x-8 gap-y-3 list-disc text-lg">
                        <li class="pb-1">4 csöves fan-coil légkondicionálás</li>
                        <li class="pb-1">belső árnyékolók</li>
                        <li class="pb-1">épületfelügyeleti rendszer</li>
                        <li class="pb-1">frisslevegő ellátás</li>
                        <li class="pb-1">kiváló tömegközlekedési lehetőség</li>
                        <li class="pb-1">emelt padló</li>
                        <li class="pb-1">korszerű, kényelmes és gyors liftek</li>
                        <li class="pb-1">nyitható ablakok</li>
                        <li class="pb-1">kettős elektromos betáp.</li>
                        <li class="pb-1">álmennyezet</li>
                        <li class="pb-1">teherlift</li>
                        <li class="pb-1">akadálymentesített épület</li>
                        <li class="pb-1">Access4You</li>
                        <li class="pb-1">elektromos és hibrid autós töltők</li>
                        <li class="pb-1">magas minőségű kivitelezés és anyaghasználat</li>
                        <li class="pb-1">optikai kábel-csatlakozás</li>
                        <li class="pb-1">BREEAM minősítés</li>
                        <li class="pb-1">WELL-being</li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>
</div>
