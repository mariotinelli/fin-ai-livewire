<?php

declare(strict_types = 1);

use App\Models\User;
use App\Notifications\VerifyEmailNotification as VerifyEmail;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Support\Facades\Notification;

it('shows the accepted resend from a refused link', function (): void {
    Notification::fake();
    $user = User::factory()->customer()->create(['email_verified_at' => null]);

    $refused = route('verification.verify', ['id' => $user->id, 'hash' => sha1($user->email)]);
    $this->actingAs($user)->get($refused)->assertForbidden()->assertSee('Solicitar novo link');
    $response = $this->from($refused)->post(route('verification.send'))->assertRedirectToRoute('verification.notice');
    $this->followRedirects($response)->assertOk()->assertSee('Solicitação de envio recebida');

    Notification::assertSentTo($user, VerifyEmail::class);
});

it('redirects an already verified user without sending another link', function (): void {
    Notification::fake();
    $user = User::factory()->customer()->create();

    $this->actingAs($user)->post(route('verification.send'))
        ->assertRedirect(route('customer.dashboard'));

    Notification::assertNothingSent();
});

it('allows a new request after a failed publication and the quota window', function (): void {
    $user = User::factory()->customer()->create(['email_verified_at' => null]);
    $this->mock(Dispatcher::class)->shouldReceive('send')->once()->andThrow(new RuntimeException('Queue unavailable'));
    $refused = route('verification.verify', ['id' => $user->id, 'hash' => sha1($user->email)]);
    $this->actingAs($user)->get($refused)->assertForbidden()->assertSee('Solicitar novo link');
    $response = $this->from($refused)->post(route('verification.send'))->assertRedirectToRoute('verification.notice');
    $this->followRedirects($response)->assertOk()->assertSee('Não foi possível solicitar o envio');
    $this->from(route('verification.notice'))->post(route('verification.send'))
        ->assertTooManyRequests()->assertSee('Tente novamente')->assertSee('Solicitar novo link');
    $this->travel(61)->seconds();
    $this->app->instance(Dispatcher::class, Notification::fake());
    $response = $this->from(route('verification.send'))->post(route('verification.send'))->assertRedirectToRoute('verification.notice');
    $this->followRedirects($response)->assertOk()->assertSee('Solicitação de envio recebida');
    Notification::assertSentTo($user, VerifyEmail::class);
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
