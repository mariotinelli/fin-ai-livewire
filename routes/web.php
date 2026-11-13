<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => to_route(user()?->type->initialRouteName() ?? 'dashboard'))->name('home');

Route::get('/dashboard', fn () => to_route(authenticatedUser()->type->initialRouteName()))->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function (): void {
    Route::get('/perfil', fn () => to_route(authenticatedUser()->type->profileRouteName()))->name('profile.edit');
});

require __DIR__ . '/auth.php';

require __DIR__ . '/search.php';

require __DIR__ . '/admin.php';

require __DIR__ . '/support.php';

require __DIR__ . '/customer.php';
