<?php

declare(strict_types = 1);

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use App\Support\QueueNames;
use Illuminate\Http\Request;
use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Notifications\SendQueuedNotifications;

use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\URL;

it('queues the native email with middleware and after commit', function (): void {
    $user = User::factory()->create(['email_verified_at' => null]);

    Bus::fake([SendQueuedNotifications::class]);

    $user->sendEmailVerificationNotification();

    Bus::assertDispatched(SendQueuedNotifications::class, fn (SendQueuedNotifications $job): bool => $job->notification instanceof VerifyEmailNotification
        && $job->channels === ['mail']
        && count($job->middleware) === 1
        && $job->afterCommit === true
        && $job->shouldBeEncrypted);
});

it('preserves the native signed verification URL and mail message', function (): void {
    $user = User::factory()->create(['email_verified_at' => null]);
    $mail = new VerifyEmailNotification()->toMail($user);

    expect($mail->actionUrl)->toContain('/verify-email/' . $user->id . '/' . sha1($user->email));
    expect(URL::hasValidSignature(Request::create($mail->actionUrl)))->toBeTrue();
    expect($mail->actionText)->toBe(__('Verify Email Address'));
});

it('encrypts the captured verification recipient and sends through the real worker', function (): void {
    $user = User::factory()->create(['email' => 'PRIVATE_VERIFICATION_RSP174@example.com', 'email_verified_at' => null]);
    config(['queue.connections.database.connection' => config('database.default')]);
    DB::transaction(fn () => $user->notify(new VerifyEmailNotification()->onConnection('database')));
    $payload = DB::table('jobs')->sole()->payload;
    expect($payload)->not->toContain($user->email);
    $restored = unserialize(Crypt::decrypt(json_decode($payload, true, flags: JSON_THROW_ON_ERROR)['data']['command']));
    expect($restored->notification)->toBeInstanceOf(VerifyEmailNotification::class);

    $job = Queue::connection('database')->pop(QueueNames::resolve('low_priority'));
    app('queue.worker')->setCache(Cache::store())->process('database', $job, new WorkerOptions(maxTries: 1));

    $transport = Mail::mailer()->getSymfonyTransport();
    expect($transport)->toBeInstanceOf(ArrayTransport::class);
    $message = $transport->messages()->sole()->getOriginalMessage();
    expect($message->getTo()[0]->getAddress())->toBe($user->email);
    expect($message->getHtmlBody())->toContain(sha1($user->email));
    $this->assertDatabaseCount('jobs', 0);
});
