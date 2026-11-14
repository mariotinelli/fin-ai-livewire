<div class="flex flex-wrap gap-2">
    <x-ui.button
        id="mark-all-as-read"
        primary
        outline
        sm
        class="h-auto min-h-11 max-w-full py-2 text-left whitespace-normal"
        label="Marcar todas como lidas"
        wire:click="markAllAsRead"
        :disabled="$this->unreadNotificationsCount === 0"
    />
    <x-ui.button
        id="delete-notifications"
        error
        outline
        sm
        class="h-auto min-h-11 max-w-full py-2 text-left whitespace-normal"
        label="Limpar"
        wire:click="deleteAll"
        :disabled="count($this->notifications) === 0"
    />
</div>
