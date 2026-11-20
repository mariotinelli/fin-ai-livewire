<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\VerificationPublicationFailed;
use App\Http\Controllers\Controller;
use App\Support\Auth\IntendedDestination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request, IntendedDestination $destination): RedirectResponse
    {
        if (authenticatedUser($request)->hasVerifiedEmail()) {
            return redirect()->to($destination->pull(authenticatedUser($request)->type));
        }

        try {
            authenticatedUser($request)->sendEmailVerificationNotification();
        } catch (VerificationPublicationFailed $verificationPublicationFailed) {
            report($verificationPublicationFailed);

            return to_route('verification.notice')->with('status', 'verification-link-failed');
        }

        return to_route('verification.notice')->with('status', 'verification-link-sent');
    }
}
