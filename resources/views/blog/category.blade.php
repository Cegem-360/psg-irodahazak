<x-slot name="title">{{ $category->name }} | PSG-IRODAHÁZAK Blog</x-slot>

<div>
    <x-page-section>
        <x-slot:heading>{{ $category->name }}</x-slot:heading>

        <x-glass-panel>
            @forelse ($posts as $post)
                <a wire:navigate.hover href="{{ route('en.blog.show', ['post' => $post->slug]) }}" wire:key="post-{{ $post->id }}"
                    class="flex flex-col md:flex-row md:items-center gap-2 md:gap-6 p-6 border-b border-gray-300 hover:brightness-95">
                    <span class="text-gray-600">{{ $post->published_at->format('Y.m.d') }}</span>
                    <span class="text-xl font-semibold">{{ $post->title }}</span>
                </a>
            @empty
                <p class="p-6 text-gray-600">{{ __('No posts yet') }}</p>
            @endforelse
        </x-glass-panel>

        {{ $posts->links() }}
    </x-page-section>
</div>
