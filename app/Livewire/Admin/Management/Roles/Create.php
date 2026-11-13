<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Management\Roles;

use App\Actions\Roles\CreateRole;
use App\Models\Role;
use App\Traits\Components\WithModal;
use App\Traits\Components\WithToast;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
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
            'role.name'             => ['required', 'string', 'min:3', 'max:191', Rule::unique('roles', 'name')],
            'role.description'      => ['nullable', 'string', 'min:3', 'max:500'],
            'selectedPermissions'   => ['required', 'array'],
            'selectedPermissions.*' => ['required', 'string', 'exists:permissions,name'],
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.management.roles.create');
    }

    public function mount(): void
    {
        $this->role = new Role();
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

    public function loadRole(): void
    {
        $this->authorize('create', Role::class);

        $this->role                = new Role();
        $this->template            = null;
        $this->selectedPermissions = [];

        $this->openModal();
    }

    public function save(CreateRole $createRole): void
    {
        $this->authorize('create', Role::class);

        $this->validate();
        abort_unless($this->role instanceof Role, 404);

        $this->authorize('create', [Role::class, $this->selectedPermissions]);

        $createRole->handle(
            roleData: [
                'name'        => $this->role->name,
                'description' => $this->role->description,
            ],
            selectedPermissions: $this->selectedPermissions,
        );

        $this->closeModal();

        $this->toast('Perfil cadastrado com sucesso');

        $this->dispatch('roles::refresh');
    }
}
