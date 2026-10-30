<x-slot name="title">{{ __('Office buildings for sale in Budapest | PSG Irodaházak') }}</x-slot>
<x-slot name="metaDescription">{{ __('Office buildings and office premises for sale in Budapest: current listings with area, price and location. Investment office properties from PSG Irodaházak.') }}</x-slot>

<div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
    <div>

        <livewire:list-sale-offices />

        <x-office-search-form />

    </div>
</div>
