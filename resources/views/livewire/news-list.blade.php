<div>
    <x-glass-panel padding="px-8 py-4" class="flex flex-col md:flex-row gap-4 mb-6">
        <label class="flex-1">
            <span class="sr-only">{{ __('Search news') }}</span>
            <input type="search" wire:model.live.debounce.400ms="search" placeholder="{{ __('Search news...') }}"
                class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" />
        </label>
        @if ($this->categories->isNotEmpty())
            <label class="md:w-72">
                <span class="sr-only">{{ __('Category') }}</span>
                <select wire:model.live="category"
                    class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                    <option value="">{{ __('All categories') }}</option>
                    @foreach ($this->categories as $newsCategory)
                        <option value="{{ $newsCategory->slug }}">{{ $newsCategory->name }}</option>
                    @endforeach
                </select>
            </label>
        @endif
    </x-glass-panel>

    <x-glass-panel wire:loading.class="opacity-60">
        @forelse ($news as $article)
            <x-news.list-item :article="$article" wire:key="news-{{ $article->id }}" />
        @empty
            <div class="p-6 text-center text-gray-600">
                <p>{{ __('No news matches your search.') }}</p>
                <button type="button" wire:click="resetFilters" class="mt-4 text-primary underline">
                    {{ __('Clear filters') }}</button>
            </div>
        @endforelse
    </x-glass-panel>

    @if ($news->hasPages())
        <x-glass-panel padding="px-8 py-3" class="flex justify-center gap-8 mt-3">
            {{ $news->links() }}
        </x-glass-panel>
    @endif
</div>
