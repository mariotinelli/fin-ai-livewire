<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Livewire\Auth\Profile\Partials\UpdateProfileInformationForm;
use App\Models\User;
use App\Notifications\VerifyEmailNotification as VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('requires authentication to open the profile form', function (): void {
    livewire(UpdateProfileInformationForm::class)->assertForbidden();
});

it('requires authentication again when saving the profile', function (): void {
    $user = User::factory()->user()->create();
    actingAs($user);
    $component = livewire(UpdateProfileInformationForm::class);
    Auth::logoutCurrentDevice();

    $component->call('save')->assertForbidden()->assertNotDispatched('profile::updated');
});

it('mounts with authenticated user data and updates profile information', function (): void {
    Notification::fake();
    /** @var User $user */
    $user = User::factory()->create([
        'type'  => TypeUsers::User,
        'name'  => 'Old Name',
        'email' => 'old@example.com',
    ]);

    actingAs($user);

    livewire(UpdateProfileInformationForm::class)
        ->assertSet('name', 'Old Name')
        ->assertSet('email', 'old@example.com')
        ->set('name', 'New Name')
        ->set('email', ' NEW@EXAMPLE.COM ')
        ->call('save')
        ->assertDispatched('toast')
        ->assertDispatched('profile::updated', name: 'New Name', initials: 'NE');

    expect($user->fresh()->name)->toBe('New Name')
        ->and($user->fresh()->email)->toBe('new@example.com')
        ->and($user->fresh()->email_verified_at)->toBeNull();

    Notification::assertSentTo($user, VerifyEmail::class, fn (VerifyEmail $notification, array $channels, User $notifiable): bool => $channels === ['mail'] && $notifiable->routeNotificationFor('mail', $notification) === 'new@example.com');
});

it('refuses profile updates when the account was deactivated after opening the form', function (): void {
    Notification::fake();
    $user = User::factory()->user()->create();
    actingAs($user);
    $component = livewire(UpdateProfileInformationForm::class);
    User::whereKey($user->id)->delete();
    $attributes = $user->fresh()->getAttributes();

    $component->set('name', 'Unauthorized Name')->set('email', 'changed@example.com')
        ->call('save')->assertForbidden()
        ->assertNotDispatched('toast')->assertNotDispatched('profile::updated');

    expect($user->fresh()->getAttributes())->toBe($attributes);
    Notification::assertNothingSent();
});

it('preserves verification without notifying when the email is unchanged', function (?string $verifiedAt): void {
    Notification::fake();
    $user = User::factory()->create(['email_verified_at' => $verifiedAt === null ? null : Carbon::parse($verifiedAt)]);
    actingAs($user);

    livewire(UpdateProfileInformationForm::class)
        ->set('name', 'Updated Name')
        ->call('save')
        ->assertHasNoErrors();

    expect($user->fresh()->email_verified_at?->toDateTimeString())->toBe($verifiedAt);
    Notification::assertNothingSent();
})->with(['verified' => '2026-01-01 12:00:00', 'unverified' => null]);

it('rejects invalid email changes without invalidating verification or notifying', function (string $email): void {
    Notification::fake();
    User::factory()->create(['email' => 'taken@example.com']);
    $user          = User::factory()->create(['email_verified_at' => Carbon::parse('2026-01-01 12:00:00')]);
    $originalEmail = $user->email;
    actingAs($user);

    livewire(UpdateProfileInformationForm::class)
        ->set('email', $email)
        ->call('save')
        ->assertHasErrors('email')
        ->assertNotDispatched('toast');

    expect($user->fresh()->email)->toBe($originalEmail)
        ->and($user->fresh()->email_verified_at?->toDateTimeString())->toBe('2026-01-01 12:00:00');
    Notification::assertNothingSent();
})->with(['malformed' => 'invalid', 'duplicate' => 'taken@example.com']);

it('verifies the new address and rejects the old link while keeping auth-only routes accessible', function (): void {
    Notification::fake();
    $user    = User::factory()->create(['email_verified_at' => null]);
    $oldLink = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id'   => $user->id,
        'hash' => sha1($user->email),
    ]);
    actingAs($user);

    livewire(UpdateProfileInformationForm::class)
        ->set('email', 'new.unverified@example.com')
        ->call('save')
        ->assertHasNoErrors();

    $this->get($oldLink)->assertForbidden();
    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
    $this->get(route($user->type->initialRouteName()))->assertOk();
    $this->get(route($user->type->profileRouteName()))->assertOk();

    Notification::assertSentTo($user, VerifyEmail::class, function (VerifyEmail $notification, array $channels, User $notifiable): bool {
        $this->get($notification->toMail($notifiable)->actionUrl)->assertRedirect();

        return $notifiable->email === 'new.unverified@example.com';
    });
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

it('limits email changes before updating the account or queueing verification but allows name edits', function (): void {
    $this->freezeTime();
    Notification::fake();
    $user = User::factory()->create();
    actingAs($user);
    $component = livewire(UpdateProfileInformationForm::class);

    foreach (range(1, 3) as $attempt) {
        $component->set('email', "change{$attempt}@example.com")->call('save')->assertHasNoErrors();
    }

    $component->set('email', 'blocked@example.com')->call('save')->assertHasErrors('email');
    expect($user->fresh()->email)->toBe('change3@example.com');
    Notification::assertSentToTimes($user, VerifyEmail::class, 3);
    $component->set('email', 'change3@example.com')->set('name', 'New Name')->call('save')->assertHasNoErrors();
    expect($user->fresh()->name)->toBe('New Name');
    Notification::assertSentToTimes($user, VerifyEmail::class, 3);
    $this->travel(1)->hours();
    $component->set('email', 'allowed@example.com')->call('save')->assertHasNoErrors();
    expect($user->fresh()->email)->toBe('allowed@example.com');
    Notification::assertSentToTimes($user, VerifyEmail::class, 4);
});
