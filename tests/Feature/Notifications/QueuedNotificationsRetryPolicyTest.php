<?php

declare(strict_types = 1);

use App\Enums\Queues;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\Queue as QueueAttribute;
use Illuminate\Queue\Attributes\Tries;
use PHPUnit\Framework\ExpectationFailedException;

it('requires queue, tries and backoff attributes for all queued notifications', function (): void {
    $notificationClasses = collect(glob(app_path('Notifications/*.php')) ?: [])
        ->map(fn (string $file): string => 'App\\Notifications\\' . pathinfo($file, PATHINFO_FILENAME));

    expect($notificationClasses)->not->toBeEmpty();

    $notificationClasses
        ->each(function (string $notificationClass): void {
            $reflection = new ReflectionClass($notificationClass);

            if (!$reflection->implementsInterface(ShouldQueue::class)) {
                return;
            }

            $queueAttributes   = $reflection->getAttributes(QueueAttribute::class);
            $triesAttributes   = $reflection->getAttributes(Tries::class);
            $backoffAttributes = $reflection->getAttributes(Backoff::class);

            if ($queueAttributes === []) {
                throw new ExpectationFailedException("{$notificationClass} must define the #[Queue] attribute.");
            }

            if ($triesAttributes === []) {
                throw new ExpectationFailedException("{$notificationClass} must define the #[Tries] attribute.");
            }

            if ($backoffAttributes === []) {
                throw new ExpectationFailedException("{$notificationClass} must define the #[Backoff] attribute.");
            }

            $queueAttribute = $queueAttributes[0]->newInstance();
            $queue          = $queueAttribute->queue;

            $isQueueEnum      = $queue instanceof Queues;
            $isQueueEnumValue = is_string($queue) && in_array($queue, array_column(Queues::cases(), 'value'), true);

            if (!$isQueueEnum && !$isQueueEnumValue) {
                throw new ExpectationFailedException("{$notificationClass} must define #[Queue] using App\\Enums\\Queues or its backed value.");
            }

            $triesAttribute   = $triesAttributes[0]->newInstance();
            $backoffAttribute = $backoffAttributes[0]->newInstance();
            $backoff          = $backoffAttribute->backoff;

            if ($triesAttribute->tries <= 0) {
                throw new ExpectationFailedException("{$notificationClass} has an invalid tries value. Expected a positive integer.");
            }

            if (!is_array($backoff) || $backoff === []) {
                throw new ExpectationFailedException("{$notificationClass} has an invalid backoff value. Expected a non-empty array of positive integers.");
            }

            foreach ($backoff as $seconds) {
                if ($seconds <= 0) {
                    throw new ExpectationFailedException("{$notificationClass} has an invalid backoff entry. Expected only positive integers.");
                }
            }

            expect($triesAttribute->tries)->toBeGreaterThan(0)
                ->and($backoff)->not->toBeEmpty();
        });
});
