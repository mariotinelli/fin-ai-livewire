<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;
use App\Support\Auth\IntendedDestination;

it('preserves a destination only within the authenticated area', function (TypeUsers $type, string $path): void {
    session()->put('url.intended', url($path));
    expect(app(IntendedDestination::class)->pull($type))->toBe(url($path));
    expect(session()->has('url.intended'))->toBeFalse();
})->with([
    [TypeUsers::Customer, '/cliente/meu-perfil?tab=senha'],
    [TypeUsers::Admin, '/admin/gestao/usuarios'],
    [TypeUsers::User, '/admin/dashboard'],
    [TypeUsers::SupportRemSoft, '/suporte/alertas-erros'],
]);

it('rejects unsafe or foreign customer destinations', function (string $path): void {
    $destination = str_starts_with($path, 'http') || str_starts_with($path, '//') ? $path : url($path);
    session()->put('url.intended', $destination);
    expect(app(IntendedDestination::class)->pull(TypeUsers::Customer))->toBe(route('customer.dashboard'));
    expect(session()->has('url.intended'))->toBeFalse();
})->with([
    '/admin/dashboard', '/suporte/meu-perfil', '/cliente-other/page',
    'https://external.example/cliente/dashboard', '//external.example/cliente/dashboard',
    '/cliente/../admin/dashboard', '/cliente/%2e%2e/admin/dashboard',
    '/cliente/%252e%252e/admin/dashboard', '/cliente/%5c../admin/dashboard',
]);

it('uses the contextual fallback when no valid intended URL exists', function (): void {
    session()->put('url.intended', ['invalid']);
    expect(app(IntendedDestination::class)->pull(TypeUsers::Customer, ['verified' => 1]))
        ->toBe(route('customer.dashboard', ['verified' => 1]));
});
