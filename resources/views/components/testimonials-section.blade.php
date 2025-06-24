@props(['limit' => 3])

@php
    $testimonials = \App\Models\Testimonial::active()->featured()->ordered()->limit($limit)->get();
@endphp

@if ($testimonials->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                    {{ __('Mit mondanak rólunk ügyfeleink?') }}
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    {{ __('Büszkék vagyunk ügyfeleink pozitív visszajelzéseire') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($testimonials as $testimonial)
                    <x-testimonial-card :testimonial="$testimonial" :featured="true" />
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('testimonials.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ __('Összes vélemény megtekintése') }}
                    <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endif
