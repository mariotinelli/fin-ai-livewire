<?php

declare(strict_types = 1);

use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Models\User;
use App\Support\Auth\IntendedDestination;
use Illuminate\Http\Request;

beforeEach(function (): void {
    $this->withoutVite();
});

it('renders the verification prompt for an unverified user', function (): void {
    $user    = User::factory()->customer()->create(['email_verified_at' => null]);
    $request = Request::create('/verify-email');
    $request->setUserResolver(fn (): User => $user);

    $response = (new EmailVerificationPromptController())($request, app(IntendedDestination::class));

    expect($response->name())->toBe('auth.verify-email');
});

it('redirects an already verified user to the dashboard', function (): void {
    $this->actingAs(User::factory()->customer()->create())
        ->get(route('verification.notice'))
        ->assertRedirect(route('customer.dashboard'));
});
