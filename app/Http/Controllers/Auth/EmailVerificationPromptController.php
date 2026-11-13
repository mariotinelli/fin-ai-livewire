<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\Auth\IntendedDestination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    public function __invoke(Request $request, IntendedDestination $destination): RedirectResponse | View
    {
        return authenticatedUser($request)->hasVerifiedEmail()
                    ? redirect()->to($destination->pull(authenticatedUser($request)->type))
                    : view('auth.verify-email');
    }
}
