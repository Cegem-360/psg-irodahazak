@props(['first_span' => '', 'second_span' => ''])

<div class="flex justify-between items-center py-1.5 border-b border-gray-200">
    <span class="font-bold text-gray-600">{{ __($first_span) }}:</span>
    <span class="font-medium text-gray-900">{!! $second_span !!}</span>
</div>
