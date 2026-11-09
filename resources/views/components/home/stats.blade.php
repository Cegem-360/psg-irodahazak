@php
    $stats = [
        ['icon' => 'svg.office', 'to' => 230, 'suffix' => '', 'label' => __('office buildings').'<br>'.__('on offer')],
        ['icon' => 'svg.experience', 'to' => 16, 'suffix' => ' '.__('years'), 'label' => __('of office market').'<br>'.__('experience')],
        ['icon' => 'svg.handshake', 'to' => 250, 'suffix' => '+', 'label' => __('signed').'<br>'.__('contracts')],
        ['icon' => 'svg.market', 'to' => 100, 'suffix' => ' '.__('thousand').' m²+', 'label' => __('leased').'<br>'.__('Class A office space')],
        ['icon' => 'svg.clock', 'to' => 24, 'suffix' => ' '.__('hours'), 'label' => __('within which').'<br>'.__('we send an offer')],
    ];
@endphp

<div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 pt-32 pb-0">
    @foreach ($stats as $stat)
        <div class="flex flex-col items-center text-center space-y-4">
            <x-dynamic-component :component="$stat['icon']" class="text-primary brightness-75 w-20 h-20" />
            <div class="text-4xl 2xl:text-5xl font-bold text-primary whitespace-nowrap">
                <span class="counter" data-to="{{ $stat['to'] }}" data-suffix="{{ $stat['suffix'] }}">{{ $stat['to'] }}{{ $stat['suffix'] }}</span>
            </div>
            <div class="text-lg font-semibold text-gray-700">{!! $stat['label'] !!}</div>
            <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
        </div>
    @endforeach
</div>
