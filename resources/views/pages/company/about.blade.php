@inject('structuredData', 'App\Services\StructuredDataService')
@if (app()->getLocale() === 'hu')
    <x-slot name="title">{{ __('About us: PSG Irodaházak, office leasing in Budapest since 2014') }}</x-slot>
    <x-slot name="metaDescription">{{ __('PSG Irodaházak (Property Solution Group Kft.) has been helping companies find offices in Budapest since 2014. The offer of 230 office buildings, 250+ contracts, a quote within 24 hours, free of charge for the tenant.') }}</x-slot>
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
            <x-slot:heading>{{ __('About us: PSG Irodaházak') }}</x-slot:heading>

            <x-glass-panel>
                <div class="prose prose-lg max-w-none p-4 md:p-8 text-gray-700 prose-a:text-accent prose-headings:text-logogray">
                    <p class="lead">{{ __('PSG Irodaházak is the office leasing and real estate consultancy brand of Property Solution Group Kft. Since 2014 we have been helping companies find offices in Budapest, negotiate and renegotiate leases, sell office buildings or find warehouses. We manage the current offer of 230 Budapest office buildings, which covers almost all Class A office buildings. We send a quote within 24 hours, and our brokerage is free of charge for tenants, except for tenant representation mandates.') }}</p>

                    <h2>{{ __('PSG Irodaházak in numbers') }}</h2>

                    <ul>
                        <li>{!! __('<strong>230 office buildings</strong> on offer in our database, with about 4 million m² of office space in total') !!}</li>
                        <li>{!! __('<strong>16 years</strong> of office market experience in every submarket of Budapest') !!}</li>
                        <li>{!! __('<strong>More than 250</strong> lease and sale contracts signed') !!}</li>
                        <li>{!! __('<strong>Over 100,000 m²</strong> of Class A office space leased') !!}</li>
                        <li>{!! __('<strong>24 hours:</strong> the most it takes us to send a quote for your requirements') !!}</li>
                    </ul>

                    <h2>{{ __('What we do') }}</h2>

                    <p>{!! __('<strong><a wire:navigate.hover href=":url">Office search.</a></strong> We assess headcount, working patterns and budget, calculate the space needed from these, and present five to seven options from the offer of 230 office buildings. We organise the viewings, have seating plans made for the shortlisted offices, and negotiate the lease with the tenant\'s interests in mind. The service is free of charge for the tenant.', ['url' => route('kiado-irodak')]) !!}</p>

                    <p>{!! __('<strong>Lease renegotiation.</strong> When the lease expires, we renegotiate the rent and terms, the lease term and the fit-out contribution with the current landlord. The option to move is the strongest negotiating argument, and we know exactly what it would cost. We work on a success fee basis, based on the savings achieved.') !!}</p>

                    <p>{!! __('<strong><a wire:navigate.hover href=":url">Serviced office.</a></strong> Brokerage of furnished, ready-to-move-in offices and coworking spaces, when a company is looking for space for a few people up to 50, or plans for a short term.', ['url' => route('budapest.category', ['category' => 'kiado-azonnali-szolgaltatott-irodak'])]) !!}</p>

                    <p>{!! __('<strong><a wire:navigate.hover href=":url">Office building sales.</a></strong> Brokerage of office buildings, offices and development sites for sale in Budapest and its surroundings, managing the whole buyer search and negotiation.', ['url' => route('elado-irodahazak')]) !!}</p>

                    <p>{!! __('<strong>Warehouse and industrial property.</strong> Warehouses and logistics space are brokered on our sister site, <a href="https://psg-raktarak.hu">psg-raktarak.hu</a>.') !!}</p>

                    <h2>{{ __('How we work') }}</h2>

                    <p>{!! __('The owners of Budapest office buildings and the consultancies with exclusive mandates send us their current offer and fees every month, so <a wire:navigate.hover href=":url">the rents on our data sheets</a>, operating fees and available areas are always up to date. We do not represent individual buildings but see the whole market, so we recommend the office that best fits the tenant\'s needs, not the one that happens to need letting. In negotiations we look at the cost over the whole lease term: besides the rent, the operating fee, the common area factor, parking, the rent-free period and the fit-out contribution.', ['url' => route('rental-fees')]) !!}</p>

                    <h2>{{ __('Milestones') }}</h2>

                    <ul>
                        <li>{!! __('<strong>2014:</strong> Property Solution Group Kft. founded, PSG Irodaházak launched') !!}</li>
                        <li>{!! __('<strong>2019:</strong> leasing the 4,780 m² headquarters of Netlock in Hungária Center') !!}</li>
                        <li>{!! __('<strong>2022:</strong> lease renegotiation on the tenants\' side as a new service') !!}</li>
                        <li>{!! __('<strong>2025:</strong> launch of <a href="https://psg-raktarak.hu">psg-raktarak.hu</a> for warehouse and industrial property') !!}</li>
                    </ul>

                    <h2>{{ __('Who is behind it') }}</h2>

                    <div class="not-prose flex flex-col sm:flex-row gap-8 items-start">
                        @if ($structuredData->founderPhotoUrl())
                            <a wire:navigate.hover href="{{ route('fekete-richard') }}" class="shrink-0">
                                <img src="{{ $structuredData->founderPhotoUrl() }}" width="240" height="272"
                                    alt="{{ __('Fekete Richárd, managing director of PSG Irodaházak') }}" loading="lazy"
                                    class="w-48 h-auto rounded-xl shadow-lg">
                            </a>
                        @endif
                        <div class="space-y-4 text-lg text-gray-700 leading-relaxed">
                            <p>{!! __('The company was founded and is managed by managing director <a wire:navigate.hover href=":url" class="text-accent hover:underline">Fekete Richárd</a>, on the Budapest office market since 2002, economist and real estate management economist. Fekete Richárd personally negotiates with clients and attends the viewings.', ['url' => route('fekete-richard')]) !!}</p>
                            <p><a wire:navigate.hover href="{{ route('fekete-richard') }}" class="font-semibold text-accent hover:underline">{{ __('About Fekete Richárd') }}</a></p>
                        </div>
                    </div>

                    <h2>{{ __('Our clients') }}</h2>

                    <p>{{ __('Our clients who chose an office with us include Netlock, KRKA, Electron Holding, KMÉ Zrt., Httpool and Centrica.') }}</p>
                </div>
            </x-glass-panel>
        </x-page-section>

        <x-home.references :references="$this->references" />

        <x-home.testimonials :testimonials="$this->testimonials" />

        <x-page-section spacing="space-y-8">
            <x-glass-panel>
                <div class="prose prose-lg max-w-none p-4 md:p-8 text-gray-700 prose-headings:text-logogray">
                    <h2>{{ __('Company details') }}</h2>

                    <p>{!! __('Property Solution Group Kft. · Registered office: 1016 Budapest, Derék u. 2. · Company registration number: 01-09-191972 · Tax number: 24963200-2-41 · Phone: <a href="tel:+36203813917">+36 20 381 3917</a> · Email: <a href="mailto:info@psg-irodahazak.hu">info@psg-irodahazak.hu</a> · Managing director: <a wire:navigate.hover href=":url">Fekete Richárd</a>', ['url' => route('fekete-richard')]) !!}</p>
                </div>

                <div class="mt-4 rounded-xl bg-linear-to-r from-accentdark to-accent p-8 text-white text-center space-y-6">
                    <p class="text-lg md:text-xl">{{ __('Looking for an office, or want to renegotiate your current lease? Tell us the headcount and the district you want, and we will send a quote within 24 hours.') }}</p>
                    <button type="button" x-data x-on:click="Livewire.dispatch('open-request-quote-modal')"
                        class="inline-flex items-center px-8 py-3 bg-white text-accentdark font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        {{ __('I\'d like a quote') }}
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
