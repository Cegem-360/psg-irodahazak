<x-layouts.app>
    <x-slot name="title">{{ __('Testimonials') }}</x-slot>
    <x-slot name="meta">
        <meta name="description" content="{{ __('What our clients say about us - PSG Irodaházak') }}">
        <meta name="keywords" content="{{ __('reviews, references, client feedback, PSG Irodaházak') }}">
    </x-slot>

    <div class="bg-white">
        {{-- Hero Section --}}
        <div class="bg-linear-to-r from-blue-600 to-indigo-700 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-white sm:text-5xl md:text-6xl">
                        {{ __('Testimonials') }}
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-xl text-blue-100">
                        {{ __('We are proud of the opinions and trust of our clients, which we have earned through our work.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Featured Testimonials --}}
        @if ($featuredTestimonials->count() > 0)
            <div class="py-16 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                            {{ __('Featured testimonials') }}
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($featuredTestimonials as $testimonial)
                            <x-testimonial-card :$testimonial :featured="true" />
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- All Testimonials --}}
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                        {{ __('All testimonials') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($testimonials as $testimonial)
                        <x-testimonial-card :$testimonial />
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="text-gray-400 text-lg">
                                {{ __('There are no testimonials yet.') }}
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($testimonials->hasPages())
                    <div class="mt-12">
                        {{ $testimonials->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
