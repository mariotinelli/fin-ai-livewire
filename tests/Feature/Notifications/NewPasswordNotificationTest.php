<?php

declare(strict_types = 1);

use App\Enums\Queues;
use App\Models\User;
use App\Notifications\NewPasswordNotification;
use App\Support\QueueNames;

use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Queue\Attributes\Queue as QueueAttribute;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\RawMessage;

it('delivers password reset instructions through the low priority mail queue', function (): void {
    $notification = new NewPasswordNotification('reset-token');
    $user         = User::factory()->user()->make(['name' => 'Maria', 'email' => 'maria@example.com']);
    $queue        = new ReflectionClass($notification)->getAttributes(QueueAttribute::class)[0]->newInstance();

    $mail = $notification->toMail($user);

    expect($notification->via($user))->toBe(['mail'])
        ->and($queue->queue)->toBe(Queues::LowPriority->value)
        ->and($mail->subject)->toContain('Redefinição de senha')
        ->and($mail->greeting)->toBe('Olá Maria!')
        ->and($mail->actionText)->toBe('Redefinir minha senha')
        ->and($mail->actionUrl)->toBe(route('password.reset', ['token' => 'reset-token', 'email' => 'maria@example.com', 'context' => 'admin']));
});

it('keeps recipient and token encrypted in the real queue across transport retries', function (): void {
    $this->travelTo(now()->startOfSecond());
    $user      = User::factory()->user()->create(['email' => 'PRIVATE_PASSWORD_RSP174@example.com']);
    $token     = Password::createToken($user);
    $transport = new class () extends ArrayTransport {
        public int $calls = 0;

        public function send(RawMessage $message, ?Envelope $envelope = null): ?SentMessage
        {
            if (++$this->calls === 1) {
                throw new TransportException('Temporary transport failure');
            }

            return parent::send($message, $envelope);
        }
    };
    Mail::extend('encrypted-password-test', fn (): ArrayTransport => $transport);
    config(['queue.connections.database.connection' => config('database.default'), 'mail.default' => 'encrypted-password-test', 'mail.mailers.encrypted-password-test' => ['transport' => 'encrypted-password-test']]);
    DB::transaction(fn () => $user->notify(new NewPasswordNotification($token)->onConnection('database')));
    $payload = DB::table('jobs')->sole()->payload;
    expect($payload)->not->toContain($user->email, $token);
    $restored = unserialize(Crypt::decrypt(json_decode($payload, true, flags: JSON_THROW_ON_ERROR)['data']['command']));
    expect($restored->notification->token)->toBe($token);
    $queue  = Queue::connection('database');
    $worker = app('queue.worker')->setCache(Cache::store());

    $worker->process('database', $queue->pop(QueueNames::resolve('low_priority')), new WorkerOptions(maxTries: 1));

    expect($transport->calls)->toBe(1);
    expect(DB::table('jobs')->sole()->payload)->toBe($payload);
    $this->travel(10)->seconds();
    $worker->process('database', $queue->pop(QueueNames::resolve('low_priority')), new WorkerOptions(maxTries: 1));
    expect($transport->calls)->toBe(2);
    $message = $transport->messages()->sole()->getOriginalMessage();
    expect($message->getTo()[0]->getAddress())->toBe($user->email);
    expect($message->getHtmlBody())->toContain($token);
    expect(DB::table('email_notifications')->sole()->attempt_count)->toBe(2);
    expect(DB::table('email_notifications')->sole()->accepted_at)->not->toBeNull();
    $this->assertDatabaseCount('jobs', 0);
});
