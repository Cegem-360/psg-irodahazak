<x-layouts.app :breadcrumbs="[
    ['name' => __('Homepage'), 'url' => localized_route('home')],
    ['name' => __('Rental Offices'), 'url' => localized_route('kiado-irodak')],
    ['name' => $category->name, 'url' => Request::url()],
]">
    <x-slot name="title">{{ $category->seo_title ?: __(':category Budapesten | PSG Irodaházak', ['category' => $category->name]) }}</x-slot>
    <x-slot name="metaDescription">{{ $category->meta_description ?: __(':category Budapesten: az irodaházak aktuális szabad területei, bérleti és üzemeltetési díjai térképpel. Kérjen személyre szabott ajánlatot a PSG Irodaházaktól!', ['category' => $category->name]) }}</x-slot>
    <livewire:list-rent-offices :queryParams />
</x-layouts.app>
