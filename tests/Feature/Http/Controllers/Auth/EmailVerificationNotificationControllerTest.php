<?php

declare(strict_types = 1);

use App\Models\User;
use App\Notifications\VerifyEmailNotification as VerifyEmail;
use Illuminate\Support\Facades\Notification;

it('sends a verification link to an unverified user', function (): void {
    Notification::fake();
    $user = User::factory()->customer()->create(['email_verified_at' => null]);

    $this->actingAs($user)->post(route('verification.send'))
        ->assertRedirect()
        ->assertSessionHas('status', 'verification-link-sent');

    Notification::assertSentTo($user, VerifyEmail::class);
});

it('redirects an already verified user without sending another link', function (): void {
    Notification::fake();
    $user = User::factory()->customer()->create();

    $this->actingAs($user)->post(route('verification.send'))
        ->assertRedirect(route('customer.dashboard'));

    Notification::assertNothingSent();
});

it('limits verification resends per minute and per hour without queueing excess mail', function (): void {
    $this->freezeTime();
    Notification::fake();
    $user = User::factory()->customer()->create(['email_verified_at' => null]);
    $this->actingAs($user)->post(route('verification.send'))->assertRedirect();
    $this->post(route('verification.send'))->assertTooManyRequests()->assertHeader('Retry-After');

    foreach (range(1, 4) as $attempt) {
        $this->travel(61)->seconds();
        $this->post(route('verification.send'))->assertRedirect();
    }

    $this->travel(61)->seconds();
    $this->post(route('verification.send'))->assertTooManyRequests();
    Notification::assertSentToTimes($user, VerifyEmail::class, 5);
    $this->travel(1)->hours();
    $this->post(route('verification.send'))->assertRedirect();
    Notification::assertSentToTimes($user, VerifyEmail::class, 6);
});

it('does not share the verification quota between different users', function (): void {
    Notification::fake();
    $first  = User::factory()->create(['email_verified_at' => null]);
    $second = User::factory()->create(['email_verified_at' => null]);

    $this->actingAs($first)->post(route('verification.send'))->assertRedirect();
    $this->actingAs($second)->post(route('verification.send'))->assertRedirect();

    Notification::assertSentTo($second, VerifyEmail::class);
});
