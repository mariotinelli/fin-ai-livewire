<?php

declare(strict_types = 1);

use App\Enums\Permissions\Management\UserPermissions;
use App\Enums\TypeUsers;
use App\Models\User;
use Illuminate\Testing\TestResponse;

use function Pest\Laravel\getJson;

function getUsers(array $params = []): TestResponse
{
    return getJson(route('search.users', $params));
}

it('should get get users', function (): void {
    actingAsAdmin();
    getUsers()->assertOk();
});

it('should return a paginated list of users', function (): void {
    actingAsAdmin();
    User::factory()->user()->count(20)->create();

    getUsers()
        ->assertJsonCount(10, 'data')
        ->assertJsonPath('meta.current_page', 1)
        ->assertJsonPath('meta.per_page', 10)
        ->assertJsonPath('meta.total', 20);
});

it('should be able to get next page', function (): void {
    actingAsAdmin();
    User::factory()->user()->count(20)->create();

    getUsers(['page' => 2])
        ->assertJsonCount(10, 'data')
        ->assertJsonPath('meta.current_page', 2)
        ->assertJsonPath('meta.per_page', 10)
        ->assertJsonPath('meta.total', 20);
});

it('should return id and name of users', function (): void {
    actingAsAdmin();
    /** @var User $user */
    $user = User::factory()->user()->create();

    getUsers()
        ->assertJsonPath('data.0', [
            'id'   => $user->id,
            'name' => $user->name,
        ]);
});

it('should be able to search a particular user', function (): void {
    actingAsAdmin();
    $name = 'João ' . random_int(1, 999);

    User::factory()->user()->create(['name' => $name]);

    User::factory()->user()->count(20)->create();

    getUsers(['search' => $name])
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('meta.current_page', 1)
        ->assertJsonPath('meta.per_page', 10)
        ->assertJsonPath('meta.total', 1);
});

it('returns 401 for guests', function (): void {
    getUsers()->assertUnauthorized();
});

it('returns 403 without user view permission', function (): void {
    actingAsUser();

    getUsers()->assertForbidden();
});

it('allows user view permission and only lists regular users', function (): void {
    actingAsUser(UserPermissions::View);
    $user = User::factory()->user()->create(['name' => 'Visible']);
    User::factory()->customer()->create(['name' => 'Visible customer']);
    User::factory()->admin()->create(['name' => 'Visible admin']);
    User::factory()->create(['name' => 'Visible support', 'type' => TypeUsers::SupportRemSoft]);

    getUsers(['search' => 'Visible'])->assertOk()
        ->assertJsonPath('data', [['id' => $user->id, 'name' => 'Visible']]);
});

it('returns 422 for an invalid selection', function (): void {
    actingAsAdmin();

    getUsers(['selected' => '1'])->assertUnprocessable()->assertJsonValidationErrors('selected');
});
