@php
    $currentLang = app()->getLocale();
    $testimonials = \App\Models\Testimonial::active()->forLang($currentLang)->ordered()->limit(2)->get();
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
            <div
                class="rolunkmondtak-swiper relative z-10 grid grid-cols-1 md:grid-cols-2 gap-2 max-w-screen-xl mx-auto">
                <div class="swiper-wrapper">
                    @foreach ($testimonials ?? [] as $testimonial)
                        <div class="swiper-slide !flex flex-col lg:flex-row gap-8 p-12">

                            <img src="{{ Vite::asset('resources/images/aegon_logo_800x600.png') }}"
                                alt="{{ $testimonial->client_company }}"
                                class="w-1/2 lg:w-1/3 h-fit object-contain rounded-lg mb-4 p-2 bg-white" />

                            <div class="lg:w-2/3 text-md italic text-justify">
                                {!! $testimonial->testimonial !!}
                                <br>
                                <br>
                                <strong>
                                    {{ $testimonial->client_name }}
                                </strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
