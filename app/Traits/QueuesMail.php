<?php

declare(strict_types = 1);

namespace App\Traits;

use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Carbon;

trait QueuesMail
{
    /** @return array<string, RateLimited> */
    public function middleware(object $notifiable, string $channel): array
    {
        return $channel === 'mail' ? ['outgoing-mail' => new RateLimited('outgoing-mail')->releaseAfter(1)] : [];
    }

    public function retryUntil(): Carbon
    {
        return now()->addHour();
    }
}
