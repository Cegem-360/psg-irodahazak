<div>
    <div
        class="flex flex-col md:flex-row gap-4 max-w-7xl mx-auto mb-6 px-8 py-4 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
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
    </div>

    <div class="max-w-7xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl"
        wire:loading.class="opacity-60">
        @forelse ($news as $article)
            <x-news.list-item :article="$article" wire:key="news-{{ $article->id }}" />
        @empty
            <div class="p-6 text-center text-gray-600">
                <p>{{ __('No news matches your search.') }}</p>
                <button type="button" wire:click="resetFilters" class="mt-4 text-primary underline">
                    {{ __('Clear filters') }}</button>
            </div>
        @endforelse
    </div>

    @if ($news->hasPages())
        <div
            class="flex justify-center gap-8 max-w-7xl mx-auto mt-3 px-8 py-3 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
            {{ $news->links() }}
        </div>
    @endif
</div>
