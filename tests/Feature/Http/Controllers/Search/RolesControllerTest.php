<?php

declare(strict_types = 1);

use App\Models\Role;

use function Pest\Laravel\getJson;

it('returns paginated roles resource', function (): void {
    actingAsAdmin();
    Role::factory()->create(['name' => 'Admin']);
    Role::factory()->create(['name' => 'Operator']);

    getJson('/search/roles')
        ->assertSuccessful()
        ->assertJsonStructure(['data', 'links', 'meta']);
});

it('filters roles by search and excludes selected ids', function (): void {
    actingAsAdmin();
    $admin    = Role::factory()->create(['name' => 'Admin']);
    $operator = Role::factory()->create(['name' => 'Operator']);

    getJson('/search/roles?search=Admin&selected[]=' . $operator->id . '&page=1')
        ->assertSuccessful()
        ->assertJsonFragment(['id' => $admin->id, 'name' => 'Admin'])
        ->assertJsonMissing(['id' => $operator->id, 'name' => 'Operator']);
});

it('returns selected roles merged when selected is sent without page', function (): void {
    actingAsAdmin();
    $selected = Role::factory()->create(['name' => 'Selected']);

    getJson('/search/roles?selected[]=' . $selected->id)
        ->assertSuccessful()
        ->assertJsonFragment(['id' => $selected->id, 'name' => 'Selected']);
});

it('returns 401 for guests', function (): void {
    getJson(route('search.roles'))->assertUnauthorized();
});

it('returns 403 without a consumer permission', function (): void {
    actingAsUser();

    getJson(route('search.roles'))->assertForbidden();
});

it('returns 422 for an arbitrary column', function (): void {
    actingAsAdmin();

    getJson(route('search.roles', ['selectedColumn' => 'description']))
        ->assertUnprocessable()->assertJsonValidationErrors('selectedColumn');
});

it('does not reinclude a selected role outside the search filter', function (): void {
    actingAsAdmin();
    $role = Role::factory()->create(['name' => 'Other']);

    getJson(route('search.roles', ['search' => 'Missing', 'selected' => [$role->id]]))
        ->assertOk()->assertJsonCount(0, 'data');
});

it('selects roles by name without duplication and preserves the id name response', function (): void {
    actingAsAdmin();
    $role = Role::factory()->create(['name' => 'Selected role']);

    getJson(route('search.roles', ['selectedColumn' => 'name', 'selected' => [$role->name]]))
        ->assertOk()->assertJsonPath('data', [['id' => $role->id, 'name' => $role->name]])
        ->assertJsonPath('meta.total', 0);
});
