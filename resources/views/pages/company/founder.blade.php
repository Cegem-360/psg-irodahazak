@inject('structuredData', 'App\Services\StructuredDataService')
<x-slot name="title">Fekete Richárd, ügyvezető | PSG Irodaházak</x-slot>
<x-slot name="metaDescription">Fekete Richárd, a PSG Irodaházak ügyvezetője: 2002 óta a budapesti irodapiacon, több mint 250 irodabérleti és értékesítési ügylet, 100 ezer m² fölötti irodaterület.</x-slot>
<x-slot name="meta">
    <meta property="og:type" content="profile">
    @if ($structuredData->founderPhotoUrl())
        <meta property="og:image" content="{{ $structuredData->founderPhotoUrl() }}">
    @endif
    {{ $structuredData->toScript($structuredData->profilePage(route('fekete-richard'))) }}
</x-slot>

<div>
    <x-page-section spacing="space-y-8">
        <x-slot:heading>Fekete Richárd, ügyvezető</x-slot:heading>

        <x-glass-panel>
            <article class="p-4 md:p-8 grid grid-cols-1 lg:grid-cols-3 gap-10">
                @if ($structuredData->founderPhotoUrl())
                    <div>
                        <img src="{{ $structuredData->founderPhotoUrl() }}" width="1200" height="1360"
                            alt="Fekete Richárd, a PSG Irodaházak ügyvezetője"
                            class="w-full h-auto rounded-xl shadow-lg lg:sticky lg:top-8">
                    </div>
                @endif

                <div @class(['prose prose-lg max-w-none text-gray-700 prose-a:text-accent prose-headings:text-logogray', 'lg:col-span-2' => $structuredData->founderPhotoUrl(), 'lg:col-span-3' => ! $structuredData->founderPhotoUrl()])>
                    <p class="lead">Fekete Richárd a PSG Irodaházak alapítója és ügyvezetője, 2002 óta dolgozik a budapesti irodapiacon. Cégeknek segít irodát találni, bérleti szerződést tárgyalni és újratárgyalni, valamint irodaházakat értékesíteni. Az elmúlt években több mint 250 bérleti és adásvételi ügyletet vezetett végig, összesen 100 ezer m² fölötti irodaterületre. Közgazdász és ingatlangazdálkodási szakközgazdász végzettségű.</p>

                    <h2>Szakmai út</h2>

                    <p>Pályáját 2002-ben a Tömb Ingatlanhasznosító Kft.-nél kezdte, ahol irodaházak hasznosításával foglalkozott. 2003-tól 2014-ig a B.G. Property irodabérbeadási tanácsadójaként dolgozott, és ebben a tizenegy évben a budapesti irodapiac minden alpiacán, a belvárostól a Váci úton át Dél-Budáig vezetett bérbeadásokat. 2014-ben alapította a Property Solution Group Kft.-t, amelynek irodabérbeadási és tanácsadói márkája a PSG Irodaházak. 2022 óta a cég a bérlők oldalán a bérleti szerződések újratárgyalásával is foglalkozik, 2025-ben pedig a raktár- és ipari ingatlanok közvetítésére a <a href="https://psg-raktarak.hu">psg-raktarak.hu</a> testvéroldallal bővült.</p>

                    <h2>Hogyan dolgozom</h2>

                    <blockquote>
                        <p>„Minden irodakeresés egy számítással kezdődik, nem egy bejárással. Először azt nézzük meg, hány fő, milyen munkarendben, hány tárgyalóval és mekkora tartalékkal dolgozik majd a cég, és ebből jön ki, hogy hány négyzetméterre van szüksége. Fontos szempont a tervezett költözés ideje is: ha nincs idő komolyabb átépítésre, akkor a bekért alaprajzok alapján csak olyan opciókat kínálunk, amelyek kulcsrakész állapota összeegyeztethető a cég beköltözési terveivel. Csak ezután keresünk épületet. A bejáráson már az öt-hat legjobb lehetőséget tekintjük meg az ügyféllel, és minden rövidlistás irodára ültetési tervet készítünk, hogy az ügyfél lássa, hogyan fér el, és hány m² fedi le az igényeit. A tárgyaláson pedig nem csak a négyzetméterdíjat kell figyelembe venni, hanem a teljes bérleti konstrukciót, a felmondási feltételeket és a rejtett költségeket is. Minden ügyfélnél az a cél, hogy elégedett legyen, és egy újratárgyalásnál vagy egy jövőbeli költözésnél ismét mi jussunk az eszébe.”</p>
                    </blockquote>

                    <h2>Ügyletek, amelyekre büszke vagyok</h2>

                    <ul>
                        <li><strong>Netlock, Hungária Center, 4 780 m² (2019).</strong> A cég teljes budapesti központjának költöztetése egy több mint 4 500 m²-es, többszintes területre, a bérleti szerződés és a kialakítás feltételeinek letárgyalásával.</li>
                        <li><strong>Terrapark Next A épület, 10 000 m², értékesítés.</strong> A budaörsi irodaház két és fél hónap alatt talált vevőre, a teljes értékesítési folyamat vezetésével, versenyben más közvetítőkkel.</li>
                        <li><strong>KMÉ Zrt., Olympia irodaház, 1 550 m².</strong> Egy teljes emelet bérbeadása, a bérlő igényeire szabott kialakítással.</li>
                        <li><strong>Electron Holding, Margit Palace, körülbelül 2 000 m².</strong> Egy budai székhely kiválasztása és a bérleti feltételek tárgyalása a Margit körúti irodaházban.</li>
                        <li><strong>Httpool, Bank Center, 250–300 m².</strong> Egy nemzetközi cég belvárosi irodájának kiválasztása az V. kerület egyik prémium épületében, a megkereséstől az aláírásig 2,5 hónap alatt.</li>
                    </ul>

                    <p>További ügyfelek között szerepel a KRKA (Gateway Office Park) és a Centrica. Az ügyfélvélemények a <a wire:navigate.hover href="{{ route('home') }}">főoldalon</a> olvashatók.</p>

                    <h2>Végzettség</h2>

                    <ul>
                        <li>Közgazdász, Budapesti Gazdasági Egyetem</li>
                        <li>Ingatlangazdálkodási szakközgazdász, Budapesti Műszaki és Gazdaságtudományi Egyetem</li>
                    </ul>

                    <h2>Amiről szívesen beszélek</h2>

                    <p>Rendszeresen tart tájékoztatót és ír cikkeket a budapesti irodapiacról: a bérleti díjak alakulásáról, az üzemeltetési díjakról, a bérleti szerződések buktatóiról, a hibrid munkavégzés irodaigényéről és a szolgáltatott iroda és a hagyományos bérlet összehasonlításáról. Sajtómegkeresés, interjú vagy szakmai előadás ügyében a <a wire:navigate.hover href="{{ route('kapcsolat') }}">kapcsolat oldalon</a> vagy a <a href="https://www.linkedin.com/in/richard-fekete-17371943/" rel="noopener" target="_blank">LinkedIn-en</a> érhető el.</p>

                    <p class="not-prose mt-10 rounded-xl bg-logogray/10 p-6 text-gray-800">
                        Fekete Richárd, ügyvezető · Property Solution Group Kft. ·
                        <a href="tel:+36203813917" class="hover:text-accent">+36 20 381 3917</a> ·
                        <a href="mailto:info@psg-irodahazak.hu" class="hover:text-accent">info@psg-irodahazak.hu</a> ·
                        <a href="https://www.linkedin.com/in/richard-fekete-17371943/" rel="noopener" target="_blank" class="text-accent hover:underline">LinkedIn</a>
                    </p>
                </div>
            </article>
        </x-glass-panel>
    </x-page-section>
</div>
