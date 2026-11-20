<?php

declare(strict_types = 1);

use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('cliente/cadastro', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('cliente/cadastro', [RegisteredUserController::class, 'store'])->middleware('throttle:registration')->name('register.store');

    Route::livewire('esqueci-minha-senha', ForgotPassword::class)->name('password.forgot');
    Route::livewire('nova-senha/{token}', ResetPassword::class)->name('password.reset');
});

Route::redirect('/login', '/cliente/login');

Route::middleware('auth')->group(function (): void {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:verification-mail')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
});
