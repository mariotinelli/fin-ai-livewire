<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Management\Users;

use App\Actions\Users\ResendUserInvitation;
use App\Exceptions\InvitationPublicationFailed;
use App\Models\User;
use App\Traits\Components\WithModal;
use App\Traits\Components\WithToast;
use Closure;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class ResendInvitation extends Component
{
    use WithModal;
    use WithToast;

    public ?User $user = null;

    public function render(): View
    {
        return view('livewire.admin.management.users.resend-invitation');
    }

    #[On('users::resend-invitation')]
    public function loadUser(int $id): void
    {
        $this->user = User::withTrashed()->findOrFail($id);
        $this->authorize('resendInvitation', $this->user);
        $this->openModal();
    }

    public function resend(ResendUserInvitation $resendUserInvitation): void
    {
        $this->user = User::withTrashed()->findOrFail($this->user?->id);
        $this->authorize('resendInvitation', $this->user);
        $this->resetValidation();

        $status = $resendUserInvitation->handle(user: $this->user);

        if ($status === Password::RESET_THROTTLED) {
            $seconds = config()->integer('auth.passwords.' . Password::getDefaultDriver() . '.throttle');
            $this->addError('invitation', "Aguarde {$seconds} segundos entre os envios de convite.");

            return;
        }

        if ($status !== Password::RESET_LINK_SENT) {
            $this->addError('invitation', __($status));

            return;
        }

        $this->closeModal();
        $this->toast('Reenvio do convite solicitado', 'O convite será enviado em segundo plano.');
        $this->dispatch('users::refresh');
    }

    public function exception(Throwable $e, Closure $stopPropagation): void
    {
        if (!$e instanceof InvitationPublicationFailed) {
            return;
        }

        report($e);
        $this->addError('invitation', 'Não foi possível solicitar o reenvio. Tente novamente.');
        $stopPropagation();
    }
}
