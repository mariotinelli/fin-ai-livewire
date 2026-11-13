<?php

declare(strict_types = 1);

use App\Http\Middleware\EnsureUserCanAccessAdminArea;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Management;
use App\Livewire\Auth\Profile\EditProfile;
use App\Livewire\Notifications\History;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->as('admin.')
    ->group(function (): void {
        Route::middleware('guest')->group(function (): void {
            Route::livewire('login', Login::class)->name('login');
        });

        Route::middleware(['auth', EnsureUserCanAccessAdminArea::class])->group(function (): void {
            Route::livewire('meu-perfil', EditProfile::class)->name('profile.edit');
            Route::livewire('notificacoes', History::class)->name('notifications.history');
            Route::get('/dashboard', fn (): Factory | \Illuminate\Contracts\View\View => view('dashboard'))->name('dashboard');

            Route::prefix('gestao')
                ->as('management.')
                ->group(function (): void {
                    Route::prefix('perfis')
                        ->as('roles.')
                        ->group(function (): void {
                            Route::livewire('/', Management\Roles\Index::class)
                                ->can('viewAny', Role::class)
                                ->name('index');
                        });

                    Route::prefix('usuarios')
                        ->as('users.')
                        ->group(function (): void {
                            Route::livewire('/', Management\Users\Index::class)
                                ->can('viewAny', User::class)
                                ->name('index');
                        });
                });

        });
    });
