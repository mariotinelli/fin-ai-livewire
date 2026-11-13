<div class="mt-6">
    @error('commandInput')
        <x-ui.input.error :message="$message" />
    @enderror

    <x-ui.table draft-filters :records="$this->commandExecutions">
        <x-slot name="filtersDropdown">
            <x-ui.input.select label="Status" :options="$this->statuses" wire:model="filterDraft.status" />
        </x-slot>

        <x-slot name="header">
            <x-ui.table.th name="command">Comando</x-ui.table.th>
            <x-ui.table.th name="status">Status</x-ui.table.th>
            <x-ui.table.th name="user_name">Usuário</x-ui.table.th>
            <x-ui.table.th name="ip_address">IP</x-ui.table.th>
            <x-ui.table.th name="duration_ms">Duração</x-ui.table.th>
            <x-ui.table.th name="executed_at">Executado em</x-ui.table.th>
            <x-ui.table.th></x-ui.table.th>
        </x-slot>

        <x-slot name="body">
            @forelse ($this->commandExecutions as $execution)
                <x-ui.table.tr wire:key="command-execution-{{ $execution->id }}">
                    <x-ui.table.td>
                        <button
                            data-ui-loading-control
                            type="button"
                            id="open-command-output-{{ $execution->id }}"
                            wire:click="openOutput({{ $execution->id }})"
                            class="max-w-104 truncate text-left text-sm font-medium text-info hover:underline"
                            title="{{ $execution->command }}"
                        >
                            {{ $execution->command }}
                            <span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
                        </button>
                    </x-ui.table.td>

                    <x-ui.table.td>
                        <x-ui.badge :color="$execution->status->color()"> {{ $execution->status->label() }} </x-ui.badge>
                    </x-ui.table.td>

                    <x-ui.table.td>
                        <div class="flex flex-col">
                            <span>{{ $execution->user_name }}</span>
                            <span class="text-xs text-base-content/65">#{{ $execution->user_id ?? 'N/A' }}</span>
                        </div>
                    </x-ui.table.td>

                    <x-ui.table.td>{{ $execution->ip_address ?? 'N/A' }}</x-ui.table.td>
                    <x-ui.table.td>{{ number_format($execution->duration_ms, 0, ',', '.') }} ms</x-ui.table.td>
                    <x-ui.table.td>{{ $execution->executed_at->format('d/m/Y H:i:s') }}</x-ui.table.td>

                    <x-ui.table.td>
                        <div class="flex items-center justify-end gap-1">
                            <x-ui.table.action
                                id="show-output-button-{{ $execution->id }}"
                                tooltip="Ver console"
                                icon="command-line"
                                class="text-info"
                                wire:click="openOutput({{ $execution->id }})"
                            />

                            <x-ui.table.action
                                id="rerun-command-button-{{ $execution->id }}"
                                tooltip="Reexecutar"
                                icon="arrow-path"
                                class="text-success"
                                wire:click="reExecute({{ $execution->id }})"
                            />
                        </div>
                    </x-ui.table.td>
                </x-ui.table.tr>
            @empty
                <x-ui.table.tr>
                    <x-ui.table.td colspan="7">
                        @if ($errors->has('filters'))
                            <x-ui.empty-state title="Consulta não executada" description="Revise os filtros para continuar." />
                        @elseif ($this->search !== '' || ($this->filters['status'] ?? '') !== '')
                            <x-ui.empty-state
                                title="Nenhuma execução encontrada"
                                description="Tente ajustar a busca ou os filtros aplicados."
                            >
                                @if ($this->search !== '')
                                    <x-ui.button xs neutral outline wire:click="$set('search', '')"> Limpar busca </x-ui.button>
                                @endif
                            </x-ui.empty-state>
                        @else
                            <x-ui.empty-state title="Nenhum comando executado" description="O histórico de execuções aparecerá aqui." />
                        @endif
                    </x-ui.table.td>
                </x-ui.table.tr>
            @endforelse
        </x-slot>
    </x-ui.table>

    <x-ui.modal id="artisan-command-output-modal" xl2 divided scrollable>
        <x-slot name="title">
            Saída do comando
        </x-slot>

        <x-slot name="description">
            {{ $this->selectedExecution?->command ?? 'Selecione um registro para visualizar o console.' }}
        </x-slot>

        <div class="space-y-4">
            @if ($this->selectedExecution)
                <div class="grid gap-2 text-sm text-base-content/75 md:grid-cols-2">
                    <p><strong>Status:</strong> {{ $this->selectedExecution->status->label() }}</p>
                    <p>
                        <strong>Duração:</strong>
                        {{ number_format($this->selectedExecution->duration_ms, 0, ',', '.') }} ms
                    </p>
                    <p><strong>Usuário:</strong> {{ $this->selectedExecution->user_name }}</p>
                    <p><strong>IP:</strong> {{ $this->selectedExecution->ip_address ?? 'N/A' }}</p>
                </div>

                <div class="overflow-auto rounded-lg border border-neutral bg-neutral p-4 text-xs leading-5 text-accent">
                    <pre class="font-mono whitespace-pre-wrap">{{ $this->selectedExecution->output ?: 'Sem saída registrada.' }}</pre>
                </div>
            @else
                <p class="text-sm text-base-content/65">Nenhum comando selecionado.</p>
            @endif
        </div>

        <x-slot name="footer">
            <div class="flex w-full items-center justify-end gap-2 bg-base-200 p-3">
                <x-ui.button cancel-button sm wire:click="closeModal">Fechar</x-ui.button>

                @if ($this->selectedExecution)
                    <x-ui.button sm primary icon="arrow-path" wire:click="reExecute({{ $this->selectedExecution->id }})">
                        Reexecutar
                    </x-ui.button>
                @endif
            </div>
        </x-slot>
    </x-ui.modal>
</div>
