<div class="bg-white/10 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-auto object-cover aspect-[3/2]" />
    <div class="{{ isset($small) && $small ? 'p-3 pl-4' : 'p-6 pl-8' }}">
        <h3 class="{{ isset($small) && $small ? 'text-lg' : 'text-xl' }} font-bold mb-2">{{ $title }}</h3>
        <p class="{{ isset($small) && $small ? 'text-gray-700 text-xs min-h-16' : 'text-gray-700 min-h-24' }}">
            {!! $description !!}</p>
        <a href="{{ $link ?? '#' }}"
            class="inline-block {{ isset($small) && $small ? 'mb-2 px-3 py-1 text-sm' : 'mb-4 px-6 py-2' }} bg-primary/70 text-white rounded hover:bg-accent/80 transition-colors">
            További részletek
        </a>
    </div>
</div>
