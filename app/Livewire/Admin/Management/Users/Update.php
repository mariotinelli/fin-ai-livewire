<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Management\Users;

use App\Actions\Users\UpdateUser;
use App\Enums\TypeUsers;
use App\Models\Role;
use App\Models\User;
use App\Traits\Components\WithModal;
use App\Traits\Components\WithToast;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use WithModal;
    use WithToast;

    public ?User $user = null;

    public function render(): View
    {
        return view('livewire.admin.management.users.update');
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'user.name'    => ['required', 'string', 'min:3', 'max:191'],
            'user.email'   => ['required', 'email', 'max:191', 'unique:users,email,' . $this->user?->id],
            'user.role_id' => ['required', 'exists:roles,id'],
        ];
    }

    public function mount(): void
    {
        $this->user = new User();
    }

    #[On('users::update')]
    public function loadUser(int $userId): void
    {
        $this->user = User::withTrashed()->where('type', TypeUsers::User)->with('role')->findOrFail($userId);

        $this->authorize('update', $this->user);

        $this->openModal();
    }

    public function save(UpdateUser $updateUser): void
    {
        $user = User::withTrashed()->where('type', TypeUsers::User)->findOrFail($this->user?->id);

        $this->authorize('update', $user);

        $this->validate();
        abort_unless($this->user instanceof User, 404);

        $role = Role::query()->findOrFail($this->user->role_id);

        $this->authorize('update', [$user, $role]);

        $updateUser->handle(
            user: $user,
            userData: [
                'name'    => $this->user->name,
                'email'   => $this->user->email,
                'type'    => $user->type,
                'role_id' => $this->user->role_id,
            ],
        );

        $this->closeModal();

        $this->toast('Usuário atualizado com sucesso');

        $this->dispatch('users::refresh');
    }
}
