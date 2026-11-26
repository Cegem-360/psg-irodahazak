@inject('structuredData', 'App\Services\StructuredDataService')
@use('App\Enums\ArticlePageKey')
<x-slot name="title">{{ $page->meta_title }}</x-slot>
<x-slot name="metaDescription">{{ $page->meta_description }}</x-slot>
<x-slot name="meta">
    <meta property="og:type" content="article">
    <meta property="article:published_time" content="{{ $page->published_on->toDateString() }}">
    <meta property="article:modified_time" content="{{ $page->last_updated_on->toDateString() }}">
    <meta property="article:author" content="{{ route('fekete-richard') }}">
    {{ $structuredData->toScript($structuredData->authoredArticle($page->headline, $page->meta_description, $page->key->url(), $page->published_on, $page->last_updated_on)) }}
    {{ $structuredData->toScript($structuredData->faqPage($page->faqs)) }}
</x-slot>

<div>
    <x-page-section spacing="space-y-8">
        <x-slot:heading>{{ $page->headline }}</x-slot:heading>

        <x-glass-panel>
            <article class="article-page prose prose-lg max-w-none p-4 md:p-8 text-gray-700 prose-a:text-accent prose-headings:text-logogray">
                <p class="text-sm text-gray-500">
                    @if ($page->key === ArticlePageKey::RentalFees)
                        {{ __('Last updated:') }} <time datetime="{{ $page->last_updated_on->toDateString() }}">{{ $page->last_updated_on->year }}. {{ $page->last_updated_on->locale('hu')->translatedFormat('F') }}</time>
                    @else
                        {{ __('Published:') }} <time datetime="{{ $page->published_on->toDateString() }}">{{ $page->published_on->locale('hu')->translatedFormat('Y. F j.') }}</time>
                        @if ($page->last_updated_on->isAfter($page->published_on))
                            · {{ __('Last updated:') }} <time datetime="{{ $page->last_updated_on->toDateString() }}">{{ $page->last_updated_on->locale('hu')->translatedFormat('Y. F j.') }}</time>
                        @endif
                    @endif
                </p>

                {{-- The owner's copy from the admin (Díjak és cikkek), with its tables --}}
                {!! $page->body !!}

                <h2>{{ __('Frequently asked questions') }}</h2>

                @foreach ($page->faqs as $faq)
                    <h3>{{ $faq['question'] }}</h3>
                    <p>{{ $faq['answer'] }}</p>
                @endforeach

                <div class="not-prose mt-12 rounded-xl bg-linear-to-r from-accentdark to-accent p-8 text-white text-center space-y-6">
                    @if ($page->cta)
                        <div class="text-lg md:text-xl [&_a]:font-semibold [&_a]:underline">{!! $page->cta !!}</div>
                    @endif
                    <button type="button" x-data x-on:click="Livewire.dispatch('open-request-quote-modal')"
                        class="inline-flex items-center px-8 py-3 bg-white text-accentdark font-bold rounded-lg hover:bg-gray-100 transition-colors">
                        {{ __('I\'d like a quote') }}
                    </button>
                </div>

                <p class="pt-6 border-t text-gray-700">
                    {{ __('Author:') }} <a wire:navigate.hover href="{{ route('fekete-richard') }}" rel="author" class="font-semibold">Fekete Richárd</a>
                </p>
            </article>
        </x-glass-panel>
    </x-page-section>
</div>
