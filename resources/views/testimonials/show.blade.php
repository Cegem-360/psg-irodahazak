<x-layouts.app>
    <x-slot name="title">{{ $testimonial->client_name }} véleménye</x-slot>
    <x-slot name="meta">
        <meta name="description" content="{{ Str::limit($testimonial->testimonial, 160) }}">
        <meta name="keywords" content="vélemény, {{ $testimonial->client_name }}, PSG Irodaházak">
        <link rel="canonical" href="{{ url()->current() }}">
    </x-slot>

    <div class="bg-white">
        <!-- Breadcrumb -->
        <div class="bg-gray-50 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-4">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">
                                {{ __('Főoldal') }}
                            </a>
                        </li>
                        <li>
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <a href="{{ route('testimonials.index') }}" class="text-gray-500 hover:text-gray-700">
                                {{ __('Rólunk mondták') }}
                            </a>
                        </li>
                        <li>
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="text-gray-900 font-medium">{{ $testimonial->client_name }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Testimonial Detail -->
        <div class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-8">
                        <!-- Client Info -->
                        <div class="flex items-center mb-8">
                            @if ($testimonial->client_image)
                                <img class="h-16 w-16 rounded-full object-cover mr-4"
                                    src="{{ Storage::url($testimonial->client_image) }}"
                                    alt="{{ $testimonial->client_name }}">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center mr-4">
                                    <span class="text-gray-600 font-medium text-lg">
                                        {{ substr($testimonial->client_name, 0, 1) }}
                                    </span>
                                </div>
                            @endif

                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $testimonial->client_name }}</h1>
                                @if ($testimonial->client_position)
                                    <p class="text-gray-600">{{ $testimonial->client_position }}</p>
                                @endif
                                @if ($testimonial->client_company)
                                    <p class="text-gray-600 font-medium">{{ $testimonial->client_company }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center mb-6">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-gray-600">{{ $testimonial->rating }}/5</span>
                        </div>

                        <!-- Project Type -->
                        @if ($testimonial->project_type)
                            <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mb-6">
                                {{ $testimonial->project_type }}
                            </span>
                        @endif

                        <!-- Testimonial Text -->
                        <blockquote class="text-lg text-gray-700 leading-relaxed mb-8">
                            "{{ $testimonial->testimonial }}"
                        </blockquote>

                        <!-- Company Logo -->
                        @if ($testimonial->company_logo)
                            <div class="flex justify-center">
                                <img class="h-12 object-contain" src="{{ Storage::url($testimonial->company_logo) }}"
                                    alt="{{ $testimonial->client_company }}">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Back Button -->
                <div class="text-center mt-8">
                    <a href="{{ route('testimonials.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Vissza a véleményekhez') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
