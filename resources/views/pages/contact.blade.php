<x-layouts.app :breadcrumbs="[
    ['name' => __('Homepage'), 'url' => localized_route('home')],
    ['name' => __('contact.title'), 'url' => localized_route('kapcsolat')],
]">
    <x-slot name="title">{{ __('Contact | PSG Irodaházak') }}</x-slot>
    <x-slot name="metaDescription">{{ __('Get in touch with us! Property Solution Group Kft. – 1016 Budapest, Derék u. 2., +36 20 381 3917, info@psg-irodahazak.hu. A personalised office offer today.') }}</x-slot>
    <div>
        <x-page-section>
            <x-slot:heading>{{ __('contact.title') }}</x-slot:heading>

            <x-glass-panel>
                <!-- Kapcsolati információk szekció -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 border-b border-gray-300 hover:brightness-95 transition-all duration-300 ease-in-out mb-8">
                    <div>
                        @if ($contactPage && $contactPage->content)
                            {!! $contactPage->content !!}
                        @else
                            <!-- Alapértelmezett tartalom, ha nincs még beállítva az adatbázisban -->
                            <h3 class="mb-3 text-logogray/80 text-xl">Property Solution Group Kft.</h3>
                            <p class="mb-3 text-gray-600">
                                {{ __('Office:') }} 1016 Budapest, Derék u. 2.
                            </p>
                            <p class="mb-3 text-gray-600">
                                {{ __('Tel.:') }} +36 20 381 3917
                            </p>
                            <p>{{ __('E-mail:') }} <a class="text-primary"
                                    href="mailto:info@psg-irodahazak.hu">info@psg-irodahazak.hu</a>
                            </p>
                        @endif
                    </div>
                    @if ($contactPage && $contactPage->image)
                        <div class="flex justify-center"><img class="mb-3"
                                src="{{ Storage::url($contactPage->image) }}" alt="Property Solution Group Kft. – {{ __('contact.title') }}" />
                        </div>
                    @else
                        <div class="flex justify-center"><img class="mb-3"
                                src="{{ Vite::asset('resources/images/kapcsolat.jpg') }}" alt="Property Solution Group Kft. – {{ __('contact.title') }}" />
                        </div>
                    @endif
                </div>

                <!-- Kapcsolatfelvételi űrlap szekció -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Kapcsolatfelvételi űrlap -->
                    <div class="bg-white rounded-xl p-8 shadow-lg">
                        <h3 class="mb-6 text-3xl tracking-tight font-bold text-accent">
                            {{ __('contact.contact_form') }}
                        </h3>
                        <p class="mb-8 font-light text-gray-500 text-lg">{{ __('contact.contact_description') }}</p>

                        <livewire:contact-form />
                    </div>

                    <!-- További információk -->
                    <div class="space-y-6">
                        <!-- Nyitvatartás -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg">
                            <h4 class="text-xl font-bold text-gray-800 mb-4">{{ __('contact.opening_hours') }}
                            </h4>
                            <div class="space-y-2 text-gray-600">
                                <div class="flex justify-between">
                                    <span>{{ __('contact.monday_friday') }}</span>
                                    <span class="font-medium">9:00 - 18:00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>{{ __('contact.saturday') }}</span>
                                    <span class="font-medium">10:00 - 14:00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>{{ __('contact.sunday') }}</span>
                                    <span class="font-medium">{{ __('contact.closed') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Szolgáltatások -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg">
                            <h4 class="text-xl font-bold text-gray-800 mb-4">{{ __('contact.our_services') }}</h4>
                            <ul class="space-y-2 text-gray-600">
                                @foreach ([
                                    __('contact.service_search'),
                                    __('contact.service_representation'),
                                    __('contact.service_valuation'),
                                    __('contact.service_investment'),
                                    __('contact.service_analysis'),
                                ] as $service)
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-primary mr-2" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $service }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Gyors kapcsolatfelvétel -->
                        <div class="bg-linear-to-r from-primary to-accent text-white rounded-xl p-6 shadow-lg">
                            <h4 class="text-xl font-bold mb-4">{{ __('contact.immediate_contact') }}</h4>
                            <p class="mb-4">{{ __('contact.urgent_call') }}</p>
                            <a href="tel:+36203813917"
                                class="inline-flex items-center px-4 py-2 bg-white text-primary rounded-lg font-medium hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                    </path>
                                </svg>
                                +36 20 381 3917
                            </a>
                        </div>
                    </div>
                </div>
            </x-glass-panel>
        </x-page-section>
    </div>
</x-layouts.app>
