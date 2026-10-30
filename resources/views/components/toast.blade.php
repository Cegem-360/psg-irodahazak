{{-- Site-styled toasts: Livewire components dispatch "notify" ({type, title, body}); redirects flash "toast" with the same shape. --}}
<div x-data="{
        toasts: [],
        add(toast) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, ...toast });
            setTimeout(() => this.remove(id), 8000);
        },
        remove(id) {
            this.toasts = this.toasts.filter((toast) => toast.id !== id);
        },
    }"
    @session('toast') x-init="add({{ Js::from($value) }})" @endsession
    x-on:notify.window="add($event.detail)" aria-live="polite"
    class="pointer-events-none fixed inset-x-4 top-4 z-9999 flex flex-col items-end gap-3 sm:left-auto sm:right-4">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-transition.opacity.duration.300ms role="status"
            class="pointer-events-auto flex w-full max-w-sm gap-3 rounded-lg border-l-4 bg-white p-4 shadow-lg ring-1 ring-gray-900/5"
            :class="toast.type === 'danger' ? 'border-red-500' : 'border-green-500'">
            <svg x-show="toast.type !== 'danger'" class="h-6 w-6 shrink-0 text-green-500" fill="none"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <svg x-show="toast.type === 'danger'" class="h-6 w-6 shrink-0 text-red-500" fill="none"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-900" x-text="toast.title"></p>
                <p class="mt-1 text-sm text-gray-600" x-text="toast.body"></p>
            </div>
            <button type="button" x-on:click="remove(toast.id)" class="shrink-0 text-gray-400 hover:text-gray-600"
                aria-label="{{ __('Close') }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>
