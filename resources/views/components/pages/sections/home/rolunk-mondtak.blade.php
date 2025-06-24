@php
    $currentLang = app()->getLocale();
    $testimonials = \App\Models\Testimonial::active()->forLang($currentLang)->ordered()->limit(3)->get();
@endphp

<div class="rolunk-mondtak mt-12">
    <div class="relative">
        <h2 class="my-16 font-bold text-gray-500 text-5xl text-center drop-shadow text-logogray/80">
            Rólunk mondták</h2>
        <div class="absolute -right-8 -top-10 z-10 w-1/3 text-accent/30 blur-3xl">
            <x-svg.psg-irodahazak-symbol-1 />
        </div>
        <div class="absolute -left-8 -top-16 z-10 w-1/3 text-accent/30 blur-3xl">
            <x-svg.psg-irodahazak-symbol-2 />
        </div>
        <div class="absolute left-[50%] -translate-x-[50%] -bottom-40 z-10 w-96 text-accent/30 blur-3xl">
            <x-svg.psg-irodahazak-symbol-3 />
        </div>
    </div>
    @if ($testimonials->count() > 0)
        <div class="py-8 bg-gradient-to-b from-gray-400 to-accent/20">
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-2 max-w-screen-xl mx-auto">
                @foreach ($testimonials->take(2) as $testimonial)
                    <div class="flex flex-col lg:flex-row gap-8 p-12">
                        @if ($testimonial->company_logo)
                            <img src="{{ Storage::url($testimonial->company_logo) }}"
                                alt="{{ $testimonial->client_company }}"
                                class="w-1/2 lg:w-1/3 h-fit object-contain rounded-lg mb-4 p-2 bg-white" />
                        @elseif($testimonial->client_image)
                            <img src="{{ Storage::url($testimonial->client_image) }}"
                                alt="{{ $testimonial->client_name }}"
                                class="w-1/2 lg:w-1/3 h-fit object-contain rounded-lg mb-4 p-2 bg-white" />
                        @else
                            <div
                                class="w-1/2 lg:w-1/3 h-32 bg-white rounded-lg mb-4 p-2 flex items-center justify-center">
                                <span class="text-gray-400 text-4xl font-bold">
                                    {{ substr($testimonial->client_name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <div class="lg:w-2/3">
                            <p class="text-md italic text-justify">
                                "{{ $testimonial->testimonial }}"
                                <br>
                                <br>
                                <strong>
                                    {{ $testimonial->client_name }}
                                    @if ($testimonial->client_position)
                                        , {{ $testimonial->client_position }}
                                    @endif
                                    @if ($testimonial->client_company)
                                        , {{ $testimonial->client_company }}
                                    @endif
                                </strong>
                            </p>
                        </div>
                    </div>
                @endforeach

                @if ($testimonials->count() > 2)
                    <div class="col-span-1 md:col-span-2 flex justify-center p-12">
                        <div class="max-w-4xl text-center">
                            @php $thirdTestimonial = $testimonials->get(2); @endphp
                            <p class="text-lg italic text-justify">
                                "{{ $thirdTestimonial->testimonial }}"
                                <br>
                                <br>
                                <strong>
                                    {{ $thirdTestimonial->client_name }}
                                    @if ($thirdTestimonial->client_position)
                                        , {{ $thirdTestimonial->client_position }}
                                    @endif
                                    @if ($thirdTestimonial->client_company)
                                        , {{ $thirdTestimonial->client_company }}
                                    @endif
                                </strong>
                            </p>
                            @if ($thirdTestimonial->company_logo)
                                <img src="{{ Storage::url($thirdTestimonial->company_logo) }}"
                                    alt="{{ $thirdTestimonial->client_company }}"
                                    class="mx-auto mt-4 h-16 object-contain rounded-lg p-2 bg-white" />
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
