@inject('structuredData', 'App\Services\StructuredDataService')
<x-slot name="title">{{ __('Fekete Richárd, managing director | PSG Irodaházak') }}</x-slot>
<x-slot name="metaDescription">{{ __('Fekete Richárd, managing director of PSG Irodaházak: on the Budapest office market since 2002, more than 250 office lease and sale transactions, over 100,000 m² of office space.') }}</x-slot>
<x-slot name="meta">
    <meta property="og:type" content="profile">
    @if ($structuredData->founderPhotoUrl())
        <meta property="og:image" content="{{ $structuredData->founderPhotoUrl() }}">
    @endif
    {{ $structuredData->toScript($structuredData->profilePage(route('fekete-richard'))) }}
</x-slot>

<div>
    <x-page-section spacing="space-y-8">
        <x-slot:heading>{{ __('Fekete Richárd, managing director') }}</x-slot:heading>

        <x-glass-panel>
            <article class="p-4 md:p-8 grid grid-cols-1 lg:grid-cols-3 gap-10">
                @if ($structuredData->founderPhotoUrl())
                    <div>
                        <img src="{{ $structuredData->founderPhotoUrl() }}" width="1200" height="1360"
                            alt="{{ __('Fekete Richárd, managing director of PSG Irodaházak') }}"
                            class="w-full h-auto rounded-xl shadow-lg lg:sticky lg:top-8">
                    </div>
                @endif

                <div @class(['prose prose-lg max-w-none text-gray-700 prose-a:text-accent prose-headings:text-logogray', 'lg:col-span-2' => $structuredData->founderPhotoUrl(), 'lg:col-span-3' => ! $structuredData->founderPhotoUrl()])>
                    <p class="lead">{{ __('Fekete Richárd is the founder and managing director of PSG Irodaházak, working on the Budapest office market since 2002: helping companies find offices, negotiate and renegotiate leases, and sell office buildings. In recent years, more than 250 lease and sale transactions led from start to finish, covering over 100,000 m² of office space in total. Economist and real estate management economist by training.') }}</p>

                    <h2>{{ __('Career') }}</h2>

                    <p>{!! __('Career start in 2002 at Tömb Ingatlanhasznosító Kft., working on the letting of office buildings. From 2003 to 2014 an office leasing consultant at B.G. Property, leading lettings over those eleven years in every submarket of the Budapest office market, from the city centre through Váci út to South Buda. In 2014 founded Property Solution Group Kft., whose office leasing and consultancy brand is PSG Irodaházak. Since 2022 the company has also renegotiated leases on the tenants\' side, and in 2025 it added the sister site <a href="https://psg-raktarak.hu">psg-raktarak.hu</a> for warehouse and industrial property brokerage.') !!}</p>

                    <h2>{{ __('How I work') }}</h2>

                    <blockquote>
                        <p>{{ __('“Every office search starts with a calculation, not a viewing. First we look at how many people, in what working pattern, with how many meeting rooms and how much reserve the company will work, and that tells us how many square metres it needs. The planned moving date matters too: if there is no time for a major refurbishment, then based on the floor plans we request, we only offer options whose turnkey condition fits the company\'s moving plans. Only then do we look for a building. At the viewing we see the five or six best options with the client, and we prepare a seating plan for every shortlisted office so the client can see how the team fits and how many m² cover the needs. In the negotiation it is not only the rent per square metre that counts but the whole lease structure, the termination conditions and the hidden costs as well. With every client the goal is satisfaction, and that we come to mind again at a renegotiation or a future move.”') }}</p>
                    </blockquote>

                    <h2>{{ __('Deals I am proud of') }}</h2>

                    <ul>
                        <li>{!! __('<strong>Netlock, Hungária Center, 4,780 m² (2019).</strong> Relocating the company\'s entire Budapest headquarters to a multi-level space of more than 4,500 m², negotiating the terms of the lease and the fit-out.') !!}</li>
                        <li>{!! __('<strong>Terrapark Next building A, 10,000 m², sale.</strong> The Budaörs office building found a buyer in two and a half months, with the whole sales process managed, in competition with other agents.') !!}</li>
                        <li>{!! __('<strong>KMÉ Zrt., Olympia office building, 1,550 m².</strong> Leasing an entire floor, with a fit-out tailored to the tenant\'s needs.') !!}</li>
                        <li>{!! __('<strong>Electron Holding, Margit Palace, about 2,000 m².</strong> Selecting a Buda headquarters and negotiating the lease terms in the office building on Margit körút.') !!}</li>
                        <li>{!! __('<strong>Httpool, Bank Center, 250–300 m².</strong> Selecting the city centre office of an international company in one of the premium buildings of District V, from enquiry to signing in 2.5 months.') !!}</li>
                    </ul>

                    <p>{!! __('Other clients include KRKA (Gateway Office Park) and Centrica. Client testimonials can be read on the <a wire:navigate.hover href=":url">home page</a>.', ['url' => route('home')]) !!}</p>

                    <h2>{{ __('Education') }}</h2>

                    <ul>
                        <li>{{ __('Economist, Budapest Business University') }}</li>
                        <li>{{ __('Real estate management economist, Budapest University of Technology and Economics') }}</li>
                    </ul>

                    <h2>{{ __('Topics I like to talk about') }}</h2>

                    <p>{!! __('Regular briefings and articles on the Budapest office market: rent trends, operating fees, the pitfalls of lease agreements, the office needs of hybrid working, and serviced offices compared with conventional leases. For press enquiries, interviews or talks, reachable via the <a wire:navigate.hover href=":url">contact page</a> or on <a href="https://www.linkedin.com/in/richard-fekete-17371943/" rel="noopener" target="_blank">LinkedIn</a>.', ['url' => route('kapcsolat')]) !!}</p>

                    <p class="not-prose mt-10 rounded-xl bg-logogray/10 p-6 text-gray-800">
                        {{ __('Fekete Richárd, managing director') }} · Property Solution Group Kft. ·
                        <a href="tel:+36203813917" class="hover:text-accent">+36 20 381 3917</a> ·
                        <a href="mailto:info@psg-irodahazak.hu" class="hover:text-accent">info@psg-irodahazak.hu</a> ·
                        <a href="https://www.linkedin.com/in/richard-fekete-17371943/" rel="noopener" target="_blank" class="text-accent hover:underline">LinkedIn</a>
                    </p>
                </div>
            </article>
        </x-glass-panel>
    </x-page-section>
</div>
