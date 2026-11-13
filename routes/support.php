<?php

declare(strict_types = 1);

use App\Http\Middleware\EnsureUserCanAccessSupportArea;
use App\Http\Middleware\RestrictByIp;
use App\Livewire\Auth\Profile\EditProfile;
use App\Livewire\Notifications\History;
use App\Livewire\Support\ArtisanCommands;
use App\Livewire\Support\Auth\Login;
use App\Livewire\Support\SystemErrorAlerts;
use App\Models\CommandExecution;
use App\Models\SystemErrorAlert;
use Illuminate\Support\Facades\Route;

Route::prefix('suporte')->as('support.')->group(function (): void {
    Route::livewire('login', Login::class)->middleware('guest')->name('login');

    Route::middleware(['auth', EnsureUserCanAccessSupportArea::class])->group(function (): void {
        Route::livewire('meu-perfil', EditProfile::class)->name('profile.edit');
        Route::livewire('notificacoes', History::class)->name('notifications.history');
        Route::livewire('alertas-erros', SystemErrorAlerts\Index::class)
            ->can('viewAny', SystemErrorAlert::class)->name('system-error-alerts.index');
        Route::livewire('alertas-erros/{systemErrorAlert}', SystemErrorAlerts\Show::class)
            ->can('view', 'systemErrorAlert')->name('system-error-alerts.show');
        Route::livewire('executor-artisan', ArtisanCommands\Index::class)
            ->middleware(RestrictByIp::class)->can('viewAny', CommandExecution::class)->name('artisan-commands.index');
    });
});

Route::redirect('/admin/suporte-rem-soft/alertas-erros', '/suporte/alertas-erros', 302);
Route::get('/admin/suporte-rem-soft/alertas-erros/{id}', fn (string $id) => to_route('support.system-error-alerts.show', ['systemErrorAlert' => $id]));
Route::redirect('/admin/suporte-rem-soft/executor-artisan', '/suporte/executor-artisan', 302);
