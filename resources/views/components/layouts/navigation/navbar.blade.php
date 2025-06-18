<nav
    class="fixed lg:absolute lg:-top-0 lg:left-[50%] lg:-translate-x-[50%] lg:-translate-y-[50%] z-50 bg-white lg:bg-transparent px-4 lg:px-0 py-2.5">
    <div class="flex flex-wrap justify-center items-center mx-auto">
        <div class="flex items-center lg:order-2 space-x-3">
            <!-- Mobile language switcher -->
            <div class="lg:hidden">
                <x-language-switcher />
            </div>

            <button data-collapse-toggle="mobile-menu-2" type="button"
                class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="mobile-menu-2" aria-expanded="false">
                <span class="sr-only">Menü</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
            <ul
                class="flex flex-col mt-4 font-bold lg:flex-row lg:mt-0 text-white text-xl text-nowrap bg-gradient-to-b from-black/30 to-black/5 border border-black/15 backdrop-blur-3xl shadow-lg rounded-md overflow-hidden">
                <li>
                    <a href="{{ localized_route('home') }}"
                        class="{{ request()->routeIs(['home', 'en.home']) ? 'active' : '' }} block py-4 px-8 hover:bg-primary/80 drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)]"
                        aria-current="page">{{ __('navigation.home') }}</a>
                </li>
                <li>
                    <a href="{{ localized_route('kiado-irodak') }}"
                        class="block py-4 px-8 hover:bg-primary/80 drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)] {{ request()->routeIs(['kiado-irodak', 'en.kiado-irodak']) ? 'active' : '' }}">
                        {{ __('navigation.offices_for_rent') }}</a>
                </li>
                <li>
                    <a href="{{ localized_route('elado-irodahazak') }}"
                        class="block py-4 px-8 hover:bg-primary/80 drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)] {{ request()->routeIs(['elado-irodahazak', 'en.elado-irodahazak']) ? 'active' : '' }}">
                        {{ __('navigation.office_buildings_for_sale') }}</a>
                </li>
                <li>
                    <a href="{{ localized_route('news.index') }}"
                        class="block py-4 px-8 hover:bg-primary/80 drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)] {{ request()->routeIs(['news.*', 'en.news.*']) ? 'active' : '' }}">
                        {{ __('navigation.news') }}</a>
                </li>
                <li>
                    <a href="{{ localized_route('rolunk') }}"
                        class="block py-4 px-8 hover:bg-primary/80 drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)] {{ request()->routeIs(['rolunk', 'en.rolunk']) ? 'active' : '' }}">
                        {{ __('navigation.about_us') }}</a>
                </li>
                <li>
                    <a href="{{ localized_route('blog.index') }}"
                        class="block py-4 px-8 hover:bg-primary/80 drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)] {{ request()->routeIs(['blog.*', 'en.blog.*']) ? 'active' : '' }}">
                        {{ __('navigation.blog') }}</a>
                </li>
                <li>
                    <a href="{{ localized_route('kapcsolat') }}"
                        class="block py-4 px-8 hover:bg-primary/80 drop-shadow duration-1000 transition-color ease-[cubic-bezier(0.19,1,0.22,1)] {{ request()->routeIs(['kapcsolat', 'en.kapcsolat']) ? 'active' : '' }}">
                        {{ __('navigation.contact') }}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
