<div class="flex flex-wrap gap-2">
    <x-ui.button
        id="mark-all-as-read"
        primary
        outline
        xs
        label="Marcar todas como lidas"
        wire:click="markAllAsRead"
        :disabled="$this->unreadNotificationsCount === 0"
    />
    <x-ui.button
        id="delete-notifications"
        error
        outline
        xs
        label="Limpar"
        wire:click="deleteAll"
        :disabled="count($this->notifications) === 0"
    />
</div>
