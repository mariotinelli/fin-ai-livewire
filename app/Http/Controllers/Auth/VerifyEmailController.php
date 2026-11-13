<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\Auth\IntendedDestination;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request, IntendedDestination $destination): RedirectResponse
    {
        if (authenticatedUser($request)->hasVerifiedEmail()) {
            return redirect()->to($destination->pull(authenticatedUser($request)->type, ['verified' => 1]));
        }

        if (authenticatedUser($request)->markEmailAsVerified()) {
            event(new Verified(authenticatedUser($request)));
        }

        return redirect()->to($destination->pull(authenticatedUser($request)->type, ['verified' => 1]));
    }
}
