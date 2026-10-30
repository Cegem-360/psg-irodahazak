@props(['property'])

{{-- Address and key figures under a property card: rent and running costs, or area and price for sale. --}}
{{ $property->address() }}<br>
@if ($property->isSale())
    <strong>{{ __('Total Area') }}:</strong> {{ $property->total_area }} m2<br>
    <strong>{{ __('Price') }}:</strong> {{ $property->min_rent }} {{ __($property->min_rent_unit ?? '') }}
@else
    <strong>{{ __('Rental fee') }}:</strong>
    {{ $property->min_rent }}{{ $property->max_rent && $property->max_rent !== $property->min_rent ? ' - '.$property->max_rent : '' }}
    {{ __($property->min_rent_unit ?? '') }}<br>
    <strong>{{ __('Operating Fee') }}:</strong>
    {{ translate_value($property->operating_fee) }} {{ __($property->operating_fee_unit ?? '') }}
@endif
