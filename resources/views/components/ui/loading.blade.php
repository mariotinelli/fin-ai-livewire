<div
    x-data="{ loading: false, activeDot: 0, announcement: '' }"
    x-init="
        setInterval(() => {
            activeDot = (activeDot + 1) % 3;
        }, 300)
    "
    @toggle-loading.window="
        loading = $event.detail.loading;

        if (loading) {
            announcement = '';
            $nextTick(() => (announcement = 'Carregando...'));
        } else {
            announcement = '';
        }
    "
>
    <span class="sr-only" aria-live="polite" aria-atomic="true" x-text="announcement"></span>

    <div
        class="fixed inset-0 z-9999 flex items-center justify-center overflow-hidden rounded-lg border border-base-300 bg-base-200 opacity-90"
        x-show="loading"
        role="status"
        aria-live="polite"
        aria-atomic="true"
    >
        <span class="sr-only">Carregando...</span>

        <div class="flex items-center">
            <x-icons.loader class="mr-2 h-10 w-10 animate-spin fill-primary text-base-300" aria-hidden="true" />

            <span class="flex items-center text-lg font-bold text-primary">
                <span aria-hidden="true"> Carregando </span>

                <span class="ml-1 flex space-x-1" aria-hidden="true">
                    <x-ui.loading.dot :active-dot="0" />
                    <x-ui.loading.dot :active-dot="1" />
                    <x-ui.loading.dot :active-dot="2" />
                </span>
            </span>
        </div>
    </div>
</div>
