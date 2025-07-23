@extends('layouts.app')

@section('title', 'Referenciáink')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <!-- Referenciák Livewire komponenssel -->
            <livewire:reference-list />

            <!-- Alternatív megoldás: manuális megjelenítés -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-center mb-8">Referenciáink (Manuális)</h2>

                @php
                    $references = get_references();
                @endphp

                @if ($references->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                        @foreach ($references as $reference)
                            <div
                                class="reference-item text-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                                @if ($reference->image)
                                    <div class="mb-4">
                                        <img src="{{ Storage::url($reference->image) }}" alt="{{ $reference->name }}"
                                            loading="lazy"
                                            class="w-full h-20 object-contain mx-auto grayscale hover:grayscale-0 transition-all duration-300">
                                    </div>
                                @else
                                    <div class="mb-4 flex items-center justify-center h-20 bg-gray-100 rounded">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                <h3 class="text-sm font-medium text-gray-700">{{ $reference->name }}</h3>
                                <span class="text-xs text-gray-500">{{ $reference->order + 1 }}. sorrend</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500">Nincsenek elérhető referenciák.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
