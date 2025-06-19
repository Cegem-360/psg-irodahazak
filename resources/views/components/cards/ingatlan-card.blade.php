@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'link' => null,
    'small' => false,
    'property' => null,
])
<div
    class="group relative bg-white/10 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl hover:brightness-95 transition-all duration-300 ease-in-out border border-white/15">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-auto object-cover aspect-[3/2]" />
    <div class="{{ $small ? 'p-3 pl-4' : 'p-6 pl-8' }}">
        <h3 class="{{ $small ? 'text-lg' : 'text-xl' }} font-bold mb-2">{{ $title }}</h3>
        <p class="{{ $small ? 'text-gray-700 text-xs min-h-16' : 'text-gray-700 min-h-24' }}">
            {!! $description !!}</p>
        <a href="{{ $link ?? '#' }}"
            class="inline-block {{ $small ? 'mb-2 px-3 py-1 text-sm' : 'mb-4 px-6 py-2' }} bg-primary/70 text-white rounded group-hover:bg-primary/90 transition-colors duration-300 ease-in-out after:absolute after:inset-0 after:cursor-pointer">
            {{ __('More details') }}
        </a>
    </div>
</div>
