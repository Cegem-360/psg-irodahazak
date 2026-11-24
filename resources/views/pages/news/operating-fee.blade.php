@inject('structuredData', 'App\Services\StructuredDataService')
@use('App\Livewire\Pages\News\OperatingFee')
<x-slot name="title">{{ __('Operating fee in office leasing: how much is it in Budapest in 2026? | PSG Irodaházak') }}</x-slot>
<x-slot name="metaDescription">{{ OperatingFee::description() }}</x-slot>
<x-slot name="meta">
    <meta property="og:type" content="article">
    <meta property="article:published_time" content="{{ $published->toDateString() }}">
    <meta property="article:modified_time" content="{{ $lastUpdated->toDateString() }}">
    <meta property="article:author" content="{{ route('fekete-richard') }}">
    {{ $structuredData->toScript($structuredData->authoredArticle(OperatingFee::headline(), OperatingFee::description(), route('operating-fee'), $published, $lastUpdated)) }}
    {{ $structuredData->toScript($structuredData->faqPage($this->faqs())) }}
</x-slot>

<div>
    <x-page-section spacing="space-y-8">
        <x-slot:heading>{{ OperatingFee::headline() }}</x-slot:heading>

        <x-glass-panel>
            <article class="prose prose-lg max-w-none p-4 md:p-8 text-gray-700 prose-a:text-accent prose-headings:text-logogray">
                <p class="text-sm text-gray-500">
                    {{ __('Published:') }} <time datetime="{{ $published->toDateString() }}">{{ $published->locale('hu')->translatedFormat('Y. F j.') }}</time>
                </p>

                <p>{{ __('The operating fee is the monthly amount paid on top of the rent that covers the common costs of the office building. In Budapest in autumn 2026 it is typically 2,200–2,850 HUF/m²/month, with a median of 2,500 HUF/m²/month, and 5–6.5 EUR/m²/month in buildings priced in euros. This is roughly 40% of the rent: with a rent of 15.5 EUR per square metre, the operating fee adds about 6 EUR to every square metre. The fee covers reception, security, cleaning of the common areas, maintenance of the building services, insurance and building management, and in most Budapest office buildings also the heating, cooling and water consumption of the premises. The landlord settles it annually, in arrears, on an open-book basis, so the actual amount may differ at the end of the year from the advance paid monthly. The figures come from the 230 Budapest office building data sheets of PSG Irodaházak.') }}</p>

                <h2>{{ __('What does the operating fee include?') }}</h2>

                <p>{{ __('The operating fee of Budapest office buildings covers the following items. The exact list differs from building to building, so an itemised list is always attached to the lease, and it is worth reading before signing.') }}</p>

                <ul>
                    <li>{!! __('<strong>Common areas:</strong> cleaning, lighting, heating and cooling of the lobby, corridors, staircases, lift lobbies and toilets.') !!}</li>
                    <li>{!! __('<strong>Reception and security:</strong> the 24-hour reception service, security guarding, and the operation of the access control and camera systems.') !!}</li>
                    <li>{!! __('<strong>Building services:</strong> maintenance of the lifts, the ventilation and air conditioning system, the heating and cooling equipment, the fire alarm and the sprinklers, and the mandatory official inspections.') !!}</li>
                    <li>{!! __('<strong>Most of the utility costs of the premises:</strong> in most Budapest office buildings the heating, cooling and water consumption of the leased area, as well as municipal waste collection, are also included in the operating fee.') !!}</li>
                    <li>{!! __('<strong>Building management and insurance:</strong> the fee of the facility management company, the property insurance of the building, gardening, snow clearing, and maintenance of the facade and the roof.') !!}</li>
                </ul>

                <p>{{ __('In serviced offices and coworking spaces there is no separate operating fee: the package price per workstation includes it, together with furniture, internet and cleaning.') }}</p>

                <h2>{{ __('What is not included?') }}</h2>

                <p>{{ __('Three items are almost always paid by the tenant on top of the operating fee, and they have to be budgeted separately.') }}</p>

                <ul>
                    <li>{!! __('<strong>The premises\' own electricity consumption:</strong> the tenant pays separately, based on a sub-meter, for the electricity of lighting, computers, the kitchen and the server room.') !!}</li>
                    <li>{!! __('<strong>Internet and telephone:</strong> the tenant\'s own contract with a provider; the office building only provides the connection.') !!}</li>
                    <li>{!! __('<strong>Cleaning of the premises:</strong> the tenant orders the daily cleaning of its own office; the operating fee covers the common areas. In some buildings the facility manager undertakes this too, for a separate fee.') !!}</li>
                </ul>

                <p>{{ __('Parking is not part of the operating fee either; in Budapest it is a separate item of 100–180 EUR/space/month, and neither is the 27% VAT, which is added to every fee.') }}</p>

                <h2>{{ __('How much is the operating fee in Budapest in 2026?') }}</h2>

                <p>{{ __('On the data sheets of PSG Irodaházak some landlords give the operating fee in forints and others in euros; we have not converted between the two, because most forint fees are fixed, while the euro fees change with the exchange rate.') }}</p>

                <div class="not-prose overflow-x-auto">
                    <table class="data-table w-full min-w-[640px] text-left text-sm md:text-base border-collapse">
                        <thead class="bg-logogray/10 text-gray-900">
                            <tr>
                                <th scope="col" class="p-3 font-semibold">{{ __('Submarket') }}</th>
                                <th scope="col" class="p-3 font-semibold">{{ __('Operating fee (HUF/m²/month, median)') }}</th>
                                <th scope="col" class="p-3 font-semibold">{{ __('Operating fee (EUR/m²/month, median)') }}</th>
                                <th scope="col" class="p-3 font-semibold">{{ __('Rent median (EUR/m²/month)') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($this->submarkets() as $row)
                                <tr @class(['border-t border-gray-200', 'font-semibold bg-logogray/5' => $loop->last])>
                                    <th scope="row" class="p-3 font-medium text-gray-900">{{ $row['submarket'] }}</th>
                                    <td class="p-3 whitespace-nowrap">{{ $row['huf'] }}</td>
                                    <td class="p-3">{{ $row['eur'] }}</td>
                                    <td class="p-3">{{ $row['rent'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <p class="text-sm text-gray-500">{{ __('Source: the office building data sheets of PSG Irodaházak, 131 office buildings priced in forints and 66 in euros, 6 November 2026. All fees are net.') }}</p>

                <p>{{ __('Forint fees range from 1,100 to 4,500 HUF/m²/month; half of the office buildings are between 2,200 and 2,850 HUF. The highest operating fees are in premium city centre buildings and in offices attached to shopping centres: Deák Palota 4,514 and the MOM Park offices 4,025 HUF/m²/month. The lowest are in smaller buildings with simpler building services: Emke office building 1,527 and Olympia office building 1,650 HUF/m²/month. In the lower band it is worth checking whether the consumption of the premises is metered separately, because where all consumption goes through sub-meters, the operating fee is low, but the utility costs come on top. Buildings priced in euros are between 4 and 8 EUR, with a median of 6 EUR.') }}</p>

                <p>{{ __('Two things in the data may be surprising. One is that the operating fee of new buildings is not higher than that of old ones: the median of buildings handed over after 2018 is 2,425 HUF, that of buildings from before 2005 is 2,590 HUF/m²/month, because modern building services use less energy and are cheaper to maintain. The other is that a BREEAM or LEED certificate does not mean a lower operating fee, although we would expect it to: the certification assesses the sustainability and environmental performance of the building, so a certified building should be more energy-efficient and cheaper to run. This does not show in the figures: the median of certified buildings is 2,475, that of the others 2,520 HUF, a negligible difference. The fee is determined far more by the location of the building, the level of reception and security, and the size of the common areas than by the certificate.') }}</p>

                <h2>{{ __('How is the operating fee settled?') }}</h2>

                <p>{{ __('The operating fee paid monthly is an advance. At the end of the year, typically in the first quarter of the following year, the landlord settles the actual costs item by item: if they were higher than the advance, the tenant pays the difference afterwards; if lower, the landlord credits it. This is called open-book settlement, because the tenant may inspect the invoices. This is the practice in Class A office buildings in Budapest, and it is stipulated in the lease.') }}</p>

                <p>{{ __('Three things are worth checking in the lease. The first is which items may be charged: the landlord\'s own investments (for example a new HVAC system or another building services investment) or the landlord\'s ownership costs may not be part of the operating fee. The second is whether there is a cap or indexation: in some leases the operating fee may rise by at most the inflation rate each year, in others there is no cap, and a rise in utility costs can be passed on in full. The third is whether the tenant has the right to have the settlement audited, and within what deadline it may object. For a 1,000 m² office a difference of 300 HUF/m² between the advance and the actual fee is 3.6 million HUF a year, so this is not a formality.') }}</p>

                <h2>{{ __('What can be negotiated about the operating fee?') }}</h2>

                <p>{{ __('The operating fee is less negotiable than the rent, because it covers actual costs, but it is not untouchable. Landlords typically give way on three points: freezing the operating fee for the first one or two years, or an inflation cap for the whole term; extending the rent-free period to the operating fee as well, not only to the rent; and narrowing the range of chargeable items in the annex of the lease. For larger tenants, above 1,000 m², the landlord sometimes undertakes a fixed operating fee for the whole term. These conditions come up at the end of the negotiation, after the rent, so it is worth asking about them already in the request for proposal.') }}</p>

                <h2>{{ __('Fekete Richárd\'s experience') }}</h2>

                <blockquote>
                    <p>{{ __('“Clients see the rent and the discounts on it as the subject of the bargain, and take the operating fee as given, although it is a third to a quarter of the total monthly cost. Between two buildings with the same rent, the difference in operating fee on 1,000 m² can be several million forints a year, so for the shortlisted offices we always compare the total cost over the whole lease term, not just the rent per square metre.”') }}</p>
                </blockquote>

                <p>{!! __('<a wire:navigate.hover href=":url">Fekete Richárd</a>, managing director, PSG Irodaházak', ['url' => route('fekete-richard')]) !!}</p>

                <h2>{{ __('Frequently asked questions') }}</h2>

                @foreach ($this->faqs() as $faq)
                    <h3>{{ $faq['question'] }}</h3>
                    <p>{{ $faq['answer'] }}</p>
                @endforeach

                <div class="not-prose mt-12 rounded-xl bg-linear-to-r from-accentdark to-accent p-8 text-white text-center space-y-6">
                    <p class="text-lg md:text-xl">{!! __('We publish the operating fee of the 230 Budapest office buildings on our data sheets, building by building, together with the rent and parking. You can find the fee bands per submarket on the :link page. If you would like to see the total monthly cost of a specific building, we will send a quote within 24 hours.', ['link' => '<a wire:navigate.hover href="'.e(route('rental-fees')).'" class="font-semibold underline">'.e(__('office rents in Budapest')).'</a>']) !!}</p>
                    <button type="button" x-data x-on:click="Livewire.dispatch('open-request-quote-modal')"
                        class="inline-flex items-center px-8 py-3 bg-white text-accentdark font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        {{ __('I\'d like a quote') }}
                    </button>
                </div>

                <p class="pt-6 border-t text-gray-700">
                    {{ __('Author:') }} <a wire:navigate.hover href="{{ route('fekete-richard') }}" rel="author" class="font-semibold">Fekete Richárd</a>
                </p>
            </article>
        </x-glass-panel>
    </x-page-section>
</div>
