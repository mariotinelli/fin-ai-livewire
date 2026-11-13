<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Models\SystemErrorAlert;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('redirects guests to contextual support login', function (string $route): void {
    get(route($route))->assertRedirect(route('support.login'));
})->with(['support.profile.edit', 'support.system-error-alerts.index', 'support.artisan-commands.index']);

it('keeps support profile home and login destinations consistent', function (): void {
    $user = User::factory()->create(['type' => TypeUsers::SupportRemSoft]);
    actingAs($user);
    get(route('support.profile.edit'))->assertOk()->assertSee(route('support.profile.edit'));
    get(route('home'))->assertRedirect(route('support.system-error-alerts.index'));
    get(route('support.login'))->assertRedirect(route('support.system-error-alerts.index'));
    get(route('admin.login'))->assertRedirect(route('support.system-error-alerts.index'));
    get(route('admin.dashboard'))->assertForbidden();
});

it('denies other types direct support access', function (TypeUsers $type): void {
    actingAs(User::factory()->create(['type' => $type]));
    get(route('support.profile.edit'))->assertForbidden();
    get(route('support.system-error-alerts.index'))->assertForbidden();
    get(route('support.artisan-commands.index'))->assertForbidden();
})->with([TypeUsers::Admin, TypeUsers::User, TypeUsers::Customer]);

it('redirects legacy URLs to protected support destinations', function (): void {
    $alert = SystemErrorAlert::factory()->create();
    get('/admin/suporte-rem-soft/alertas-erros')->assertRedirect(route('support.system-error-alerts.index'));
    get('/admin/suporte-rem-soft/alertas-erros/' . $alert->id)->assertRedirect(route('support.system-error-alerts.show', $alert));
    get('/admin/suporte-rem-soft/executor-artisan')->assertRedirect(route('support.artisan-commands.index'));
    get(route('support.system-error-alerts.show', $alert))->assertRedirect(route('support.login'));
});
