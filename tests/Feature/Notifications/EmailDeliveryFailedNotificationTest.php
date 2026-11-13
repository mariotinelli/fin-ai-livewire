<?php

declare(strict_types = 1);

use App\Models\User;
use App\Notifications\EmailDeliveryFailedNotification;
use App\Support\QueueNames;
use Illuminate\Queue\WorkerOptions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;

it('uses only the internal channel and persists the existing notification-center contract', function (): void {
    $user         = User::factory()->create();
    $id           = (string) Str::uuid();
    $notification = new EmailDeliveryFailedNotification($id);

    Notification::sendNow($user, $notification);

    expect($notification->via($user))->toBe(['database']);
    $stored = $user->notifications()->sole();
    expect($stored->data['title'])->toBe('Falha no envio de e-mail');
    expect($stored->data['description'])->toContain($id);
    expect($stored->read_at)->toBeNull();
    expect($stored->viewed_at)->toBeNull();
});

it('encrypts a queued internal notice and restores its reference without exposing personal data', function (): void {
    $user      = User::factory()->create(['email' => 'PRIVATE_FAILURE_NOTICE_RSP174@example.com']);
    $reference = (string) Str::uuid();
    config(['queue.connections.database.connection' => config('database.default')]);
    DB::transaction(fn () => $user->notify(new EmailDeliveryFailedNotification($reference)->onConnection('database')));
    $payload = DB::table('jobs')->sole()->payload;
    expect($payload)->not->toContain($user->email, $reference);
    $restored = unserialize(Crypt::decrypt(json_decode($payload, true, flags: JSON_THROW_ON_ERROR)['data']['command']));
    expect($restored->notification->emailNotificationId)->toBe($reference);

    $job = Queue::connection('database')->pop(QueueNames::resolve('high_priority'));
    app('queue.worker')->setCache(Cache::store())->process('database', $job, new WorkerOptions(maxTries: 1));

    expect($user->notifications()->sole()->data['description'])->toContain($reference);
    $this->assertDatabaseCount('jobs', 0);
});
