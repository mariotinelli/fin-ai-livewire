<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Management\Users;

use App\Enums\TypeUsers;
use App\Models\User;
use App\Traits\Components\WithModal;
use App\Traits\Components\WithToast;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Restore extends Component
{
    use WithToast;
    use WithModal;

    public ?User $user = null;

    public function render(): View
    {
        return view('livewire.admin.management.users.restore');
    }

    #[On('users::restore')]
    public function loadUser(int $id): void
    {
        $this->user = User::withTrashed()->where('type', TypeUsers::User)->findOrFail($id);

        $this->authorize('restore', $this->user);

        $this->openModal();
    }

    public function restore(): void
    {
        $this->user = User::withTrashed()->where('type', TypeUsers::User)->findOrFail($this->user?->id);

        $this->authorize('restore', $this->user);

        $this->user->restore();

        $this->closeModal();

        $this->toast('Usuário ativado com sucesso');

        $this->dispatch('users::refresh');
    }
}
