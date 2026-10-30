<x-layouts.app :breadcrumbs="[
    ['name' => __('Homepage'), 'url' => localized_route('home')],
    ['name' => __('Imprint'), 'url' => localized_route('impressum')],
]">
    <x-slot name="title">{{ __('Imprint') }} | PSG-IRODAHÁZAK</x-slot>
    <x-slot name="meta">
        <meta name="description" content="{{ __('PSG-IRODAHÁZAK imprint - Legal information and contact details.') }}">
        <meta name="keywords" content="{{ __('imprint, legal information, PSG-IRODAHÁZAK') }}">
        <link rel="canonical" href="{{ Request::url() }}">
    </x-slot>

    <x-page-section spacing="space-y-8">
        <x-slot:heading>{{ __('Imprint') }}</x-slot:heading>

        <x-glass-panel>
            <div class="bg-white rounded-lg p-8">
                @if ($impresszum && $impresszum->content)
                    <div class="prose prose-lg max-w-none text-gray-700">
                        {!! $impresszum->content !!}
                    </div>
                @else
                    <div class="text-gray-600">
                        <p>{{ __('The imprint content has not been set yet.') }}</p>
                    </div>
                @endif
            </div>
        </x-glass-panel>
    </x-page-section>
</x-layouts.app>
