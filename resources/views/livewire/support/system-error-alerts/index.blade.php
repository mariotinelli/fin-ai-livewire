<x-ui.page title="Alertas de Erro" description="Central de monitoramento de exceções críticas do sistema." :breadcrumb="$this->breadcrumb">
    <x-ui.table draft-filters :records="$this->alerts">
        <x-slot name="filtersDropdown">
            <x-ui.input.select label="Status" :options="$this->statuses" wire:model="filterDraft.status" />

            <x-ui.input.select label="Severidade" :options="$this->severities" wire:model="filterDraft.severity" />

            <x-ui.input.select label="Ambiente" :options="$this->environmentOptions" wire:model="filterDraft.environment" />
        </x-slot>

        <x-slot name="header">
            <x-ui.table.th name="last_seen_at">Última ocorrência</x-ui.table.th>
            <x-ui.table.th name="exception_class">Exceção</x-ui.table.th>
            <x-ui.table.th name="environment">Ambiente</x-ui.table.th>
            <x-ui.table.th name="severity">Severidade</x-ui.table.th>
            <x-ui.table.th name="status">Status</x-ui.table.th>
            <x-ui.table.th name="occurrences">Ocorrências</x-ui.table.th>
            <x-ui.table.th name="request_method">Requisição</x-ui.table.th>
            <x-ui.table.th></x-ui.table.th>
        </x-slot>

        <x-slot name="body">
            @forelse ($this->alerts as $alert)
                <x-ui.table.tr>
                    <x-ui.table.td>{{ $alert->last_seen_at?->format('d/m/Y H:i:s') }}</x-ui.table.td>
                    <x-ui.table.td>
                        <div class="font-medium">{{ $alert->exception_class }}</div>
                        <div class="max-w-80 truncate text-xs text-base-content/75">{{ $alert->message }}</div>
                    </x-ui.table.td>
                    <x-ui.table.td>{{ $alert->environment }}</x-ui.table.td>
                    <x-ui.table.td>
                        <x-ui.badge :color="$alert->severity->color()">{{ $alert->severity->label() }}</x-ui.badge>
                    </x-ui.table.td>
                    <x-ui.table.td>
                        <x-ui.badge :color="$alert->status->color()">{{ $alert->status->label() }}</x-ui.badge>
                    </x-ui.table.td>
                    <x-ui.table.td>{{ $alert->occurrences }}</x-ui.table.td>
                    <x-ui.table.td>
                        <div
                            class="max-w-72 truncate text-xs text-base-content"
                            title="{{ $alert->request_method }} {{ parse_url((string) $alert->request_url, PHP_URL_PATH) ?? 'N/A' }}"
                        >
                            {{ $alert->request_method }} {{ parse_url((string) $alert->request_url, PHP_URL_PATH) ?? 'N/A' }}
                        </div>
                    </x-ui.table.td>
                    <x-ui.table.td>
                        <x-ui.table.action
                            id="show-system-error-alert-{{ $alert->id }}"
                            tooltip="Visualizar"
                            icon="eye"
                            class="text-info"
                            href="{{ route('support.system-error-alerts.show', $alert) }}"
                        />
                    </x-ui.table.td>
                </x-ui.table.tr>
            @empty
                <x-ui.table.tr>
                    <x-ui.table.td colspan="8">
                        @if ($errors->has('filters'))
                            <x-ui.empty-state title="Consulta não executada" description="Revise os filtros para continuar." />
                        @elseif ($this->search !== '' ||
                            ($this->filters['status'] ?? '') !== '' ||
                            ($this->filters['severity'] ?? '') !== '' ||
                            ($this->filters['environment'] ?? '') !== '')
                            <x-ui.empty-state title="Nenhum alerta encontrado" description="Tente ajustar a busca ou os filtros aplicados.">
                                @if ($this->search !== '')
                                    <x-ui.button xs neutral outline wire:click="$set('search', '')"> Limpar busca </x-ui.button>
                                @endif
                            </x-ui.empty-state>
                        @else
                            <x-ui.empty-state
                                title="Nenhum alerta registrado"
                                description="Os alertas críticos do sistema aparecerão aqui."
                            />
                        @endif
                    </x-ui.table.td>
                </x-ui.table.tr>
            @endforelse
        </x-slot>
    </x-ui.table>
</x-ui.page>
