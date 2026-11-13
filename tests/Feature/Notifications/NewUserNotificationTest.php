<?php

declare(strict_types = 1);

use App\Enums\Queues;
use App\Enums\TypeUsers;
use App\Models\User;
use App\Notifications\NewUserNotification;
use App\Support\QueueNames;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Queue\Attributes\Queue as QueueAttribute;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;

it('defines mail channel and queue for new user notification', function (): void {
    $notification   = new NewUserNotification('invitation-token', 'invited@example.com');
    $reflection     = new ReflectionClass($notification);
    $queueAttribute = $reflection->getAttributes(QueueAttribute::class);
    $queue          = ($queueAttribute[0] ?? null)?->newInstance();

    expect($queue?->queue)->toBe(Queues::LowPriority->value)
        ->and($notification->via(new User()))->toBe(['mail']);
});

it('builds new user mail message', function (): void {
    $user = User::factory()->make([
        'name'  => 'Maria',
        'email' => 'maria@example.com',
        'type'  => TypeUsers::User,
    ]);

    $mail = new NewUserNotification('invitation-token', $user->email)->toMail($user);

    expect($mail->subject)->toContain('Nova conta cadastrada no sistema')
        ->and($mail->actionText)->toBe('Definir minha senha')
        ->and($mail->actionUrl)->toBe(route('password.reset', ['token' => 'invitation-token', 'email' => $user->email, 'context' => 'admin']))
        ->and(implode(' ', $mail->outroLines))->toContain('60 minutos')
        ->and(implode(' ', $mail->outroLines))->toContain(route('password.forgot'));
});

it('does not expose credentials or an admin link to customers', function (): void {
    $customer = User::factory()->make([
        'name'  => 'Cliente',
        'email' => 'cliente@example.com',
        'type'  => TypeUsers::Customer,
    ]);

    $mail = new NewUserNotification('invitation-token', $customer->email)->toMail($customer);

    expect($mail->actionText)->toBe('Definir minha senha')
        ->and($mail->actionUrl)->toBe(route('password.reset', ['token' => 'invitation-token', 'email' => $customer->email, 'context' => 'customer']))
        ->and($mail->actionUrl)->not->toContain('/admin/')
        ->and(implode(' ', $mail->introLines))->not->toContain('secret-123')
        ->and(implode(' ', $mail->introLines))->not->toContain('cliente@example.com');
});

it('encrypts the queued invitation and carries no clear password', function (): void {
    $user         = User::factory()->create(['email' => 'PRIVATE_INVITATION_RSP174@example.com']);
    $token        = Password::createToken($user);
    $notification = new NewUserNotification($token, $user->email);
    config(['queue.connections.database.connection' => config('database.default')]);
    $existingJobIds = DB::table('jobs')->pluck('id');
    DB::transaction(function () use ($user, $notification, $existingJobIds): void {
        $user->notify($notification->onConnection('database'));
        $this->assertDatabaseCount('jobs', $existingJobIds->count());
    });
    $payload  = DB::table('jobs')->whereNotIn('id', $existingJobIds)->sole()->payload;
    $command  = json_decode($payload, true)['data']['command'];
    $restored = unserialize(Crypt::decrypt($command));

    expect($payload)->not->toContain($token, $user->email, $user->password);
    expect($restored->notification->token)->toBe($token);
    expect(property_exists($restored->notification, 'password'))->toBeFalse();
    expect($restored->afterCommit)->toBeTrue();

    $job = Queue::connection('database')->pop(QueueNames::resolve('low_priority'));
    app('queue.worker')->setCache(Cache::store())->process('database', $job, new WorkerOptions(maxTries: 1));
    $message = arrayMailTransport()->messages()->sole()->getOriginalMessage();
    expect($message->getTo()[0]->getAddress())->toBe($user->email);
    expect($message->getHtmlBody())->toContain($token);
});

it('discards queued invitations that are no longer valid', function (string $state): void {
    $user         = User::factory()->create();
    $token        = Password::createToken($user);
    $notification = new NewUserNotification($token, $user->email);

    expect($notification->shouldSend($user, 'mail'))->toBeTrue();

    match ($state) {
        'expired'                => $this->travel(61)->minutes(),
        'used'                   => Password::deleteToken($user),
        'replaced'               => Password::createToken($user),
        'changed email'          => $user->forceFill(['email' => 'changed@example.com']),
        'persisted email change' => User::query()->whereKey($user->id)->update(['email' => 'changed@example.com']),
        'deleted'                => $user->delete(),
        'permanently deleted'    => $user->forceDelete(),
        default                  => throw new InvalidArgumentException("Unknown invitation state {$state}."),
    };

    new SendQueuedNotifications(collect([$user]), $notification, ['mail'])->handle(app(Dispatcher::class));

    expect($notification->shouldSend($user, 'mail'))->toBeFalse();
    expect(arrayMailTransport()->messages())->toBeEmpty();
})->with(['expired', 'used', 'replaced', 'changed email', 'persisted email change', 'deleted', 'permanently deleted']);

it('delivers the valid queued invitation to the intended address', function (): void {
    $user         = User::factory()->create();
    $token        = Password::createToken($user);
    $notification = new NewUserNotification($token, $user->email);

    new SendQueuedNotifications(collect([$user]), $notification, ['mail'])->handle(app(Dispatcher::class));

    $messages = arrayMailTransport()->messages();
    expect($messages)->toHaveCount(1);
    $email = $messages->sole()->getOriginalMessage();
    expect($email->getTo()[0]->getAddress())->toBe($user->email);
    expect($email->getHtmlBody())->toContain('Definir minha senha')->not->toContain($user->password);
});

function arrayMailTransport(): ArrayTransport
{
    $transport = Mail::mailer()->getSymfonyTransport();

    if (!$transport instanceof ArrayTransport) {
        throw new RuntimeException('The test mailer must use the array transport.');
    }

    return $transport;
}

it('escapes the recipient name when rendering the invitation', function (): void {
    $user = User::factory()->make(['name' => '<script>alert(1)</script>']);
    $html = (string) new NewUserNotification('invitation-token', $user->email)->toMail($user)->render();

    expect($html)->not->toContain('<script>alert(1)</script>');
});
