<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Validator;

beforeEach(function (): void {
    app()->setLocale('pt_BR');
});

it('uses readable names for generic and nested fields while preserving the error keys', function (string $field, string $label): void {
    $validator = Validator::make([], [$field => ['required']]);

    expect($validator->errors()->keys())->toBe([$field])
        ->and($validator->errors()->first($field))->toBe('O campo ' . $label . ' é obrigatório.');
})->with([
    ['current_password', 'senha atual'], ['password_confirmation', 'confirmação da senha'],
    ['name', 'nome'], ['user.name', 'nome'], ['user.email', 'e-mail'], ['user.role_id', 'perfil'],
    ['phone', 'telefone'], ['user_id', 'usuário'], ['city_id', 'cidade'], ['address.city_id', 'cidade'],
    ['search', 'busca'], ['page', 'página'], ['perPage', 'itens por página'],
    ['filters', 'filtros'], ['filterDraft', 'filtros'],
    ['filters.roles', 'perfis'], ['filterDraft.roles', 'perfis'],
    ['filters.status', 'situação'], ['filterDraft.status', 'situação'],
    ['filterDraft.severity', 'gravidade'], ['filterDraft.environment', 'ambiente'],
]);

it('keeps readable positions and filter context in wildcard validation messages', function (): void {
    $validator = Validator::make([
        'selectedPermissions' => [false, 42],
        'filterDraft'         => ['roles' => ['invalid', 'invalid']],
        'items'               => [['name' => ''], ['name' => '']],
    ], [
        'selectedPermissions.*' => ['string'],
        'filterDraft.roles.*'   => ['integer'],
        'items.*.name'          => ['required'],
    ]);

    expect($validator->errors()->first('selectedPermissions.0'))->toContain('permissão #1')
        ->and($validator->errors()->first('selectedPermissions.1'))->toContain('permissão #2')
        ->and($validator->errors()->first('filterDraft.roles.0'))->toContain('perfil #1 dos filtros')
        ->and($validator->errors()->first('filterDraft.roles.1'))->toContain('perfil #2 dos filtros')
        ->and($validator->errors()->first('items.0.name'))->toContain('nome do item #1')
        ->and($validator->errors()->first('items.1.name'))->toContain('nome do item #2');
});

it('keeps item requirements generic and interpolates the requested minimum', function (): void {
    $required = Validator::make([], ['items' => ['required', 'array']]);
    $minimum  = Validator::make(['items' => ['one']], ['items' => ['array', 'min:3']]);

    expect($required->errors()->first('items'))->toBe('Adicione pelo menos um item.')
        ->and($minimum->errors()->first('items'))->toBe('Adicione pelo menos 3 itens.');
});

it('preserves the existing permission requirement and allows consumer-specific messages and names', function (): void {
    $permissions = Validator::make([], ['selectedPermissions' => ['required']]);
    $custom      = Validator::make([], ['items' => ['required']], ['items.required' => 'Inclua linhas neste documento.']);
    $attributes  = Validator::make([], ['phone' => ['required']], attributes: ['phone' => 'telefone de contato']);

    expect($permissions->errors()->first('selectedPermissions'))->toBe('Você deve selecionar pelo menos uma permissão.')
        ->and($custom->errors()->first('items'))->toBe('Inclua linhas neste documento.')
        ->and($attributes->errors()->first('phone'))->toBe('O campo telefone de contato é obrigatório.');
});
