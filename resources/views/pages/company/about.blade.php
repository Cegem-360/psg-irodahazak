@inject('structuredData', 'App\Services\StructuredDataService')
@if (app()->getLocale() === 'hu')
    <x-slot name="title">Rólunk: PSG Irodaházak, irodabérbeadás Budapesten 2014 óta</x-slot>
    <x-slot name="metaDescription">A PSG Irodaházak (Property Solution Group Kft.) 2014 óta segít cégeknek irodát találni Budapesten. 230 irodaház kínálata, 250+ szerződés, ajánlat 24 órán belül, a bérlőnek díjmentesen.</x-slot>
@else
    <x-slot name="title">{{ __('About Us | PSG Irodaházak') }}</x-slot>
    <x-slot name="metaDescription">{{ __('Since 2014, Property Solution Group Kft. has been helping companies as tenants on the Budapest office market: independent tenant representation, office search and negotiation free of charge.') }}</x-slot>
@endif
<x-slot name="meta">
    {{ $structuredData->toScript($structuredData->aboutPage(localized_route('rolunk'))) }}
</x-slot>

<div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
    @if (app()->getLocale() === 'hu')
        <x-page-section spacing="space-y-8">
            <x-slot:heading>Rólunk: a PSG Irodaházak</x-slot:heading>

            <x-glass-panel>
                <div class="prose prose-lg max-w-none p-4 md:p-8 text-gray-700 prose-a:text-accent prose-headings:text-logogray">
                    <p class="lead">A PSG Irodaházak a Property Solution Group Kft. irodabérbeadási és ingatlan-tanácsadói márkája. 2014 óta segítünk cégeknek irodát találni Budapesten, bérleti szerződést tárgyalni és újratárgyalni, irodaházat eladni vagy raktárt keresni. 230 budapesti irodaház aktuális kínálatát kezeljük, ami az A kategóriás irodaházak szinte teljes körét lefedi. Ajánlatot 24 órán belül küldünk, és a bérlők számára a közvetítői munkánk díjmentes, kivéve a bérlőképviseleti megbízást.</p>

                    <h2>A PSG Irodaházak számokban</h2>

                    <ul>
                        <li><strong>230 irodaház</strong> kínálata az adatbázisunkban, együtt mintegy 4 millió m² irodaterülettel</li>
                        <li><strong>16 év</strong> irodapiaci tapasztalat Budapest minden alpiacán</li>
                        <li><strong>250-nél több</strong> megkötött bérleti és adásvételi szerződés</li>
                        <li><strong>100 ezer m² fölötti</strong> bérbe adott A kategóriás irodaterület</li>
                        <li><strong>24 óra:</strong> legfeljebb ennyi idő alatt küldünk ajánlatot a megadott igényre</li>
                    </ul>

                    <h2>Mit csinálunk</h2>

                    <p><strong><a wire:navigate.hover href="{{ route('kiado-irodak') }}">Irodakeresés.</a></strong> Felmérjük a létszám-, munkarend- és költségigényt, ebből kiszámoljuk a szükséges területet, és a 230 irodaház kínálatából öt-hét lehetőséget mutatunk be. A bejárásokat megszervezzük, a rövidlistás irodákra ültetési tervet készíttetünk, és a bérleti szerződést a bérlői szempontok figyelembevételével tárgyaljuk le. A szolgáltatás a bérlőnek díjmentes.</p>

                    <p><strong>Bérleti szerződés újratárgyalása.</strong> Ha a szerződés lejár, a meglévő bérbeadóval újratárgyaljuk a díjat és a kondíciókat, a futamidőt és a kialakítási hozzájárulást. A költözés lehetősége a legerősebb tárgyalási érv, és mi pontosan tudjuk, mibe kerülne. Sikerdíjas alapon dolgozunk, az elért megtakarítás után.</p>

                    <p><strong><a wire:navigate.hover href="{{ route('budapest.category', ['category' => 'kiado-azonnali-szolgaltatott-irodak']) }}">Szolgáltatott iroda.</a></strong> Bútorozott, azonnal beköltözhető irodák és coworking terek közvetítése, ha a cég néhány főtől akár 50 főig keres helyet, vagy rövid futamidőre tervez.</p>

                    <p><strong><a wire:navigate.hover href="{{ route('elado-irodahazak') }}">Irodaház értékesítés.</a></strong> Eladó irodaházak, irodák és fejlesztési telkek közvetítése Budapesten és környékén, a vevőkeresés és a tárgyalás teljes levezénylésével.</p>

                    <p><strong>Raktár- és ipari ingatlan.</strong> A raktárakat és logisztikai területeket a testvéroldalunkon, a <a href="https://psg-raktarak.hu">psg-raktarak.hu</a>-n közvetítjük.</p>

                    <h2>Így dolgozunk</h2>

                    <p>A budapesti irodaházak tulajdonosai és a kizárólagosan megbízott tanácsadó cégek havonta küldik nekünk az aktuális kínálatukat és díjaikat, ezért <a wire:navigate.hover href="{{ route('rental-fees') }}">az adatlapjainkon szereplő bérleti díjak</a>, üzemeltetési díjak és kiadó területek mindig aktuálisak. Nem egy-egy épületet képviselünk, hanem a teljes piacot látjuk, így a bérlőnek azt az irodát ajánljuk, amelyik az igényeihez a legjobban illik, nem azt, amelyiket éppen bérbe kell adni. A tárgyaláson a teljes futamidő költségét nézzük: a bérleti díj mellett az üzemeltetési díjat, a közös területi szorzót, a parkolást, a bérletmentes időszakot és a kialakítási hozzájárulást is.</p>

                    <h2>Mérföldkövek</h2>

                    <ul>
                        <li><strong>2014:</strong> a Property Solution Group Kft. megalapítása, a PSG Irodaházak indulása</li>
                        <li><strong>2019:</strong> a Netlock 4 780 m²-es központjának bérbeadása a Hungária Centerben</li>
                        <li><strong>2022:</strong> a bérlők oldalán a bérleti szerződések újratárgyalása új szolgáltatásként</li>
                        <li><strong>2025:</strong> a <a href="https://psg-raktarak.hu">psg-raktarak.hu</a> indulása raktár- és ipari ingatlanokra</li>
                    </ul>

                    <h2>Aki mögötte áll</h2>

                    <div class="not-prose flex flex-col sm:flex-row gap-8 items-start">
                        @if ($structuredData->founderPhotoUrl())
                            <a wire:navigate.hover href="{{ route('fekete-richard') }}" class="shrink-0">
                                <img src="{{ $structuredData->founderPhotoUrl() }}" width="240" height="272"
                                    alt="Fekete Richárd, a PSG Irodaházak ügyvezetője" loading="lazy"
                                    class="w-48 h-auto rounded-xl shadow-lg">
                            </a>
                        @endif
                        <div class="space-y-4 text-lg text-gray-700 leading-relaxed">
                            <p>A céget <a wire:navigate.hover href="{{ route('fekete-richard') }}" class="text-accent hover:underline">Fekete Richárd</a> ügyvezető alapította és vezeti, aki 2002 óta dolgozik a budapesti irodapiacon, közgazdász és ingatlangazdálkodási szakközgazdász. Az ügyfelekkel ő tárgyal, a bejárásokon ő van jelen.</p>
                            <p><a wire:navigate.hover href="{{ route('fekete-richard') }}" class="font-semibold text-accent hover:underline">Fekete Richárd bemutatkozása</a></p>
                        </div>
                    </div>

                    <h2>Ügyfeleink</h2>

                    <p>Többek között a Netlock, a KRKA, az Electron Holding, a KMÉ Zrt., a Httpool és a Centrica választott velünk irodát.</p>
                </div>
            </x-glass-panel>
        </x-page-section>

        <x-home.references :references="$this->references" />

        <x-home.testimonials :testimonials="$this->testimonials" />

        <x-page-section spacing="space-y-8">
            <x-glass-panel>
                <div class="prose prose-lg max-w-none p-4 md:p-8 text-gray-700 prose-headings:text-logogray">
                    <h2>Cégadatok</h2>

                    <p>Property Solution Group Kft. · Székhely: 1016 Budapest, Derék u. 2. · Cégjegyzékszám: 01-09-191972 · Adószám: 24963200-2-41 · Telefon: <a href="tel:+36203813917">+36 20 381 3917</a> · E-mail: <a href="mailto:info@psg-irodahazak.hu">info@psg-irodahazak.hu</a> · Ügyvezető: <a wire:navigate.hover href="{{ route('fekete-richard') }}">Fekete Richárd</a></p>
                </div>

                <div class="mt-4 rounded-xl bg-linear-to-r from-accentdark to-accent p-8 text-white text-center space-y-6">
                    <p class="text-lg md:text-xl">Irodát keresel, vagy a meglévő szerződésedet tárgyalnád újra? Írd meg a létszámot és a kívánt kerületet, 24 órán belül küldünk ajánlatot.</p>
                    <button type="button" x-data x-on:click="Livewire.dispatch('open-request-quote-modal')"
                        class="inline-flex items-center px-8 py-3 bg-white text-accentdark font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        Kérek ajánlatot
                    </button>
                </div>
            </x-glass-panel>
        </x-page-section>
    @else
        <x-page-section>
            <x-slot:heading>{{ __('About Us') }}</x-slot:heading>

            <x-glass-panel>
                <div class="p-6">
                    @foreach ($aboutUs as $item)
                        <p class="mb-3 text-gray-600">
                            {!! $item->content !!}<br />
                        </p>
                    @endforeach

                </div>
                <img src="{{ Vite::asset('resources/images/psg_montazs.webp') }}"
                    class="w-full h-auto mt-6 rounded-lg shadow-lg"
                    alt="{{ $aboutUs->first()?->title ?? __('About Us') }}" loading="lazy">
            </x-glass-panel>
        </x-page-section>
    @endif
</div>
