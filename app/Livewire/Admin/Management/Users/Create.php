<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Management\Users;

use App\Actions\Users\CreateInvitedUser;
use App\Enums\TypeUsers;
use App\Models\Role;
use App\Models\User;
use App\Traits\Components\WithModal;
use App\Traits\Components\WithToast;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    use WithModal;
    use WithToast;

    public ?User $user = null;

    public function render(): View
    {
        return view('livewire.admin.management.users.create');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'user.name'    => ['required', 'string', 'min:3', 'max:191'],
            'user.email'   => ['required', 'email', 'unique:users,email', 'max:191'],
            'user.role_id' => ['required', 'exists:roles,id'],
        ];
    }

    public function mount(): void
    {
        $this->user = new User();
    }

    public function loadUser(): void
    {
        $this->authorize('create', User::class);

        $this->user = new User();

        $this->openModal();
    }

    public function save(CreateInvitedUser $createInvitedUser): void
    {
        $this->authorize('create', User::class);

        $this->validate();
        abort_unless($this->user instanceof User, 404);

        $role = Role::query()->findOrFail($this->user->role_id);

        $this->authorize('create', [User::class, $role]);

        try {
            $createInvitedUser->handle(
                userData: [
                    'name'    => $this->user->name,
                    'email'   => $this->user->email,
                    'type'    => TypeUsers::User,
                    'role_id' => $this->user->role_id,
                ],
            );
        } catch (UniqueConstraintViolationException $uniqueConstraintViolationException) {
            if (!str_contains($uniqueConstraintViolationException->getMessage(), 'users_email_unique')) {
                throw $uniqueConstraintViolationException;
            }

            throw ValidationException::withMessages(['user.email' => 'Este e-mail já está cadastrado.']);
        }

        $this->closeModal();

        $this->toast('Usuário cadastrado com sucesso');

        $this->dispatch('users::refresh');
    }
}
