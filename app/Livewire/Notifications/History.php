<?php

declare(strict_types = 1);

namespace App\Livewire\Notifications;

use App\Livewire\Notifications as NotificationCenter;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

class History extends NotificationCenter
{
    /** @var list<list<string>> */
    #[Locked]
    public array $batches = [];

    #[Locked]
    public ?string $nextCursor = null;

    #[Locked]
    public bool $hasMore = true;

    #[Locked]
    public int $revision = 0;

    public function mount(): void
    {
        $this->loadMore();
    }

    public function loadMore(): void
    {
        if (!$this->hasMore) {
            return;
        }

        $page = authenticatedUser()->notifications()->reorder('created_at', 'desc')->orderByDesc('id')->cursorPaginate(
            perPage: $this->notificationPageSize(),
            columns: ['id', 'created_at'],
            cursor: $this->nextCursor ?? '',
        );
        $ids = [];

        foreach ($page as $notification) {
            $ids[] = $notification->id;
        }

        if ($ids !== []) {
            $this->batches[] = $ids;
        }

        $this->nextCursor = $page->nextCursor()?->encode();
        $this->hasMore    = $page->hasMorePages();
    }

    public function restartHistory(): void
    {
        $this->batches    = [];
        $this->nextCursor = null;
        $this->hasMore    = true;
        $this->revision++;
        $this->loadMore();
    }

    #[On('notifications::updated')]
    public function refreshHistory(): void
    {
        if (!authenticatedUser()->notifications()->exists()) {
            $this->batches    = [];
            $this->nextCursor = null;
            $this->hasMore    = false;
        }
    }

    public function render(): View
    {
        return view('livewire.notifications.history');
    }
}
