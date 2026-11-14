<div
    class="[&_h1]:font-display [&_h1]:text-3xl [&_h1]:leading-tight [&_h1]:font-normal [&_h1]:text-base-content sm:[&_h1]:text-4xl mx-auto w-full max-w-5xl min-w-0"
    data-notification-history
>
    <x-ui.page
        title="Histórico de notificações"
        :breadcrumb="['Notificações']"
        description="Consulte suas notificações e gerencie as mensagens da sua conta."
    >
        @if ($batches !== [])
            <div class="mb-6 flex flex-wrap gap-3">
                <x-ui.button
                    id="history-mark-all-as-read"
                    class="h-auto min-h-11 max-w-full py-2 whitespace-normal"
                    primary
                    outline
                    sm
                    wire:click="markAllAsRead"
                >
                    Marcar todas como lidas</x-ui.button
                >
                <x-ui.button id="history-delete-notifications" class="min-h-11" error outline sm wire:click="deleteAll">Limpar</x-ui.button>
            </div>
        @endif
        <div class="min-w-0 overflow-hidden rounded-2xl border border-base-300 bg-base-100">
            @forelse ($batches as $batch)
                <livewire:notifications.history-batch
                    :notification-ids="$batch"
                    :key="'notification-batch-' . $revision . '-' . $batch[0]"
                />
            @empty
                <x-notifications.empty />
            @endforelse
        </div>
        @if ($hasMore)
            <x-ui.button
                id="history-load-more"
                class="mt-6 h-auto min-h-11 w-full py-2 whitespace-normal sm:w-auto"
                primary
                outline
                wire:click="loadMore"
            >
                Carregar mais notificações</x-ui.button
            >
        @elseif ($batches !== [])
            <p class="mt-6 text-center text-sm text-secondary" role="status">Fim do histórico carregado.</p>
        @endif
    </x-ui.page>
</div>
