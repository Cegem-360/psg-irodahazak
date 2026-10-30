<x-slot name="title">{{ __('Offices for rent in Budapest | PSG Irodaházak') }}</x-slot>
<x-slot name="metaDescription">{{ __('Offices for rent in Budapest in one place: current available spaces, rental and operating fees of A-category office buildings on a map. Request an offer today!') }}</x-slot>

<div class="overflow-hidden max-w-[2200px] mx-auto bg-white">
    <div>

        <livewire:list-rent-offices />

        <x-office-search-form />

    </div>
</div>
