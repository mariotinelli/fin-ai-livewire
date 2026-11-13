<?php

declare(strict_types = 1);

namespace App\Enums;

enum TypeUsers: int
{
    case Admin          = 1;
    case User           = 2;
    case Customer       = 3;
    case SupportRemSoft = 4;

    public function label(): string
    {
        return match ($this) {
            self::Admin          => 'Administrador',
            self::User           => 'Usuário',
            self::Customer       => 'Cliente',
            self::SupportRemSoft => 'Suporte Rem Soft',
        };
    }

    public function canAccessAdminArea(): bool
    {
        return in_array($this, [
            self::Admin,
            self::User,
        ], true);
    }

    /**
     * @return array<int, int>
     */
    public static function adminAreaValues(): array
    {
        return array_values(array_map(
            static fn (self $type): int => $type->value,
            array_filter(self::cases(), static fn (self $type): bool => $type->canAccessAdminArea()),
        ));
    }

    public function canAccessSupportArea(): bool
    {
        return $this === self::SupportRemSoft;
    }

    public function canAccessCustomerArea(): bool
    {
        return $this === self::Customer;
    }

    public function initialRouteName(): string
    {
        return match ($this) {
            self::Admin, self::User => 'admin.dashboard',
            self::SupportRemSoft    => 'support.system-error-alerts.index',
            self::Customer          => 'customer.dashboard',
        };
    }

    public function loginRouteName(): string
    {
        return match ($this) {
            self::SupportRemSoft => 'support.login',
            self::Customer       => 'customer.login',
            default              => 'admin.login',
        };
    }

    public function profileRouteName(): string
    {
        return match ($this) {
            self::SupportRemSoft => 'support.profile.edit',
            self::Customer       => 'customer.profile.edit',
            default              => 'admin.profile.edit',
        };
    }

    public function notificationHistoryRouteName(): string
    {
        return match ($this) {
            self::SupportRemSoft => 'support.notifications.history',
            self::Customer       => 'customer.notifications.history',
            default              => 'admin.notifications.history',
        };
    }

    /** @return array<int, string> */
    public static function toArray(): array
    {
        return [
            self::Admin->value          => 'Administrador',
            self::User->value           => 'Usuário',
            self::Customer->value       => 'Cliente',
            self::SupportRemSoft->value => 'Suporte Rem Soft',
        ];
    }
}
