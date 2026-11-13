<?php

declare(strict_types = 1);

use App\Models\State;

use function Pest\Laravel\getJson;

it('preserves public state lookup and its paginated id name contract', function (): void {
    $state = State::factory()->create(['name' => 'Paraná']);

    getJson(route('search.states'))->assertOk()
        ->assertJsonPath('data', [['id' => $state->id, 'name' => 'Paraná']])
        ->assertJsonStructure(['data', 'links', 'meta'])
        ->assertJsonPath('meta.per_page', 10);
});

it('validates state selection and preserves its search filter', function (): void {
    $state = State::factory()->create(['name' => 'Paraná']);

    getJson(route('search.states', ['selected' => [$state->id], 'search' => 'Santa']))
        ->assertOk()->assertJsonCount(0, 'data');
});

it('returns 422 for an arbitrary state selection column', function (): void {
    getJson(route('search.states', ['selectedColumn' => 'region_id']))
        ->assertUnprocessable()->assertJsonValidationErrors('selectedColumn');
});

it('selects states by an alternate column and preserves the id name response', function (string $column): void {
    $state = State::factory()->create(['name' => 'Paraná', 'initials' => 'PR']);

    getJson(route('search.states', ['selectedColumn' => $column, 'selected' => [$state->getAttribute($column)]]))
        ->assertOk()->assertJsonPath('data', [['id' => $state->id, 'name' => 'Paraná']])
        ->assertJsonPath('meta.total', 0);
})->with(['name', 'initials']);
