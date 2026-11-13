<div data-notification-history>
    <x-ui.page title="Histórico de notificações" :breadcrumb="['Notificações']">
        @if ($batches !== [])
            <div class="mb-4 flex flex-wrap gap-2">
                <x-ui.button id="history-mark-all-as-read" primary outline sm wire:click="markAllAsRead">
                    Marcar todas como lidas</x-ui.button
                >
                <x-ui.button id="history-delete-notifications" error outline sm wire:click="deleteAll">Limpar</x-ui.button>
            </div>
        @endif
        <div class="overflow-hidden rounded-lg border border-base-300">
            @forelse ($batches as $batch)
                <livewire:notifications.history-batch
                    :notification-ids="$batch"
                    :key="'notification-batch-' . $revision . '-' . $batch[0]"
                />
            @empty
                <p class="p-6 text-base-content/65">Sem notificações</p>
            @endforelse
        </div>
        @if ($hasMore)
            <x-ui.button id="history-load-more" class="mt-4" primary outline wire:click="loadMore">Carregar mais notificações</x-ui.button>
        @elseif ($batches !== [])
            <p class="mt-4 text-sm text-base-content/65" role="status">Fim do histórico carregado.</p>
        @endif
    </x-ui.page>
</div>
