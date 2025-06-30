<div x-data="{ show: @entangle($attributes->wire('model')) }" x-show="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    style="display: none;">
    <div @click.away="show = false" class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
        <button @click="show = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">&times;</button>
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-primary mb-2">{{ $title ?? '' }}</h2>
        </div>
        <div>
            {{ $slot }}
        </div>
    </div>
</div>
