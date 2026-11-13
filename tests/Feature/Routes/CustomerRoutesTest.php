<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('redirects customer area guests to the customer login', function (string $route): void {
    get(route($route))->assertRedirect(route('customer.login'));
})->with(['customer.dashboard', 'customer.profile.edit']);

it('isolates customer pages and contextual legacy destinations', function (): void {
    actingAs(User::factory()->customer()->create());
    get(route('customer.dashboard'))->assertOk();
    get(route('customer.profile.edit'))->assertOk()->assertSee(route('customer.profile.edit'));
    get('/dashboard')->assertRedirect(route('customer.dashboard'));
    get('/perfil')->assertRedirect(route('customer.profile.edit'));
    get('/')->assertRedirect(route('customer.dashboard'));
    get(route('customer.login'))->assertRedirect(route('customer.dashboard'));
    get(route('admin.dashboard'))->assertForbidden();
    get(route('support.system-error-alerts.index'))->assertForbidden();
});

it('forbids internal users from customer pages', function (TypeUsers $type): void {
    actingAs(User::factory()->create(['type' => $type]));
    get(route('customer.dashboard'))->assertForbidden();
    get(route('customer.profile.edit'))->assertForbidden();
})->with([TypeUsers::Admin, TypeUsers::User, TypeUsers::SupportRemSoft]);

it('rechecks customer access on an existing Livewire profile request', function (): void {
    $customer = User::factory()->customer()->create();
    actingAs($customer);
    $response = get(route('customer.profile.edit'))->assertOk();
    preg_match_all('/wire:snapshot="([^"]+)"/', $response->getContent(), $matches);
    $snapshot = collect($matches[1])->map(fn (string $encoded): string => html_entity_decode($encoded, ENT_QUOTES))
        ->first(fn (string $encoded): bool => json_decode($encoded, true)['memo']['name'] === 'auth.profile.edit-profile');
    expect($snapshot)->toBeString();
    $customer->update(['type' => TypeUsers::Admin]);
    Gate::before(fn (): bool => true);

    $this->postJson(Livewire::getUpdateUri(), ['components' => [[
        'snapshot' => $snapshot, 'updates' => [],
        'calls'    => [['method' => '$refresh', 'params' => [], 'path' => '']],
    ]]], ['X-Livewire' => 'true'])->assertForbidden();
});
