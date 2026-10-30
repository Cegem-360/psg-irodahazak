@php
    $stats = [
        ['icon' => 'svg.office', 'to' => 4, 'suffix' => ' '.__('million'), 'label' => 'm2 '.__('of office space').'<br>'.__('in Budapest')],
        ['icon' => 'svg.experience', 'to' => 25, 'suffix' => '+', 'label' => __('years').'<br>'.__('experience')],
        ['icon' => 'svg.market', 'to' => 90, 'suffix' => '%', 'label' => __('above').'<br>'.__('market knowledge')],
        ['icon' => 'svg.handshake', 'to' => 100, 'suffix' => __('thousand').' +', 'label' => 'm2 '.__('leased').'<br>'.__('Class A office space')],
    ];
@endphp

<div class="max-w-7xl mx-auto grid grid-cols-2 lg:grid-cols-4 gap-8 pt-32 pb-0">
    @foreach ($stats as $stat)
        <div class="flex flex-col items-center text-center space-y-4">
            <x-dynamic-component :component="$stat['icon']" class="text-primary brightness-75 w-20 h-20" />
            <div class="text-5xl font-bold text-primary">
                <span class="counter" data-to="{{ $stat['to'] }}" data-suffix="{{ $stat['suffix'] }}">{{ $stat['to'] }}{{ $stat['suffix'] }}</span>
            </div>
            <div class="text-lg font-semibold text-gray-700">{!! $stat['label'] !!}</div>
            <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
        </div>
    @endforeach
</div>
