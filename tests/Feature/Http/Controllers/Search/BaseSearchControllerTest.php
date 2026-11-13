<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Http\Controllers\Search\BaseSearchController;
use App\Http\Requests\SearchRequest;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\getJson;

it('searches collated names without accents and treats wildcard characters literally', function (string $search): void {
    actingAsAdmin();
    $matching = User::factory()->user()->create(['name' => 'João 100%_']);
    User::factory()->user()->create(['name' => 'João 100 reais']);

    getJson(route('search.users', ['search' => $search]))
        ->assertJsonPath('data', [['id' => $matching->id, 'name' => $matching->name]])
        ->assertJsonPath('meta.total', 1);
})->with(['joao 100%_', 'JOÃO 100%_']);

it('preserves search type and soft delete scopes when reincluding selected options', function (string $column): void {
    actingAsAdmin();
    $selected = User::factory()->user()->create(['name' => 'Match selected']);
    $other    = User::factory()->user()->create(['name' => 'Other']);
    $customer = User::factory()->customer()->create(['name' => 'Match customer']);
    $admin    = User::factory()->admin()->create(['name' => 'Match admin']);
    $support  = User::factory()->create(['name' => 'Match support', 'type' => TypeUsers::SupportRemSoft]);
    $deleted  = User::factory()->user()->create(['name' => 'Match deleted']);
    $deleted->delete();

    $option = User::factory()->user()->create(['name' => 'Match option']);

    getJson(route('search.users', [
        'search'         => 'Match',
        'selectedColumn' => $column,
        'selected'       => [
            $selected->getAttribute($column), $other->getAttribute($column),
            $customer->getAttribute($column), $admin->getAttribute($column),
            $support->getAttribute($column), $deleted->getAttribute($column),
            $column === 'id' ? 2147483647 : 'missing@example.com',
        ],
    ]))->assertOk()->assertJsonPath('data', [
        ['id' => $selected->id, 'name' => 'Match selected'],
        ['id' => $option->id, 'name' => 'Match option'],
    ])->assertJsonPath('meta.total', 1)->assertJsonPath('meta.per_page', 10);
})->with(['id', 'name', 'email']);

it('keeps selected options out of explicitly requested pages', function (string $column): void {
    actingAsAdmin();
    $selected = User::factory()->user()->create(['name' => 'Selected']);
    User::factory()->user()->count(11)->create();

    getJson(route('search.users', ['selectedColumn' => $column, 'selected' => [$selected->getAttribute($column)], 'page' => 2]))
        ->assertOk()->assertJsonCount(1, 'data')
        ->assertJsonMissing(['id' => $selected->id, 'name' => 'Selected'])
        ->assertJsonPath('meta.total', 11)->assertJsonPath('meta.current_page', 2);
})->with(['id', 'name', 'email']);

it('orders equal names consistently and merges each selected record only once', function (): void {
    actingAsAdmin();
    $first  = User::factory()->user()->create(['name' => 'Same']);
    $second = User::factory()->user()->create(['name' => 'Same']);

    getJson(route('search.users', ['selected' => [$second->id]]))
        ->assertOk()->assertJsonPath('data', [
            ['id' => $second->id, 'name' => 'Same'],
            ['id' => $first->id, 'name' => 'Same'],
        ]);
});

it('searches and orders by the column selected by a generated controller', function (): void {
    $matching = State::factory()->create(['name' => 'Paraná', 'initials' => 'PR']);
    State::factory()->create(['name' => 'Praia Grande', 'initials' => 'SC']);

    $request = SearchRequest::create('/', 'GET', ['search' => 'PR']);
    $request->setValidator(Validator::make($request->all(), [
        'search' => ['sometimes', 'nullable', 'string'],
    ]));

    $controller = new class () extends BaseSearchController {
        /** @param Builder<State> $query */
        public function options(Builder $query, SearchRequest $request): LengthAwarePaginator
        {
            return $this->getOptions($query, $request, 'initials');
        }
    };

    $options = $controller->options(State::query(), $request);

    expect($options->pluck('id')->all())->toBe([$matching->id]);
});

it('preserves query parameters and stable ordering when following the next page', function (): void {
    actingAsAdmin();
    $users    = User::factory()->user()->count(22)->create(['name' => 'Match']);
    $selected = $users->first();
    $response = getJson(route('search.users', [
        'search' => 'Match', 'selectedColumn' => 'email', 'selected' => [$selected->email],
        'region' => '0', 'categories' => ['2', '3'],
    ]))->assertOk()->assertJsonPath('meta.per_page', 10)->assertJsonPath('meta.total', 21)->assertJsonCount(11, 'data');

    $next = $response->json('links.next');
    parse_str((string) parse_url($next, PHP_URL_QUERY), $query);
    expect($query)->toMatchArray([
        'search' => 'Match', 'selectedColumn' => 'email', 'selected' => [$selected->email],
        'region' => '0', 'categories' => ['2', '3'], 'page' => '2',
    ]);

    $second = getJson($next)->assertOk()->assertJsonPath('meta.per_page', 10)->assertJsonCount(10, 'data');
    expect(array_column($second->json('data'), 'id'))->toBe($users->pluck('id')->slice(11, 10)->values()->all());
    expect(array_column($second->json('data'), 'id'))->not->toContain($selected->id);
});

