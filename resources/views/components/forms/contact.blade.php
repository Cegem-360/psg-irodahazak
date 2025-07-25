@props(['selected_property_id' => null, 'selected_property_type_is_rent' => null])
@use('App\Models\Property')
<form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
    @csrf
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
                        {{ $property->title }}
                    </option>
                @endforeach
            @else
                @dump($selected_property_type_is_rent)
                @dump($selected_property_id)

                @foreach (Property::active()->sale()->get() as $property)
                    <option value="{{ $property->title }}"
                        {{ $selected_property_id == $property->id ? 'selected' : '' }}>
                        {{ $property->title }}
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
                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 @error('privacy') border-red-500 @enderror"
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
