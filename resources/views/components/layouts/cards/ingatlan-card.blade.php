<div class="bg-white/10 rounded-xl overflow-hidden shadow-xl backdrop-blur-3xl">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-auto object-cover" />
    <div class="p-6 pl-8">
        <h3 class="text-xl font-bold mb-2">{{ $title }}</h3>
        <p class="text-gray-700 min-h-24">{!! $description !!}</p>
        <a href="{{ $link ?? '#' }}"
            class="inline-block mb-4 px-6 py-2 bg-primary/70 text-white rounded hover:bg-accent/80 transition-colors">
            További részletek
        </a>
    </div>
</div>
