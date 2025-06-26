<div>

    <div class="relative bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url({{ Vite::asset('resources/images/view-of-london-city-united-kingdom-2025-02-19-07-53-44-utc.webp') }});">
        <div class="absolute inset-0 z-1 bg-gradient-to-b from-white/90 to-white/70"></div>
        <div class="relative z-10 container mx-auto space-y-3 pt-24 pb-20">
            <h2 class="mt-4 mb-16 font-bold text-5xl text-center drop-shadow text-logogray/80">
                {{ __('contact.title') }}</h2>

            <div class="max-w-screen-xl mx-auto p-8 backdrop-blur-3xl rounded-xl border border-white/15 shadow-xl">
                <!-- Kapcsolati információk szekció -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 border-b border-gray-300 hover:brightness-95 transition-all duration-300 ease-in-out mb-8">
                    <div>
                        <h3 class="mb-3 text-logogray/80 text-xl">Property Solution Group Kft.</h3>
                        <p class="mb-3 text-gray-600">
                            Iroda: 1016 Budapest, Derék u. 2.
                        </p>
                        <p class="mb-3 text-gray-600">
                            Tel.: +36 20 381 3917
                        </p>
                        <p>E-mail: <a class="text-primary"
                                href="mailto:info@psg-irodahazak.hu">info@psg-irodahazak.hu</a>
                        </p>
                    </div>
                    <div class="flex justify-center"><img class="mb-3"
                            src="{{ Vite::asset('resources/images/kapcsolat.jpg') }}" />
                    </div>
                </div>

                <!-- Kapcsolatfelvételi űrlap szekció -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Kapcsolatfelvételi űrlap -->
                    <div class="bg-white rounded-xl p-8 shadow-lg">
                        <!-- Sikeres/Hiba üzenetek -->
                        @if (session('success'))
                            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                <div class="flex">
                                    <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <div class="flex">
                                    <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <div class="flex">
                                    <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <ul class="list-disc list-inside">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <h3 class="mb-6 text-3xl tracking-tight font-bold text-accent">{{ __('contact.contact_form') }}
                        </h3>
                        <p class="mb-8 font-light text-gray-500 text-lg">{{ __('contact.contact_description') }}</p>

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="contact_name"
                                        class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.name') }}
                                        *</label>
                                    <input type="text" id="contact_name" name="name" value="{{ old('name') }}"
                                        class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('name') border-red-500 @enderror"
                                        placeholder="{{ __('contact.name_placeholder') }}" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="contact_email"
                                        class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.email') }}
                                        *</label>
                                    <input type="email" id="contact_email" name="email" value="{{ old('email') }}"
                                        class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('email') border-red-500 @enderror"
                                        placeholder="{{ __('contact.email_placeholder') }}" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="contact_phone"
                                        class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.phone') }}
                                        *</label>
                                    <input type="tel" id="contact_phone" name="phone" value="{{ old('phone') }}"
                                        class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('phone') border-red-500 @enderror"
                                        placeholder="{{ __('contact.phone_placeholder') }}" required>
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="contact_company"
                                        class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.company') }}</label>
                                    <input type="text" id="contact_company" name="company"
                                        value="{{ old('company') }}"
                                        class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('company') border-red-500 @enderror"
                                        placeholder="{{ __('contact.company_placeholder') }}">
                                    @error('company')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="contact_subject"
                                    class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.subject') }}
                                    *</label>
                                <select id="contact_subject" name="subject"
                                    class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('subject') border-red-500 @enderror"
                                    required>
                                    <option value="">{{ __('contact.subject_placeholder') }}</option>
                                    <option value="iroda_keresese"
                                        {{ old('subject') == 'iroda_keresese' ? 'selected' : '' }}>
                                        {{ __('contact.subject_office_search') }}
                                    </option>
                                    <option value="iroda_kiadas"
                                        {{ old('subject') == 'iroda_kiadas' ? 'selected' : '' }}>
                                        {{ __('contact.subject_office_rental') }}</option>
                                    <option value="ingatlan_ertekeles"
                                        {{ old('subject') == 'ingatlan_ertekeles' ? 'selected' : '' }}>
                                        {{ __('contact.subject_property_valuation') }}</option>
                                    <option value="befektetes" {{ old('subject') == 'befektetes' ? 'selected' : '' }}>
                                        {{ __('contact.subject_investment') }}</option>
                                    <option value="tanacadas" {{ old('subject') == 'tanacadas' ? 'selected' : '' }}>
                                        {{ __('contact.subject_consulting') }}</option>
                                    <option value="egyeb" {{ old('subject') == 'egyeb' ? 'selected' : '' }}>
                                        {{ __('contact.subject_other') }}
                                    </option>
                                </select>
                                @error('subject')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contact_message"
                                    class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.message') }}
                                    *</label>
                                <textarea id="contact_message" name="message" rows="6"
                                    class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('message') border-red-500 @enderror"
                                    placeholder="{{ __('contact.message_placeholder') }}" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="contact_privacy" name="privacy" type="checkbox" value="1"
                                        {{ old('privacy') ? 'checked' : '' }}
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 @error('privacy') border-red-500 @enderror"
                                        required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="contact_privacy"
                                        class="font-light text-gray-500">{{ __('contact.privacy_text') }} <a
                                            class="font-medium text-primary hover:underline"
                                            href="{{ localized_route('privacy-policy') }}">{{ __('contact.privacy_policy') }}</a>
                                        {{ __('contact.privacy_consent') }} *</label>
                                    @error('privacy')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-primary hover:bg-primary/80 focus:ring-4 focus:outline-none focus:ring-primary-300 transition-colors">
                                {{ __('contact.send_message') }}
                            </button>
                        </form>
                    </div>

                    <!-- További információk -->
                    <div class="space-y-6">
                        <!-- Nyitvatartás -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg">
                            <h4 class="text-xl font-bold text-gray-800 mb-4">{{ __('contact.opening_hours') }}</h4>
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
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('contact.service_search') }}
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('contact.service_representation') }}
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('contact.service_valuation') }}
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('contact.service_investment') }}
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 text-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ __('contact.service_analysis') }}
                                </li>
                            </ul>
                        </div>

                        <!-- Gyors kapcsolatfelvétel -->
                        <div class="bg-gradient-to-r from-primary to-accent text-white rounded-xl p-6 shadow-lg">
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
            </div>

        </div>
    </div>

</div>
