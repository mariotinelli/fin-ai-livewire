<?php

declare(strict_types = 1);

use App\Actions\Users\SendUserInvitation;
use App\Enums\TypeUsers;
use App\Livewire\Auth\ForgotPassword;
use App\Models\User;
use App\Notifications\NewUserNotification;
use App\Notifications\ResetPasswordNotification as ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;

use function Pest\Livewire\livewire;

it('preserves only allowlisted recovery contexts after a Livewire update', function (string $context, string $routeName): void {
    Livewire::withQueryParams(['context' => $context])->test(ForgotPassword::class)
        ->call('sendResetLink')->assertHasErrors('email')->assertSee(route($routeName));
})->with([
    ['customer', 'customer.login'], ['support', 'support.login'],
    ['admin', 'admin.login'], ['https://external.example', 'admin.login'],
]);

it('validates email before sending reset link', function (): void {
    livewire(ForgotPassword::class)
        ->set('email', '')
        ->call('sendResetLink')
        ->assertHasErrors(['email' => 'required']);
});

it('flashes status when password reset link is sent', function (): void {
    $user = User::factory()->admin()->create();

    Password::shouldReceive('sendResetLink')
        ->once()
        ->with(['email' => $user->email], Mockery::type(Closure::class))
        ->andReturn(Password::RESET_LINK_SENT);

    livewire(ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendResetLink')
        ->assertHasNoErrors()
        ->assertSee(__(Password::RESET_LINK_SENT));
});

it('returns the public confirmation without sending another email when recovery is throttled', function (): void {
    $this->freezeTime();
    Notification::fake();
    $user       = User::factory()->admin()->create();
    $attributes = $user->fresh()->getAttributes();
    $token      = Password::createToken($user);

    livewire(ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendResetLink')
        ->assertHasNoErrors()
        ->assertSee(__(Password::RESET_LINK_SENT));

    Notification::assertNothingSent();
    expect(Password::tokenExists($user, $token))->toBeTrue();
    expect($user->fresh()->getAttributes())->toBe($attributes);
});

it('sends the shared password reset URL to every user type', function (TypeUsers $type): void {
    Notification::fake();

    $user = User::factory()->create(['type' => $type]);

    livewire(ForgotPassword::class)
        ->set('email', $user->email)
        ->call('sendResetLink')
        ->assertHasNoErrors();

    Notification::assertSentTo(
        $user,
        ResetPassword::class,
        fn (ResetPassword $notification): bool => str_contains(
            $notification->toMail($user)->actionUrl,
            '/nova-senha/',
        ),
    );
})->with([
    'admin'    => TypeUsers::Admin,
    'user'     => TypeUsers::User,
    'customer' => TypeUsers::Customer,
    'support'  => TypeUsers::SupportRemSoft,
]);

it('does not reveal or notify unknown emails', function (): void {
    Notification::fake();

    livewire(ForgotPassword::class)
        ->set('email', 'unknown@example.com')
        ->call('sendResetLink')
        ->assertHasNoErrors()
        ->assertSee(__(Password::RESET_LINK_SENT));

    Notification::assertNothingSent();
});

it('resends access after the cooldown and invalidates the invitation', function (): void {
    $this->freezeTime();
    Notification::fake();
    $user = User::factory()->create();
    app(SendUserInvitation::class)->handle(user: $user);
    $invitation = Notification::sent($user, NewUserNotification::class)->sole();

    livewire(ForgotPassword::class)->set('email', $user->email)->call('sendResetLink')
        ->assertHasNoErrors()->assertSee(__(Password::RESET_LINK_SENT));
    Notification::assertCount(1);
    expect(Password::tokenExists($user, $invitation->token))->toBeTrue();

    $this->travel(61)->seconds();
    livewire(ForgotPassword::class)->set('email', $user->email)->call('sendResetLink')
        ->assertHasNoErrors()->assertSee(__(Password::RESET_LINK_SENT));

    expect(Password::tokenExists($user, $invitation->token))->toBeFalse();
    Notification::assertSentTo($user, ResetPassword::class, fn (ResetPassword $notification): bool => Password::tokenExists($user, $notification->token));
    Notification::assertCount(2);
    expect($user->fresh()->password)->toBe($user->password);
});

it('does not send a replacement or invalidate the invitation on rollback', function (): void {
    Notification::fake();
    $user  = User::factory()->create();
    $token = Password::createToken($user);
    $this->travel(61)->seconds();

    expect(fn () => DB::transaction(function () use ($user): void {
        livewire(ForgotPassword::class)->set('email', $user->email)->call('sendResetLink')->assertHasNoErrors();
        Notification::assertNothingSent();

        throw new RuntimeException('Rollback resend');
    }))->toThrow(RuntimeException::class, 'Rollback resend');

    expect(Password::tokenExists($user, $token))->toBeTrue();
    Notification::assertNothingSent();
});

it('limits recovery attempts across addresses from the same IP without changing existing tokens', function (): void {
    $this->freezeTime();
    Notification::fake();
    $user  = User::factory()->create();
    $token = Password::createToken($user);
    $this->travel(61)->seconds();

    foreach (range(1, 5) as $attempt) {
        livewire(ForgotPassword::class)->set('email', "unknown{$attempt}@example.com")
            ->call('sendResetLink')->assertHasNoErrors()->assertSee(__(Password::RESET_LINK_SENT));
    }

    livewire(ForgotPassword::class)->set('email', $user->email)
        ->call('sendResetLink')->assertHasNoErrors()->assertSee(__(Password::RESET_LINK_SENT));

    Notification::assertNothingSent();
    expect(Password::tokenExists($user, $token))->toBeTrue();
    $this->travel(60)->seconds();
    livewire(ForgotPassword::class)->set('email', $user->email)->call('sendResetLink')->assertHasNoErrors();
    Notification::assertSentTo($user, ResetPassword::class);
});

it('limits recovery for the same recipient across different IPs and expires the hourly budget', function (): void {
    $this->freezeTime();
    Notification::fake();
    $user = User::factory()->create();

    foreach (range(1, 3) as $attempt) {
        Livewire::withHeaders(['REMOTE_ADDR' => "192.0.2.{$attempt}"])->test(ForgotPassword::class)
            ->set('email', $user->email)->call('sendResetLink')->assertHasNoErrors();
        $this->travel(61)->seconds();
    }

    $tokenHash = DB::table('password_reset_tokens')->where('email', $user->email)->value('token');
    Livewire::withHeaders(['REMOTE_ADDR' => '192.0.2.4'])->test(ForgotPassword::class)
        ->set('email', mb_strtoupper($user->email))->call('sendResetLink')
        ->assertHasNoErrors()->assertSee(__(Password::RESET_LINK_SENT));

    Notification::assertSentToTimes($user, ResetPassword::class, 3);
    expect(DB::table('password_reset_tokens')->where('email', $user->email)->value('token'))->toBe($tokenHash);
    $this->travel(1)->hours();
    livewire(ForgotPassword::class)->set('email', $user->email)->call('sendResetLink')->assertHasNoErrors();
    Notification::assertSentToTimes($user, ResetPassword::class, 4);
});
