<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

it('verifies the email and dispatches the verified event', function (): void {
    Event::fake([Verified::class]);
    session()->put('url.intended', route('admin.dashboard'));
    $user = User::factory()->customer()->create(['email_verified_at' => null]);
    $url  = URL::temporarySignedRoute('verification.verify', now()->addMinute(), [
        'id' => $user->id, 'hash' => sha1($user->email),
    ]);

    $this->actingAs($user)->get($url)
        ->assertRedirect(route('customer.dashboard') . '?verified=1');

    expect($user->refresh()->hasVerifiedEmail())->toBeTrue();
    Event::assertDispatched(Verified::class);
    $this->get($url)->assertRedirect();
    Event::assertDispatchedTimes(Verified::class, 1);
});

it('offers a new request without confirming either account on a refused link', function (string $reason): void {
    $owner = User::factory()->customer()->create(['email_verified_at' => null]);
    $other = User::factory()->customer()->create(['email_verified_at' => null]);
    $link  = URL::temporarySignedRoute('verification.verify', $reason === 'expired' ? now()->subMinute() : now()->addMinute(), [
        'id' => $owner->id, 'hash' => sha1($owner->email),
    ]);
    $this->actingAs($reason === 'foreign' ? $other : $owner)
        ->get($reason === 'altered' ? $link . '&invalid=1' : $link)
        ->assertForbidden()->assertSee('Solicitar novo link');
    expect($owner->refresh()->hasVerifiedEmail())->toBeFalse()
        ->and($other->refresh()->hasVerifiedEmail())->toBeFalse();
})->with(['expired', 'altered', 'foreign']);

it('redirects an already verified user without dispatching the event', function (): void {
    Event::fake([Verified::class]);
    $user = User::factory()->customer()->create();
    $url  = URL::temporarySignedRoute('verification.verify', now()->addMinute(), [
        'id' => $user->id, 'hash' => sha1($user->email),
    ]);

    $this->actingAs($user)->get($url)
        ->assertRedirect(route('customer.dashboard') . '?verified=1');

    Event::assertNotDispatched(Verified::class);
});
