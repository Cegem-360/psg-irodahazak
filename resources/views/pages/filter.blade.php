<x-slot name="title">{{ $category->seo_title ?: __(':category in Budapest | PSG Irodaházak', ['category' => $category->name]) }}</x-slot>
<x-slot name="metaDescription">{{ $category->meta_description ?: __(':category in Budapest: current available spaces, rental and operating fees of office buildings on a map. Request a personalised offer from PSG Irodaházak!', ['category' => $category->name]) }}</x-slot>

<div>
    <livewire:list-rent-offices :query-params="$queryParams" />
</div>
