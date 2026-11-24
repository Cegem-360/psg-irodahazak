@inject('structuredData', 'App\Services\StructuredDataService')
<x-slot name="title">{{ $this->title() }}</x-slot>
<x-slot name="metaDescription">{{ $this->metaDescription() }}</x-slot>
<x-slot name="meta">
    {{ $structuredData->toScript($structuredData->collectionPage($category->heading ?: $category->name, $this->metaDescription(), localized_route('budapest.category', ['category' => $category->slug]), $this->listedOffices)) }}
</x-slot>

<div>
    <livewire:office.rent-listing :query-params="$queryParams" />
</div>
