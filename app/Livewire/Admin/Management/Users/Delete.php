<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Management\Users;

use App\Actions\Users\DeleteUser;
use App\Enums\TypeUsers;
use App\Models\User;
use App\Traits\Components\WithModal;
use App\Traits\Components\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    use WithModal;
    use WithToast;

    public ?User $user = null;

    public function render(): View
    {
        return view('livewire.admin.management.users.delete');
    }

    #[On('users::delete')]
    public function loadUser(int $id): void
    {
        $this->user = User::where('type', TypeUsers::User)->findOrFail($id);

        $this->authorize('delete', $this->user);

        $this->openModal();
    }

    public function delete(DeleteUser $deleteUser): void
    {
        $this->user = User::where('type', TypeUsers::User)->findOrFail($this->user?->id);

        $this->authorize('delete', $this->user);

        $deleteUser->handle(actor: authenticatedUser(), user: $this->user);

        if (Auth::id() === $this->user->id) {
            Auth::logoutCurrentDevice();
            session()->invalidate();
            session()->regenerateToken();

            $this->toast('Usuário desativado com sucesso', nextPage: true);
            $this->redirectRoute('admin.login');

            return;
        }

        $this->closeModal();

        $this->toast('Usuário desativado com sucesso');

        $this->dispatch('users::refresh');
    }
}
