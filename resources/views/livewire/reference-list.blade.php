<div class="references-section">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-center mb-8">Referenciáink</h2>

        @if ($references->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach ($references as $reference)
                    <div class="reference-item text-center">
                        @if ($reference->image)
                            <div class="mb-4">
                                <img src="{{ Storage::url($reference->image) }}" alt="{{ $reference->name }}"
                                    loading="lazy"
                                    class="w-full h-24 object-contain mx-auto grayscale hover:grayscale-0 transition-all duration-300">
                            </div>
                        @endif
                        <h3 class="text-sm font-medium text-gray-700">{{ $reference->name }}</h3>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500">Nincsenek elérhető referenciák.</p>
        @endif
    </div>
</div>
