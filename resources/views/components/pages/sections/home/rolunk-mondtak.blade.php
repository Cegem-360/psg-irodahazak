@php
    $currentLang = app()->getLocale();
    $testimonials = \App\Models\Testimonial::active()->forLang($currentLang)->ordered()->get();
@endphp

<div class="rolunk-mondtak mt-12">
    <div class="relative">
        <h2 class="my-16 font-bold text-accent text-5xl text-center drop-shadow text-logogray/80">
            {{ __('Testimonials') }}
        </h2>
        <div class="absolute -right-8 -top-10 z-1 w-1/3 text-accent/30 blur-3xl">
            <x-svg.psg-irodahazak-symbol-1 />
        </div>
        <div class="absolute -left-8 -top-16 z-1 w-1/3 text-accent/30 blur-3xl">
            <x-svg.psg-irodahazak-symbol-2 />
        </div>
        <div class="absolute left-[50%] -translate-x-[50%] -bottom-40 z-1 w-96 text-accent/30 blur-3xl">
            <x-svg.psg-irodahazak-symbol-3 />
        </div>
    </div>
    @if ($testimonials->count() > 0)
        <div class="relative py-4 bg-gradient-to-b from-gray-400 to-accent/20">
            <div
                class="swiper rolunkmondtak-swiper relative z-50 !grid _grid-cols-1 md:grid-cols-2_ gap-2 max-w-screen-xl mx-auto">
                <div class="swiper-wrapper">
                    @foreach ($testimonials ?? [] as $testimonial)
                        <div class="swiper-slide !flex flex-col lg:flex-row gap-8 p-12 pb-4">

                            <img src="{{ $testimonial?->client_image ? Storage::url($testimonial->client_image) : Vite::asset('resources/images/psg-irodahazak-logo.png') }}"
                                alt="{{ $testimonial->client_company }}"
                                class="w-1/2 lg:w-1/3 h-fit object-contain rounded-lg mb-4 p-2 bg-white" />

                            <div class="lg:w-2/3 text-md italic text-justify">
                                {!! preg_replace(['/^<p>/', '/<\/p>$/'], ['<p>”', '„</p>'], $testimonial->testimonial) !!}
                                <br>
                                <br>
                                <strong>
                                    {{ $testimonial->client_name }}
                                    @if ($testimonial->client_position)
                                        {{ ', ' . $testimonial->client_position }}
                                    @endif
                                    @if ($testimonial->client_company)
                                        {{ ', ' . $testimonial->client_company }}
                                    @endif
                                </strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div
                class="swiper-button-prev rolunkmondtak-button-prev !text-accent hover:bg-black/10 hover:shadow rounded after:!text-2xl after:!font-bold after:drop-shadow">
            </div>
            <div
                class="swiper-button-next rolunkmondtak-button-next !text-accent hover:bg-black/10 hover:shadow rounded after:!text-2xl after:!font-bold after:drop-shadow">
            </div>
        </div>
    @endif
</div>
