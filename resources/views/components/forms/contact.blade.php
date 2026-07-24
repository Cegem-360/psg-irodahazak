@props(['selected_property_id' => null, 'selected_property_type_is_rent' => null])
@use('App\Models\Property')
@use('App\Models\Translate')
<form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
    @csrf

    @if (session('success'))
        <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
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
        <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="contact_name" class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.name') }}
                *</label>
            <input type="text" id="contact_name" name="name" value="{{ old('name') }}"
                class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('name') border-red-500 @enderror"
                placeholder="{{ __('contact.name_placeholder') }}" required>
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="contact_email" class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.email') }}
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
            <label for="contact_phone" class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.phone') }}
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
            <input type="text" id="contact_company" name="company" value="{{ old('company') }}"
                class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('company') border-red-500 @enderror"
                placeholder="{{ __('contact.company_placeholder') }}">
            @error('company')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="contact_subject" class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.subject') }}
            *</label>
        <select id="contact_subject" name="contact_subject"
            class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('contact_subject') border-red-500 @enderror"
            required>
            <option value="">{{ __('contact.subject_placeholder') }}</option>
            @if ($selected_property_type_is_rent)
                @foreach (Property::rent()->active()->get() as $property)
                    <option value="{{ $property->title }}"
                        {{ $selected_property_id == $property->id ? 'selected' : '' }}>
                        @if (app()->getLocale() === 'en')
                            {{ Translate::whereName($property->title)->first()?->translated ?: $property->title }}
                        @else
                            {{ $property->title }}
                        @endif
                    </option>
                @endforeach
            @else
                @foreach (Property::active()->sale()->get() as $property)
                    <option value="{{ $property->title }}"
                        {{ $selected_property_id == $property->id ? 'selected' : '' }}>
                        @if (app()->getLocale() === 'en')
                            {{ Translate::whereName($property->title)->first()?->translated ?: $property->title }}
                        @else
                            {{ $property->title }}
                        @endif
                    </option>
                @endforeach
            @endif

        </select>
        @error('contact_subject')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="contact_message" class="block mb-2 text-sm font-medium text-gray-900">{{ __('contact.message') }}
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
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 checked:bg-primary checked:border-primary focus:ring-3 focus:ring-primary-300 @error('privacy') border-red-500 @enderror"
                required>
        </div>
        <div class="ml-3 text-sm">
            <label for="contact_privacy" class="font-light text-gray-500">{{ __('contact.privacy_text') }} <a
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
