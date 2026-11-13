<?php

declare(strict_types = 1);

namespace App\Models;

use App\Casts\Datetime;
use App\Enums\TypeUsers;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use App\Observers\UserObserver;
use App\Traits\HandleRole;
use App\Traits\Models\HasInsensitiveSearch;
use App\Traits\Models\HasTrashedScopes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property int $id
 * @property string $name
 * @property ?int $role_id
 * @property string $email
 * @property ?Carbon $email_verified_at
 * @property string $password
 * @property bool $invitation_pending
 * @property ?string $remember_token
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 * @property string $initials
 * @property string $formatted_name
 * @property TypeUsers $type
 * @property ?Role $role
 */
#[Hidden(['password', 'remember_token'])]
#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements MustVerifyEmail, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasInsensitiveSearch;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use HandleRole;
    use SoftDeletes;
    use HasTrashedScopes;

    /** @var list<string> */
    protected array $auditExclude = ['password', 'remember_token'];

    /** @return MorphMany<Notification, $this> */
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable')->latest();
    }

    /** @param string $token */
    public function sendPasswordResetNotification(mixed $token): void
    {
        $this->notify(new ResetPasswordNotification($token, $this->email));
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    protected function casts(): array
    {
        return [
            'email_verified_at'  => Datetime::class,
            'type'               => TypeUsers::class,
            'password'           => 'hashed',
            'invitation_pending' => 'boolean',
        ];
    }

    // Region relationships

    // Endregion

    // Region accessors
    public function getInitialsAttribute(): string
    {
        return str($this->name)->substr(0, 2)->upper()->toString();
    }

    public function getFormattedNameAttribute(): string
    {
        return $this->name;
    }

    // Endregion

    // Region scopes
    /** @param Builder<static> $query */
    #[Scope]
    protected function admins(Builder $query): void
    {
        $query->where('type', TypeUsers::Admin);
    }

    /** @param Builder<static> $query */
    #[Scope]
    protected function search(Builder $query, ?string $search): void
    {
        if ($search === null || $search === '') {
            return;
        }

        $query->where(function (Builder $query) use ($search): void {
            $this->whereInsensitive($query, 'name', $search);
            $this->orWhereInsensitive($query, 'email', $search);
        });
    }

    // Endregion

    // Region methods
    public function isAdmin(): bool
    {
        return $this->type === TypeUsers::Admin;
    }

    public function isCustomer(): bool
    {
        return $this->type === TypeUsers::Customer;
    }

    public function isUser(): bool
    {
        return $this->type === TypeUsers::User;
    }

    public function isSupportRemSoft(): bool
    {
        return $this->type === TypeUsers::SupportRemSoft;
    }

    // Endregion
}
