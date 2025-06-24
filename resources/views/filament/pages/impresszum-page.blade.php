<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 rounded-xl p-6">
            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        Impresszum tartalom
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Itt szerkesztheted az impresszum tartalmát, amely megjelenik a weboldalon.
                    </p>
                </div>

                <form wire:submit="save">
                    {{ $this->form }}

                    <div class="mt-6 flex justify-end">
                        {{ $this->getFormActions()[0] }}
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-filament-panels::page>
