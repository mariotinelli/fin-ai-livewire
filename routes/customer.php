<?php

declare(strict_types = 1);

use App\Http\Middleware\EnsureUserCanAccessCustomerArea;
use App\Livewire\Auth\Profile\EditProfile;
use App\Livewire\Customer\Auth\Login;
use App\Livewire\Notifications\History;
use Illuminate\Support\Facades\Route;

Route::prefix('cliente')->as('customer.')->group(function (): void {
    Route::livewire('login', Login::class)->middleware('guest')->name('login');

    Route::middleware(['auth', EnsureUserCanAccessCustomerArea::class])->group(function (): void {
        Route::view('dashboard', 'dashboard')->name('dashboard');
        Route::livewire('meu-perfil', EditProfile::class)->name('profile.edit');
        Route::livewire('notificacoes', History::class)->name('notifications.history');
    });
});
