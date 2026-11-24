@inject('structuredData', 'App\Services\StructuredDataService')
<x-slot name="title">{{ __('Offices for rent in Budapest: the offer of 230 office buildings | PSG Irodaházak') }}</x-slot>
<x-slot name="metaDescription">{{ $this->metaDescription() }}</x-slot>
<x-slot name="meta">
    {{ $structuredData->toScript($structuredData->collectionPage(__('page.title.offices_for_rent'), $this->metaDescription(), localized_route('kiado-irodak'), $this->listedOffices)) }}
</x-slot>

<div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
    <div>

        <livewire:office.rent-listing />

        <x-office-search-form :config="$this->searchFormConfig()" />

    </div>
</div>
