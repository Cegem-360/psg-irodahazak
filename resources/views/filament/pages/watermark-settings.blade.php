<x-filament-panels::page>
    <x-filament-panels::form :wire:submit="'save'">

        {{ $this->form }}

        <x-filament-panels::form.actions :actions="$this->getFormActions()" />

    </x-filament-panels::form>

    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="text-lg font-semibold mb-2">Használat</h3>
        <p class="text-sm text-gray-600 mb-2">
            A vízjel automatikusan alkalmazva lesz minden új feltöltött képre a következő helyeken:
        </p>
        <ul class="text-sm text-gray-600 list-disc list-inside space-y-1">
            <li>Ingatlan galéria képek</li>
            <li>Blog bejegyzések kiemelt képei</li>
            <li>Hírek kiemelt képei</li>
        </ul>

        <div class="mt-4">
            <h4 class="font-medium text-gray-700 mb-2">Elérhető funkciók:</h4>
            <div class="space-y-2 text-sm">
                <div class="flex items-center space-x-2">
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Teszt
                    </span>
                    <span class="text-gray-600">Dry-run mód - csak szimulálja a folyamatot</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Prototype
                    </span>
                    <span class="text-gray-600">Vízjeles másolatok külön mappában</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Éles
                    </span>
                    <span class="text-gray-600">Eredeti képek módosítása</span>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h4 class="font-medium text-gray-700 mb-1">Artisan parancsok:</h4>
            <div class="space-y-1 text-xs font-mono">
                <div class="bg-gray-100 p-2 rounded">
                    <code>php artisan watermark:apply --dry-run --type=gallery</code>
                    <span class="text-gray-500 ml-2"># Teszt futtatás</span>
                </div>
                <div class="bg-gray-100 p-2 rounded">
                    <code>php artisan watermark:apply --prototype --type=gallery</code>
                    <span class="text-gray-500 ml-2"># Prototype képek</span>
                </div>
                <div class="bg-gray-100 p-2 rounded">
                    <code>php artisan watermark:apply --type=all --sizes</code>
                    <span class="text-gray-500 ml-2"># Éles alkalmazás</span>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
