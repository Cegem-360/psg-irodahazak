@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Képek tesztje</h1>

        @php
            $property = \App\Models\Property::with('images')->first();
        @endphp

        @if ($property)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-2xl font-semibold mb-4">{{ $property->title }}</h2>
                    <p class="text-gray-600 mb-4">{{ $property->images->count() }} kép</p>

                    <!-- Property card komponens -->
                    <x-layouts.cards.property-card :property="$property" />
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-4">Galéria</h3>
                    <!-- Property gallery komponens -->
                    <x-layouts.cards.property-gallery :property="$property" />
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-semibold mb-4">Különböző méretek</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <h4 class="font-medium mb-2">160x160</h4>
                        <x-property-image :property="$property" size="160x160" class="w-full h-auto border rounded" />
                    </div>
                    <div>
                        <h4 class="font-medium mb-2">384x246</h4>
                        <x-property-image :property="$property" size="384x246" class="w-full h-auto border rounded" />
                    </div>
                    <div>
                        <h4 class="font-medium mb-2">800x600</h4>
                        <x-property-image :property="$property" size="800x600" class="w-full h-auto border rounded" />
                    </div>
                    <div>
                        <h4 class="font-medium mb-2">Eredeti</h4>
                        <x-property-image :property="$property" class="w-full h-auto border rounded" />
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-semibold mb-4">URL példák</h3>
                <div class="bg-gray-100 p-4 rounded">
                    <pre class="text-sm">
Eredeti útvonal: {{ $property->images->first()?->path }}
Image URL: {{ $property->first_image_url }}
800x600 méret: {{ $property->images->first()?->getImageUrl('800x600') }}
160x160 méret: {{ $property->images->first()?->getImageUrl('160x160') }}
                </pre>
                </div>
            </div>
        @else
            <p class="text-gray-600">Nincs elérhető ingatlan képekkel.</p>
        @endif
    </div>
@endsection
