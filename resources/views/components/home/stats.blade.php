@props(['stats'])

<div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 pt-32 pb-0">
    @foreach ($stats as $stat)
        <div class="flex flex-col items-center text-center space-y-4">
            <x-dynamic-component :component="$stat['icon']" class="text-primary brightness-75 w-20 h-20" />
            <div class="text-3xl sm:text-4xl 2xl:text-5xl font-bold text-primary">
                <span class="counter" data-to="{{ $stat['to'] }}">{{ $stat['to'] }}</span><span class="text-2xl 2xl:text-3xl">{{ $stat['suffix'] }}</span>
            </div>
            <div class="text-lg font-semibold text-gray-700">{!! $stat['label'] !!}</div>
            <div class="w-12 border-b-2 border-primary/30 mt-2"></div>
        </div>
    @endforeach
</div>
