<div x-data="notificationCenter()" x-effect="visible = true" data-notification-batch>
    @foreach ($this->batchNotifications as $notification)
        <x-notifications.item :notification="$notification" id-prefix="history-" wire:key="history-notification-{{ $notification->id }}" />
    @endforeach
</div>
