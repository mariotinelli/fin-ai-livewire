<?php

declare(strict_types = 1);

use App\Enums\TypeUsers;

it('returns expected labels for each user type', function (): void {
    expect(TypeUsers::Admin->label())->toBe('Administrador')
        ->and(TypeUsers::User->label())->toBe('Usuário')
        ->and(TypeUsers::Customer->label())->toBe('Cliente')
        ->and(TypeUsers::SupportRemSoft->label())->toBe('Suporte Rem Soft');
});

it('returns user types as array', function (): void {
    expect(TypeUsers::toArray())->toBe([
        1 => 'Administrador',
        2 => 'Usuário',
        3 => 'Cliente',
        4 => 'Suporte Rem Soft',
    ]);
});

it('identifies the user types allowed in the admin area', function (): void {
    expect(TypeUsers::Admin->canAccessAdminArea())->toBeTrue()
        ->and(TypeUsers::User->canAccessAdminArea())->toBeTrue()
        ->and(TypeUsers::SupportRemSoft->canAccessAdminArea())->toBeFalse()
        ->and(TypeUsers::Customer->canAccessAdminArea())->toBeFalse()
        ->and(TypeUsers::adminAreaValues())->toBe([
            TypeUsers::Admin->value,
            TypeUsers::User->value,
        ]);
});

it('maps each user type to its own authentication destinations', function (TypeUsers $type, string $home, string $login, string $profile, bool $customer): void {
    expect($type->initialRouteName())->toBe($home);
    expect($type->loginRouteName())->toBe($login);
    expect($type->profileRouteName())->toBe($profile);
    expect($type->canAccessCustomerArea())->toBe($customer);
})->with([
    [TypeUsers::Admin, 'admin.dashboard', 'admin.login', 'admin.profile.edit', false],
    [TypeUsers::User, 'admin.dashboard', 'admin.login', 'admin.profile.edit', false],
    [TypeUsers::Customer, 'customer.dashboard', 'customer.login', 'customer.profile.edit', true],
    [TypeUsers::SupportRemSoft, 'support.system-error-alerts.index', 'support.login', 'support.profile.edit', false],
]);

it('maps notification history to each localized application area', function (TypeUsers $type, string $route): void {
    expect($type->notificationHistoryRouteName())->toBe($route);
})->with([
    [TypeUsers::Admin, 'admin.notifications.history'], [TypeUsers::User, 'admin.notifications.history'],
    [TypeUsers::Customer, 'customer.notifications.history'], [TypeUsers::SupportRemSoft, 'support.notifications.history'],
]);
