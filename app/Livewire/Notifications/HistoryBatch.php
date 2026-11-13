<?php

declare(strict_types = 1);

namespace App\Livewire\Notifications;

use App\Actions\Notifications\MarkNotificationsViewed;
use App\Livewire\Notifications as NotificationCenter;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Features\SupportEvents\Event;

/** @property-read Collection<int, Notification> $batchNotifications */
class HistoryBatch extends NotificationCenter
{
    /** @var list<string> */
    #[Locked]
    public array $notificationIds = [];

    /** @param list<string> $notificationIds */
    public function mount(array $notificationIds): void
    {
        /** @var array{notificationIds: list<string>} $validated */
        $validated = Validator::make(['notificationIds' => $notificationIds], [
            'notificationIds'   => ['array', 'list', 'max:100'],
            'notificationIds.*' => ['string', 'uuid', 'distinct'],
        ])->validate();
        $this->notificationIds = $validated['notificationIds'];
    }

    /** @return Collection<int, Notification> */
    #[Computed]
    public function batchNotifications(): Collection
    {
        return authenticatedUser()->notifications()->whereIn('id', $this->notificationIds)->reorder('created_at', 'desc')->orderByDesc('id')->get();
    }

    public function markViewed(mixed $notificationIds, MarkNotificationsViewed $action): bool
    {
        $result = parent::markViewed($notificationIds, $action);
        /** @var Event $event */
        $event = $this->dispatch('notifications::updated');
        $event->to(NotificationCenter::class);

        return $result;
    }

    #[On('notifications::updated')]
    public function render(): View
    {
        return view('livewire.notifications.history-batch');
    }
}
