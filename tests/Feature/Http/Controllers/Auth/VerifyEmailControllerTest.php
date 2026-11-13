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
});

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
