    <!-- Kerjen ajanlatot -->
    <div class="bg-gradient-to-r from-accentdark to-accent text-white py-10 text-center">
        <p class="text-lg md:text-3xl font-bold">
            <a href="mailto:info@psg-irodahazak.hu" class="hover:text-gray-200 transition-colors duration-200"><x-svg.mail
                    class="text-accent mr-2" />
                {{ __('Request a quote now!') }}</a>
            <a href="tel:+36203813917" class="hover:text-gray-200 transition-colors duration-200">
                <span class="inline-block ml-8"><x-svg.phone class="text-accent mr-2" /> +36 20 381 3917</span></a>
        </p>
    </div>
    <!-- Linklista -->
    <div class="bg-[#EFEFEF] py-12 px-4">
        <div class="max-w-screen-xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-gray-800 text-lg">

            <ul class="space-y-2">
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-azonnali-szolgaltatott-irodak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('serviced offices') }}
                    </a>
                </li>
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-pesti-irodak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Offices for rent in Pest') }}
                    </a>
                </li>
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-belvarosi-irodak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Rent offices in downtown') }}
                    </a>
                </li>
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-irodak-v-kerulet']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Offices for rent in District V') }}
                    </a>
                </li>
            </ul>

            <ul class="space-y-2">
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-vaci-uti-irodak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Rent offices on Váci street') }}
                    </a>
                </li>
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-budai-irodak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Rent offices in Buda') }}
                    </a>
                </li>
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-bel-budai-irodak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Offices for rent in inner Buda') }}
                    </a>
                </li>
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-xi-keruleti-irodak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Offices for rent in District XI') }}
                    </a>
                </li>
            </ul>

            <ul class="space-y-2">
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-zold-irodak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Green offices for rent') }}
                    </a>
                </li>
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-klasszikus-irodahazak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Classic office buildings for rent') }}
                    </a>
                </li>
                <li>
                    <a href="{{ localized_route('budapest.category', ['category' => 'kiado-uj-irodahazak']) }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('New office buildings for rent') }}
                    </a>
                </li>
                <li>
                    <a href="{{ localized_route('elado-irodahazak') }}"
                        class="hover:text-blue-600 hover:underline transition-colors duration-200">
                        {{ __('Offices for sale') }}
                    </a>
                </li>
            </ul>

        </div>
    </div>
