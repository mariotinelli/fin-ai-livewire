<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Management\Roles;

use App\Actions\Roles\UpdateRole;
use App\Models\Role;
use App\Traits\Components\WithModal;
use App\Traits\Components\WithToast;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use WithModal;
    use WithToast;

    public ?Role $role = null;

    /** @var list<string> */
    public array $selectedPermissions = [];

    public ?int $template = null;

    /** @return array<string, mixed> */
    protected function rules(): array
    {
        return [
            'role.name'             => ['required', 'string', 'min:3', 'max:191', Rule::unique('roles', 'name')->ignore($this->role)],
            'role.description'      => ['nullable', 'string', 'min:3', 'max:500'],
            'selectedPermissions'   => ['required', 'array'],
            'selectedPermissions.*' => ['required', 'string', 'exists:permissions,name'],
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.management.roles.update');
    }

    public function mount(): void
    {
        $this->role = new Role();
    }

    #[On('roles::update')]
    public function loadRole(int $roleId): void
    {
        $this->role = Role::query()->with('permissions')->findOrFail($roleId);

        $this->authorize('update', $this->role);

        $this->template = null;

        $this->selectedPermissions = [];

        foreach ($this->role->permissions as $permission) {
            $this->selectedPermissions[] = $permission->name;
        }

        $this->openModal();

        $this->dispatch('select-template', $this->selectedPermissions);
    }

    public function updatedTemplate(?int $templateId): void
    {
        if (!$templateId) {
            $this->selectedPermissions = [];
            $this->dispatch('select-template', $this->selectedPermissions);

            return;
        }

        $this->selectedPermissions = [];

        foreach (Role::query()
            ->findOrFail($templateId)
            ->permissions as $permission) {
            $this->selectedPermissions[] = $permission->name;
        }

        $this->dispatch('select-template', $this->selectedPermissions);
    }

    public function save(UpdateRole $updateRole): void
    {
        $role = Role::query()->findOrFail($this->role?->id);

        $this->authorize('update', $role);

        $this->validate();
        abort_unless($this->role instanceof Role, 404);

        $this->authorize('update', [$role, $this->selectedPermissions]);

        $updateRole->handle(
            role: $role,
            roleData: [
                'name'        => $this->role->name,
                'description' => $this->role->description,
            ],
            selectedPermissions: $this->selectedPermissions,
        );

        $this->closeModal();

        $this->toast('Perfil atualizado com sucesso');

        $this->dispatch('roles::refresh');
    }
}