it('groups custom search conditions without escaping caller filters or soft deletes', function (?string $search): void {
    $byName    = User::factory()->user()->create(['name' => 'Allowed needle', 'email' => 'first@example.com']);
    $byEmail   = User::factory()->user()->create(['name' => 'Allowed email', 'email' => 'needle@example.com']);
    $unrelated = User::factory()->user()->create(['name' => 'Allowed unrelated', 'email' => 'unrelated@example.com']);
    $outside   = User::factory()->user()->create(['name' => 'Outside scope', 'email' => 'needle-outside@example.com']);
    $customer  = User::factory()->customer()->create(['name' => 'Allowed customer', 'email' => 'needle-customer@example.com']);
    $deleted   = User::factory()->user()->create(['name' => 'Allowed deleted', 'email' => 'needle-deleted@example.com']);
    $deleted->delete();

    $request = SearchRequest::create('/', 'GET', [
        'search' => $search, 'selected' => [$byEmail->id, $outside->id, $customer->id, $deleted->id],
    ]);
    $request->setValidator(Validator::make($request->all(), [
        'search' => ['nullable', 'string'], 'selected' => ['array'],
    ]));
    $controller = new class () extends BaseSearchController {
        /** @param Builder<User> $query */
        public function options(Builder $query, SearchRequest $request, Closure $callback): LengthAwarePaginator
        {
            return $this->getOptions($query, $request, searchCallback: $callback);
        }
    };
    $calls    = 0;
    $callback = function (Builder $query, string $term) use (&$calls): void {
        $calls++;
        $query->whereInsensitive('name', $term)->orWhere('email', 'like', '%' . $term . '%');
    };

    $options = $controller->options(User::query()->where('type', TypeUsers::User)->where('name', 'like', 'Allowed%'), $request, $callback);

    expect($options->pluck('id')->all())->toBe($search === 'needle' ? [$byEmail->id, $byName->id] : [$byEmail->id, $byName->id, $unrelated->id]);
    expect($calls)->toBe($search === 'needle' ? 1 : 0);
    expect($options->perPage())->toBe(10);
})->with(['needle', '', null]);

it('reinserts only the lowest eligible ID for each selected name', function (): void {
    actingAsAdmin();
    User::factory()->customer()->create(['name' => 'Match selected']);
    $deleted = User::factory()->user()->create(['name' => 'Match selected']);
    $deleted->delete();

    $first = User::factory()->user()->create(['name' => 'Match selected']);
    User::factory()->user()->create(['name' => 'Match selected']);
    $option = User::factory()->user()->create(['name' => 'Match other']);

    getJson(route('search.users', ['selectedColumn' => 'name', 'selected' => ['Match selected'], 'search' => 'Match']))
        ->assertOk()->assertJsonPath('data', [
            ['id' => $first->id, 'name' => 'Match selected'],
            ['id' => $option->id, 'name' => 'Match other'],
        ])->assertJsonPath('meta.total', 1);
});

it('caps reinclusion at one hundred selectable values while keeping ten paginated options', function (string $column): void {
    actingAsAdmin();
    $role  = Role::factory()->create(['name' => 'Options lookup role']);
    $users = User::factory()->user()->count(200)->sequence(fn ($sequence): array => [
        'name' => 'Selected ' . str_pad((string) intdiv($sequence->index, 2), 3, '0', STR_PAD_LEFT),
    ])->create(['role_id' => $role->id]);
    User::factory()->user()->count(10)->create(['name' => 'Option', 'role_id' => $role->id]);
    $selected = $column === 'id' ? $users->take(100)->pluck('id')->all() : $users->pluck('name')->unique()->values()->all();

    $response = getJson(route('search.users', ['selectedColumn' => $column, 'selected' => $selected]))
        ->assertOk()->assertJsonCount(110, 'data')->assertJsonPath('meta.per_page', 10);

    $reinserted = array_slice($response->json('data'), 0, 100);
    expect(array_unique(array_column($reinserted, $column)))->toHaveCount(100);
    $expected = $column === 'id' ? $users->take(100)->pluck('id')->all() : $users->filter(fn ($user, int $index): bool => $index % 2 === 0)->pluck('id')->values()->all();
    expect(array_column($reinserted, 'id'))->toBe($expected);
    $page = getJson(route('search.users', ['selectedColumn' => $column, 'selected' => $selected, 'page' => 2]))->assertOk();
    expect(array_intersect(array_column($page->json('data'), 'id'), array_column($reinserted, 'id')))->toBeEmpty();
})->with(['id', 'name']);

it('selects representatives within all caller constraints even with an explicit projection', function (): void {
    $outside = User::factory()->user()->create(['name' => 'Same']);
    $first   = User::factory()->user()->create(['name' => 'Same']);
    User::factory()->user()->create(['name' => 'Same']);
    $request = SearchRequest::create('/', 'GET', ['selected' => ['Same'], 'selectedColumn' => 'name']);
    $request->setValidator(Validator::make($request->all(), ['selected' => ['array'], 'selectedColumn' => ['in:name']]));

    $controller = new class () extends BaseSearchController {
        /** @param Builder<User> $query */
        public function options(Builder $query, SearchRequest $request): LengthAwarePaginator
        {
            return $this->getOptions($query, $request);
        }
    };

    $options = $controller->options(User::query()->select(['users.id', 'users.name'])->where('id', '>', $outside->id), $request);

    expect($options->pluck('id')->all())->toBe([$first->id]);
});
