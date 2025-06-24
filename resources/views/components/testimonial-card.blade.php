@props(['testimonial', 'featured' => false])

<div
    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 {{ $featured ? 'border-l-4 border-yellow-400' : '' }}">
    <!-- Rating -->
    <div class="flex items-center mb-4">
        @for ($i = 1; $i <= 5; $i++)
            <svg class="h-4 w-4 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
        @endfor
        @if ($featured)
            <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Kiemelt</span>
        @endif
    </div>

    <!-- Testimonial Text -->
    <blockquote class="text-gray-700 mb-4 line-clamp-4">
        "{{ Str::limit($testimonial->testimonial, 150) }}"
    </blockquote>

    <!-- Project Type -->
    @if ($testimonial->project_type)
        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mb-4">
            {{ $testimonial->project_type }}
        </span>
    @endif

    <!-- Client Info -->
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            @if ($testimonial->client_image)
                <img class="h-10 w-10 rounded-full object-cover mr-3"
                    src="{{ Storage::url($testimonial->client_image) }}" alt="{{ $testimonial->client_name }}">
            @else
                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                    <span class="text-gray-600 font-medium text-sm">
                        {{ substr($testimonial->client_name, 0, 1) }}
                    </span>
                </div>
            @endif

            <div>
                <p class="text-sm font-medium text-gray-900">{{ $testimonial->client_name }}</p>
                @if ($testimonial->client_position)
                    <p class="text-xs text-gray-500">{{ $testimonial->client_position }}</p>
                @endif
                @if ($testimonial->client_company)
                    <p class="text-xs text-gray-600 font-medium">{{ $testimonial->client_company }}</p>
                @endif
            </div>
        </div>

        <!-- Company Logo -->
        @if ($testimonial->company_logo)
            <img class="h-8 object-contain" src="{{ Storage::url($testimonial->company_logo) }}"
                alt="{{ $testimonial->client_company }}">
        @endif
    </div>

    <!-- Read More Link -->
    <div class="mt-4 text-right">
        <a href="{{ route('testimonials.show', $testimonial) }}"
            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            Részletek →
        </a>
    </div>
</div>
