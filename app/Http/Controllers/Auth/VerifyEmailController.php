<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Auth\IntendedDestination;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request, IntendedDestination $destination): RedirectResponse
    {
        $user = DB::transaction(function () use ($request): User {
            $user = User::query()->lockForUpdate()->findOrFail(authenticatedUser($request)->id);
            abort_unless(hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash')), 403);

            if (!$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
                DB::afterCommit(fn () => event(new Verified($user)));
            }

            return $user;
        });

        return redirect()->to($destination->pull($user->type, ['verified' => 1]));
    }
}
