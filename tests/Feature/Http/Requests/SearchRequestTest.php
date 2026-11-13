<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\RolePermissions;
use App\Enums\Permissions\Management\UserPermissions;
use App\Http\Requests\SearchRequest;
use App\Models\User;
use Illuminate\Routing\Route;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

it('returns 422 for invalid search inputs', function (array $input, string $field): void {
    actingAsAdmin();

    getJson(route('search.users', $input))->assertUnprocessable()->assertJsonValidationErrors($field);
})->with([
    'arbitrary column'       => [['selectedColumn' => 'password'], 'selectedColumn'],
    'column array'           => [['selectedColumn' => ['id']], 'selectedColumn'],
    'empty column'           => [['selectedColumn' => ''], 'selectedColumn'],
    'scalar selection'       => [['selected' => '1'], 'selected'],
    'empty selection scalar' => [['selected' => ''], 'selected'],
    'associative selection'  => [['selected' => ['key' => 1]], 'selected'],
    'oversized selection'    => [['selected' => range(1, 101)], 'selected'],
    'nested selection'       => [['selected' => [[1]]], 'selected.0'],
    'text id'                => [['selected' => ['abc']], 'selected.0'],
    'zero id'                => [['selected' => [0]], 'selected.0'],
    'negative id'            => [['selected' => [-1]], 'selected.0'],
    'decimal id'             => [['selected' => ['1.5']], 'selected.0'],
    'overflow id'            => [['selected' => ['9223372036854775808']], 'selected.0'],
    'empty id'               => [['selected' => ['']], 'selected.0'],
    'duplicate ids'          => [['selected' => [1, '1']], 'selected.0'],
    'search array'           => [['search' => ['a']], 'search'],
    'long search'            => [['search' => str_repeat('a', 256)], 'search'],
    'empty page'             => [['page' => ''], 'page'],
    'zero page'              => [['page' => 0], 'page'],
    'negative page'          => [['page' => -1], 'page'],
    'text page'              => [['page' => 'abc'], 'page'],
    'decimal page'           => [['page' => '1.5'], 'page'],
    'page array'             => [['page' => [1]], 'page'],
    'oversized page'         => [['page' => 100001], 'page'],
]);

it('accepts supported input boundaries', function (array $input): void {
    actingAsAdmin();

    getJson(route('search.users', $input))->assertOk();
})->with([
    [[]],
    [['selected' => [], 'search' => '']],
    [['selectedColumn' => 'id', 'selected' => range(1, 100)]],
    [['search' => str_repeat('a', 255), 'page' => '100000']],
]);

it('allows role lookup for existing consumer permissions', function (BackedEnum $permission): void {
    actingAsUser($permission);

    getJson(route('search.roles'))->assertOk();
})->with([
    RolePermissions::View, RolePermissions::Create, RolePermissions::Edit,
    UserPermissions::View, UserPermissions::Create, UserPermissions::Edit,
]);

it('returns 403 for unrelated permissions', function (BackedEnum $permission): void {
    actingAsUser($permission);

    getJson(route('search.roles'))->assertForbidden();
})->with([UserPermissions::Delete, UserPermissions::Restore]);

it('returns 403 for customers even with permissions', function (string $route): void {
    $user = User::factory()->customer()->create();
    $user->givePermissionTo([UserPermissions::View, RolePermissions::View]);
    actingAs($user);

    getJson(route($route))->assertForbidden();
})->with(['search.users', 'search.roles']);

it('rejects an unauthenticated request at its authorization boundary', function (): void {
    $request = new SearchRequest();
    $request->setRouteResolver(fn (): Route => new Route('GET', 'search/users', [])->name('search.users'));
    $request->setUserResolver(fn (): null => null);

    expect($request->authorize())->toBeFalse();
});

it('returns 422 for invalid alternate selection values', function (string $route, array $input, string $field): void {
    actingAsAdmin();

    getJson(route($route, $input))->assertUnprocessable()->assertJsonValidationErrors($field);
})->with([
    'private column'                => ['search.users', ['selectedColumn' => 'remember_token'], 'selectedColumn'],
    'qualified column'              => ['search.users', ['selectedColumn' => 'users.email'], 'selectedColumn'],
    'expression'                    => ['search.users', ['selectedColumn' => 'lower(email)'], 'selectedColumn'],
    'email unavailable on roles'    => ['search.roles', ['selectedColumn' => 'email'], 'selectedColumn'],
    'initials unavailable on users' => ['search.users', ['selectedColumn' => 'initials'], 'selectedColumn'],
    'long name'                     => ['search.roles', ['selectedColumn' => 'name', 'selected' => [str_repeat('a', 256)]], 'selected.0'],
    'empty name'                    => ['search.roles', ['selectedColumn' => 'name', 'selected' => ['']], 'selected.0'],
    'nested name'                   => ['search.roles', ['selectedColumn' => 'name', 'selected' => [['value']]], 'selected.0'],
    'duplicate names'               => ['search.roles', ['selectedColumn' => 'name', 'selected' => ['Same', 'Same']], 'selected.0'],
    'invalid email'                 => ['search.users', ['selectedColumn' => 'email', 'selected' => ['invalid']], 'selected.0'],
    'invalid initials length'       => ['search.states', ['selectedColumn' => 'initials', 'selected' => ['ABC']], 'selected.0'],
    'too many alternate values'     => ['search.roles', ['selectedColumn' => 'name', 'selected' => array_map(strval(...), range(1, 101))], 'selected'],
]);
