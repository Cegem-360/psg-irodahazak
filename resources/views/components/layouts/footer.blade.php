<footer class="p-4 bg-white sm:p-12">
    <div class="mx-auto max-w-screen-xl">
        <div class="md:flex md:gap-8 md:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="/" class="flex items-center">
                    <img src="{{ Vite::asset('resources/images/psg-irodahazak-logo.png') }}" class="mr-3 h-8 sm:h-16"
                        alt="PSG Irodaházak logo" />
                </a>
            </div>
            <div class="flex gap-8 lg:gap-20 flex-wrap">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Elérehetőségek</h2>
                    <ul class="text-gray-600">
                        <li class="mb-4">
                            <h4 class="text-sm text-bold">Property Solution Group Kft.</h4>
                        </li>
                        <li class="mb-4">
                            <a href="tel:+36203813917 " class="hover:underline"> +36 20 381 3917 </a>
                        </li>
                        <li class="mb-4">
                            <a href="mailto:info@psg-irodahazak.hu" class="hover:underline">info@psg-irodahazak.hu</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{ route('kapcsolat') }}" class="hover:underline">online kapcsolatfelvétel</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline" title="Hamarosan elérhető">bejelentkezés /
                                regisztráció</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Menü</h2>
                    <ul class="text-gray-600">
                        <li class="mb-4">
                            <a href="{{ route('home') }}" class="hover:underline ">Főoldal</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{ route('kiado-irodak') }}" class="hover:underline ">Kiadó irodák</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{ route('elado-irodahazak') }}" class="hover:underline ">Eladó irodaházak</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{ route('news.index') }}" class="hover:underline ">Hírek</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">&nbsp;</h2>
                    <ul class="text-gray-600">
                        <li class="mb-4">
                            <a href="{{ route('rolunk') }}" class="hover:underline ">Rólunk</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{ route('blog.index') }}" class="hover:underline ">Blog</a>
                        </li>
                        <li>
                            <a href="{{ route('kapcsolat') }}" class="hover:underline">Kapcsolat</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase">Jogi nyilatkozatok</h2>
                    <ul class="text-gray-600">
                        <li class="mb-4">
                            <a href="{{ route('privacy-policy') }}" class="hover:underline">Adatvédelmi nyilatkozat</a>
                        </li>
                        <li>
                            <a href="{{ route('impresszum') }}" class="hover:underline">Impresszum</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center">©2014-{{ date('Y') }} <a href="/"
                    class="hover:underline">Property Solution Group</a> - Minden jog fenntartva.</span>
            <div class="flex mt-4 space-x-6 sm:justify-center sm:mt-0">
                <a href="https://www.facebook.com/psgirodahazak" target="_blank"
                    class="text-gray-500 hover:text-gray-900">
                    <x-svg.fb-icon />
                </a>
            </div>
        </div>
    </div>
</footer>
