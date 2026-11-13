<?php

declare(strict_types = 1);

namespace App\Livewire;

use App\Actions\Notifications\DeleteNotification;
use App\Actions\Notifications\MarkNotificationsRead;
use App\Actions\Notifications\MarkNotificationsViewed;
use App\Models\Notification as DatabaseNotification;
use App\Support\NotificationCount;
use App\Traits\Components\WithAlert;
use App\Traits\Components\WithSidepage;
use App\Traits\Components\WithTable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

/**
 * @property-read Paginator<int, DatabaseNotification> $notifications
 * @property-read int $unviewedNotificationsCount
 * @property-read int $unreadNotificationsCount
 */
class Notifications extends Component
{
    use WithSidepage;
    use WithAlert;
    use WithTable;
    use WithoutUrlPagination;

    #[Locked]
    public ?string $clearConfirmation = null;

    #[Locked]
    public bool $notificationsLoaded = false;

    public function loadNotifications(): void
    {
        if ($this->sidepageOpen) {
            $this->notificationsLoaded = true;
        }
    }

    public function boot(): void
    {
        abort_unless(auth()->check(), 401);
    }

    #[On('notifications::updated')]
    public function render(): View
    {
        return view('livewire.notifications');
    }

    /** @return Paginator<int, DatabaseNotification> */
    #[Computed]
    public function notifications(): Paginator
    {
        return authenticatedUser()->notifications()
            ->reorder('created_at', 'desc')
            ->orderByDesc('id')
            ->simplePaginate(
                perPage: $this->notificationPageSize(),
                pageName: 'notificationsPage',
            );
    }

    #[Computed]
    public function unreadNotificationsCount(): int
    {
        return authenticatedUser()->unreadNotifications()->count();
    }

    #[Computed]
    public function unviewedNotificationsCount(): int
    {
        return NotificationCount::unviewed(authenticatedUser());
    }

    public function markViewed(mixed $notificationIds, MarkNotificationsViewed $action): bool
    {
        /** @var array{notificationIds: list<string>} $validated */
        $validated = Validator::make(['notificationIds' => $notificationIds], [
            'notificationIds'   => ['required', 'array', 'list', 'min:1', 'max:100'],
            'notificationIds.*' => ['required', 'string', 'uuid', 'distinct'],
        ])->validate();
        $action->handle(user: authenticatedUser(), notificationIds: $validated['notificationIds']);

        return true;
    }

    public function markAsRead(mixed $notificationId, MarkNotificationsRead $action): void
    {
        /** @var array{notificationId: string} $validated */
        $validated = Validator::make(['notificationId' => $notificationId], ['notificationId' => ['required', 'string', 'uuid']])->validate();
        $action->handle(user: authenticatedUser(), notificationId: $validated['notificationId']);
        $this->dispatch('notifications::updated');
    }

    public function markAllAsRead(MarkNotificationsRead $action): void
    {
        $action->handle(user: authenticatedUser());

        $this->dispatch('notifications::updated');
    }

    public function deleteAll(): void
    {
        $this->clearConfirmation = (string) Str::uuid();
        $this->confirmAlert(
            title: 'Limpar todas as notificações?',
            description: 'Todas as suas notificações serão removidas da central. O histórico será preservado.',
            method: 'confirmDeleteAll',
            params: $this->clearConfirmation,
            textConfirm: 'Limpar notificações',
            cancelMethod: 'cancelDeleteAll',
        );
    }

    public function cancelDeleteAll(): void
    {
        $this->clearConfirmation = null;
    }

    public function confirmDeleteAll(mixed $token): bool
    {
        abort_unless(is_string($token) && $this->clearConfirmation !== null && hash_equals($this->clearConfirmation, $token), 403);
        authenticatedUser()->notifications()->delete();
        NotificationCount::forgetFor(authenticatedUser());
        $this->clearConfirmation = null;
        $this->resetPage(pageName: 'notificationsPage');
        $this->dispatch('notifications::updated');

        return true;
    }

    public function delete(mixed $notificationId, DeleteNotification $action): void
    {
        /** @var array{notificationId: string} $validated */
        $validated = Validator::make(['notificationId' => $notificationId], ['notificationId' => ['required', 'string', 'uuid']])->validate();
        $action->handle(user: authenticatedUser(), notificationId: $validated['notificationId']);

        $this->resetPage(pageName: 'notificationsPage');

        $this->dispatch('notifications::updated');
    }

    protected function notificationPageSize(): int
    {
        $configured = config('notifications.per_page', 20);
        $size       = is_scalar($configured) ? (int) $configured : 0;

        return max(1, min(100, $size));
    }
}
