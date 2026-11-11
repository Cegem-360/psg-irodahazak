@inject('structuredData', 'App\Services\StructuredDataService')
@use('App\Livewire\Pages\Office\RentalFees')
<x-slot name="title">{{ __('Office rents in Budapest 2026: fee bands per submarket | PSG Irodaházak') }}</x-slot>
<x-slot name="metaDescription">{{ RentalFees::description() }}</x-slot>
<x-slot name="meta">
    {{ $structuredData->toScript($structuredData->authoredArticle(RentalFees::headline(), RentalFees::description(), route('rental-fees'), $published, $lastUpdated)) }}
    {{ $structuredData->toScript($structuredData->faqPage($this->faqs())) }}
</x-slot>

<div>
    <x-page-section spacing="space-y-8">
        <x-slot:heading>{{ RentalFees::headline() }}</x-slot:heading>

        <x-glass-panel>
            <article class="prose prose-lg max-w-none p-4 md:p-8 text-gray-700 prose-a:text-accent prose-headings:text-logogray">
                <p class="text-sm text-gray-500">
                    {{ __('Last updated:') }} <time datetime="{{ $lastUpdated->toDateString() }}">{{ $lastUpdated->year }}. {{ $lastUpdated->locale('hu')->translatedFormat('F') }}</time>
                </p>

                <p>{{ __('In autumn 2026 the rent of an office building in Budapest ranges from 7 to 28 EUR/m²/month, with a typical value of 15.5 EUR/m²/month. Our offer consists almost entirely of Class A office buildings; the bottom of the range comes from a few older, Class B buildings. The most expensive submarket is the city centre (Districts V, VI and VII), with a median of 18 EUR/m², while premium buildings offer office space at around 25–28 EUR/m²/month. The largest offer is in the Váci út office corridor (District XIII), with a median of 15 EUR. On top of the rent come the operating fee (typically 2,300–3,200 HUF or 5–7 EUR/m²/month) and the parking fee (100–180 EUR/space/month). The figures below come from the 230 Budapest office building data sheets of PSG Irodaházak: 198 office buildings are priced per square metre and 29 serviced offices per workstation; as of 6 November 2026.') }}</p>

                <h2>{{ __('Rents per submarket') }}</h2>

                <div class="not-prose overflow-x-auto">
                    <table class="data-table w-full min-w-[720px] text-left text-sm md:text-base border-collapse">
                        <thead class="bg-logogray/10 text-gray-900">
                            <tr>
                                <th scope="col" class="p-3 font-semibold">{{ __('Submarket') }}</th>
                                <th scope="col" class="p-3 font-semibold">{{ __('Office buildings in the calculation') }}</th>
                                <th scope="col" class="p-3 font-semibold">{{ __('Asking rent (EUR/m²/month)') }}</th>
                                <th scope="col" class="p-3 font-semibold">{{ __('Median') }}</th>
                                <th scope="col" class="p-3 font-semibold">{{ __('Operating fee (median)') }}</th>
                                <th scope="col" class="p-3 font-semibold">{{ __('Parking (median)') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($this->submarkets() as $row)
                                <tr @class(['border-t border-gray-200', 'font-semibold bg-logogray/5' => $loop->last])>
                                    <th scope="row" class="p-3 font-medium text-gray-900">{{ $row['submarket'] }}</th>
                                    <td class="p-3">{{ $row['buildings'] }}</td>
                                    <td class="p-3 whitespace-nowrap">{{ $row['range'] }}</td>
                                    <td class="p-3">{{ $row['median'] }}</td>
                                    <td class="p-3">{{ $row['operating_fee'] }}</td>
                                    <td class="p-3 whitespace-nowrap">{{ $row['parking'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <p class="text-sm text-gray-500">{{ __('Source: the 230 office building data sheets of PSG Irodaházak, 6 November 2026. The fee bands are calculated from the 198 office buildings priced per square metre (EUR/m²/month); the per-workstation prices of serviced offices are listed separately. The median is the median of the midpoints of the fee bands. Some landlords give the operating fee in forints and others in euros; we have not converted between the two. All fees are net, excluding VAT.') }}</p>

                <p>{{ __('The bands are wide because the same submarket includes both a BREEAM-certified office building handed over in 2023 and a twenty-year-old building awaiting refurbishment. The real basis for comparison is therefore not the location but the age and quality of the building and the size of the leasable area. The median for BREEAM or LEED certified office buildings is 16.3 EUR, for non-certified ones 15.25 EUR/m²/month.') }}</p>

                <h2>{{ __('City centre: Districts V, VI and VII') }}</h2>

                <p>{{ __('Our database includes the offer of 42 office buildings in the city centre, with rents between 11.5 and 28 EUR/m²/month. The top of the range comes from the premium buildings of District V: Roosevelt office building offers space at 26–28, Academia office building at 25–27 and Bank Center at 22–25 EUR/m²/month, while in District VI Eiffel Square ranges between 21.5 and 26 EUR/m². District V alone is the most expensive district in Budapest, with a median of 22.5 EUR. In Districts VI and VII, especially outside the Grand Boulevard, good-condition refurbished office buildings can be found for 13–17 EUR. Parking is also the most expensive in the city centre, 170–220 EUR/space/month in premium buildings, and the number of parking spaces is limited.') }}</p>

                <p>{{ __('Related listings:') }} {!! $this->categoryLink('kiado-belvarosi-irodak', __('offices for rent in the city centre')) !!}, {!! $this->categoryLink('kiado-irodak-v-kerulet', __('offices for rent in District V')) !!}.</p>

                <h2>{{ __('Váci út office corridor: District XIII') }}</h2>

                <p>{{ __('District XIII is the largest office market in Budapest: our database includes 53 office buildings with more than 137,000 m² of space currently available for rent. Asking rents range from 7.5 to 23 EUR/m²/month, with a median of 15 EUR/m², and 16 EUR/m² for buildings directly on Váci út. The highest rents are in new or fully refurbished buildings: Agora Tower 17–23, CenterPoint 3, handed over in 2025, 20–22, Duna Tower 18.5–21.9 and WestEnd Business Center 19–21 EUR/m²/month. In the inner parts of the district, further from the metro, good quality space is available for 10–12 EUR. The operating fee is the most favourable here, with a median of 2,375 HUF/m²/month, and this is also where most green-certified buildings are: almost half of the district\'s office buildings hold a BREEAM or LEED certificate.') }}</p>

                <p>{{ __('Related listings:') }} {!! $this->categoryLink('kiado-vaci-uti-irodak', __('offices for rent on Váci út')) !!}.</p>

                <h2>{{ __('South Buda: Districts XI and XXII') }}</h2>

                <p>{{ __('We hold the data sheets of 30 office buildings in South Buda, with rents between 9.25 and 21 EUR/m²/month and a median of 14.5 EUR. The top of the range comes from Budapest ONE (20.5–21 EUR), Allee Corner (19.5–20 EUR) and the BudaPart buildings (18–19.5 EUR); around Infopark and Lágymányosi út 13–16 EUR is typical, and in the southern part of the district there is offer for 10–11 EUR as well. Parking is cheaper than the Budapest average, with a median of 100 EUR/space/month, and most buildings have both surface and underground parking. This submarket serves technology companies and large customer service centres, where contiguous areas of over 2,000 m² are also available.') }}</p>

                <p>{{ __('Related listings:') }} {!! $this->categoryLink('kiado-irodak-xi-kerulet', __('offices for rent in District XI')) !!}.</p>

                <h2>{{ __('Buda: Districts I, II, III and XII') }}</h2>

                <p>{{ __('Our database includes the offer of 41 office buildings in the other districts of Buda, with the widest range: from 7 to 27 EUR/m²/month. District XII is the most expensive part of Buda, with a median of 19.9 EUR; Major Udvar, handed over in 2022, offers space for 24.5–27 EUR. In District II the area around Margit körút and Millenáris is in demand: BEM Center 23–24.5, Canada Square 22 and Millenáris Avantgarde 20–22 EUR/m²/month. District III is the Buda submarket with the most favourable rents, with a median of 14.2 EUR, where space is available for 7–9 EUR in the office buildings of the Óbuda industrial areas. Buda typically has smaller buildings of 500–3,000 m², so in the inner Buda districts the offer of 200–300 m² offices is the largest.') }}</p>

                <p>{{ __('Related listings:') }} {!! $this->categoryLink('kiado-budai-irodak', __('offices for rent in Buda')) !!}, {!! $this->categoryLink('kiado-bel-budai-irodak', __('offices for rent in inner Buda')) !!}.</p>

                <h2>{{ __('Other districts of Pest: VIII, IX, X, XIV') }}</h2>

                <p>{{ __('Outside the city centre and Váci út, we hold the offer of 34 office buildings on the Pest side, between 7 and 22 EUR/m²/month, with a median of 15 EUR. Corvin Quarter pulls the median of District VIII up to 17.5 EUR: Corvin Palace 18–22, Corvin Innovation Campus 19–20 and Corvin Skypark 18–19 EUR/m²/month. District IX is mixed: the new buildings around Soroksári út and Mill Park ask 17–21 EUR, while some Millennium Towers buildings offer space for 9.5 EUR, though without a fit-out contribution, and the district also has the largest amount of available space, 69,000 m². In District XIV the range is 11.5–15.5 EUR, and in District X we have two mandates.') }}</p>

                <p>{{ __('Related listings:') }} {!! $this->categoryLink('kiado-pesti-irodak', __('offices for rent in Pest')) !!}.</p>

                <h2>{{ __('What comes on top of the rent?') }}</h2>

                <p>{{ __('The rent on the office building data sheets is the rent for the net area. The actual monthly cost is higher because four items are added to it.') }}</p>

                <ul>
                    <li>{!! __('<strong>Operating costs.</strong> In Budapest typically 2,300–3,200 HUF/m²/month or 5–7 EUR/m²/month, covering cleaning of the common areas, reception and security, maintenance of the lifts and building services, insurance and building management, as well as most of the utility costs of the premises (including heating, cooling, water and sewage) and municipal waste collection. The landlord settles it annually on an open-book basis; however, if utility prices rise during the year, the operating fee may increase too. The operating fee is highest in the city centre (median 2,845 HUF/m²) and lowest on Váci út (2,375 HUF/m²).') !!}</li>
                    <li>{!! __('<strong>Common area factor.</strong> Rent is paid not only for your own office but also, proportionally, for the common areas (corridors, staircase, lobby, lift lobby), calculated on the total area. According to our data sheets it ranges from 2 to 17%, with a median of 7.2% and a typical band of 5–10%. With an 8% factor, a 500 m² office “grows” to 540 m²: this is the gross area on which the rent and operating costs are paid.') !!}</li>
                    <li>{!! __('<strong>Parking.</strong> In Budapest 100–180 EUR/space/month is typical, 220 EUR in premium city centre buildings. The number of parking spaces depends on the building: in the city centre there is one space per 90–100 m² of office space, in the outer districts and new buildings one per 50–75 m².') !!}</li>
                    <li>{!! __('<strong>VAT and security.</strong> All fees given are net amounts, plus 27% VAT. At signing, landlords typically ask for a deposit or bank guarantee equal to 3–6 months of rent and operating fee, the amount of which is set after a credit check of the tenant company. This is a one-off but significant item in the tenant\'s budget. The landlord returns the deposit at the end of the lease if the tenant did not secure it with a bank guarantee.') !!}</li>
                </ul>

                <p>{{ __('An example: a 500 m² office on Váci út at 16 EUR/m²/month with an 8% common area factor, an operating fee of 2,400 HUF and 6 parking spaces means a net monthly rent of 8,640 EUR, an operating fee of about 1.3 million HUF and a parking fee of 720 EUR. The rent is therefore roughly two thirds of the total monthly cost.') }}</p>

                <h2>{{ __('Asking rent and actual rent: why don\'t you pay what is on the data sheet?') }}</h2>

                <p>{{ __('The value on the data sheets is the landlord\'s asking rent. The rent actually paid, the so-called effective rent, may be lower depending on the negotiation, because on a 5 year lease landlords typically try to win tenants with three tools: rent-free months at the start of the term or on anniversaries; a fit-out contribution towards the fit-out costs; and, more rarely, a direct reduction of the headline rent, which is not significant because of the annual revaluation of the buildings. A new turnkey fit-out of a previously fitted-out office costs 600–800 EUR/m² in 2026, so the size of the fit-out contribution often matters more than one or two euros off the rent per square metre. The outcome of the negotiation largely depends on the building\'s vacancy, the size of the leased area and the lease term: a 5 year lease of over 1,000 m² leaves considerably more room for negotiation than a 3 year lease of a 200 m² unit.') }}</p>

                <h2>{{ __('Serviced offices and coworking: EUR/person/month') }}</h2>

                <p>{!! __('Furnished, ready-to-move-in serviced offices are priced per workstation, not per square metre, as a package price. The 29 Budapest serviced office offers in our database range from 150 to 550 EUR/person/month, with a median of 370 EUR. This includes the operating fee, use of furniture, internet, reception services, part of the meeting room use and office cleaning, so the two types (conventional and serviced office) cannot be compared directly. In our experience, above 12–15 people a conventional office lease is more favourable if the company can commit for at least 3 years and its headcount does not grow rapidly every year. You can find the offer on the :link page.', ['link' => $this->categoryLink('kiado-azonnali-szolgaltatott-irodak', __('serviced offices for rent with immediate availability'))]) !!}</p>

                <h2>{{ __('Lease term and minimum area') }}</h2>

                <p>{{ __('Most Budapest office buildings expect a minimum lease term of 3 or 5 years: according to our data sheets 105 buildings ask for 5 years, 81 for 3 years, 30 for 1 year and 9 for 2 years. A shorter, 1 year lease is typically available in serviced offices or in office buildings where the owner does not provide a fit-out for new tenants. The median minimum leasable area is 268 m², but the offer starts at 50 m², and in large buildings whole floors of 1,500–3,000 m² can be leased in one piece.') }}</p>

                <h2>{{ __('Fekete Richárd\'s assessment of the autumn 2026 market') }}</h2>

                <blockquote>
                    <p>{{ __('“Premium office buildings in the city centre ask 23–25 euros/m², and over the past year we have seen a 3–4% increase in good quality buildings. The market has split: in new or technically refurbished, green-certified buildings landlords hold their rent levels, while in older buildings it is easier to get into a better negotiating position. This is where a real estate consultant comes in who has insight into the market segment and, based on past experience, can support the client looking for an office so that the long-term decision is not regretted even after 1–1.5 years, but the work and cooperation invested are seen to pay off. Anyone looking for an office in 2026–27 should, among several factors, also weigh the operating costs, not just the rent per square metre.”') }}</p>
                </blockquote>

                <p>{!! __('<a wire:navigate.hover href=":url">Fekete Richárd</a>, managing director, PSG Irodaházak', ['url' => route('fekete-richard')]) !!}</p>

                <h2>{{ __('Frequently asked questions') }}</h2>

                @foreach ($this->faqs() as $faq)
                    <h3>{{ $faq['question'] }}</h3>
                    <p>{{ $faq['answer'] }}</p>
                @endforeach

                <div class="not-prose mt-12 rounded-xl bg-linear-to-r from-accentdark to-accent p-8 text-white text-center space-y-6">
                    <p class="text-lg md:text-xl">{{ __('If you are looking for current rents for a specific building or submarket, we will send a quote within 24 hours for the area and headcount you specify, including not only the asking rent but also the operating costs and parking.') }}</p>
                    <button type="button" x-data x-on:click="Livewire.dispatch('open-request-quote-modal')"
                        class="inline-flex items-center px-8 py-3 bg-white text-accentdark font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        {{ __('I\'d like a quote') }}
                    </button>
                </div>
            </article>
        </x-glass-panel>
    </x-page-section>
</div>
