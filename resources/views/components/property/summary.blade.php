@props(['property'])

{{-- Address and key figures under a property card: rent and running costs, or area and price for sale. --}}
{{ $property->address() }}<br>
@if ($property->isSale())
    <strong>{{ __('Total Area') }}:</strong> {{ $property->total_area }} m2<br>
    <strong>{{ __('Price') }}:</strong> {{ $property->min_berleti_dij }} {{ __($property->min_berleti_dij_addons ?? '') }}
@else
    <strong>{{ __('Rental fee') }}:</strong>
    {{ $property->min_berleti_dij }}{{ $property->max_berleti_dij && $property->max_berleti_dij !== $property->min_berleti_dij ? ' - '.$property->max_berleti_dij : '' }}
    {{ __($property->min_berleti_dij_addons ?? '') }}<br>
    <strong>{{ __('Operating Fee') }}:</strong>
    {{ translate_value($property->uzemeletetesi_dij) }} {{ __($property->uzemeletetesi_dij_addons ?? '') }}
@endif
