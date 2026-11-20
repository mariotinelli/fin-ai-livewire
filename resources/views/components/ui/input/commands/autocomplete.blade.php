@props([
    'id' => 'autocomplete-local',
    'label' => 'Comando',
    'placeholder' => 'Digite um comando',
    'helperText' => null,
    'items' => [],
    'eventName' => 'autocomplete-local-updated',
])

<div
    class="w-full"
    x-data="{
        open: false,
        query: '',
        selectedIndex: -1,
        items: @js(array_values($items)),
        get filtered() {
            const term = this.query.toLowerCase().replace(/^php\s+artisan\s+/i, '').trim();

            if (term === '') {
                return this.items.slice(0, 8);
            }

            return this.items
                .filter((item) => item.toLowerCase().includes(term))
                .slice(0, 8);
        },
        update(value) {
            this.query = value;
            this.selectedIndex = -1;
            this.open = true;
            this.$dispatch(@js($eventName), { value: this.query });
        },
        select(item) {
            this.query = `php artisan ${item}`;
            this.close();
            this.$dispatch(@js($eventName), { value: this.query });
        },
        close() {
            this.open = false;
            this.selectedIndex = -1;
        },
        chooseByIndex() {
            if (!this.open || this.selectedIndex < 0 || this.selectedIndex >= this.filtered.length) {
                return;
            }

            this.select(this.filtered[this.selectedIndex]);
        },
        selectNext() {
            if (! this.open) {
                this.open = true;
            }

            this.selectedIndex = this.selectedIndex >= this.filtered.length - 1
                ? 0
                : this.selectedIndex + 1;
        },
        selectPrevious() {
            if (! this.open) {
                this.open = true;
            }

            this.selectedIndex = this.selectedIndex <= 0
                ? this.filtered.length - 1
                : this.selectedIndex - 1;
        },
    }"
    @click.outside="close()"
    x-on:artisan-commands-clear-input.window="
        query = '';
        close();
    "
>
    <div class="relative">
        <x-ui.input
            :id="$id"
            name="commandInput"
            role="combobox"
            aria-autocomplete="list"
            aria-controls="{{ $id }}-suggestions"
            x-bind:aria-expanded="open"
            x-bind:aria-activedescendant="open && filtered[selectedIndex] ? $el.id + '-option-' + selectedIndex : null"
            :label="$label"
            :placeholder="$placeholder"
            :helper-text="$helperText"
            x-model="query"
            x-on:focus="open = true"
            x-on:blur="close()"
            x-on:input="update($event.target.value)"
            x-on:keydown.escape.prevent="close()"
            x-on:keydown.arrow-down.prevent="selectNext()"
            x-on:keydown.arrow-up.prevent="selectPrevious()"
            x-on:keydown.enter.prevent="chooseByIndex()"
            autocomplete="off"
            class="min-w-0 font-mono"
        >
            <x-slot name="suffix">
                <x-ui.button
                    id="run-artisan-command"
                    primary
                    icon="play"
                    aria-label="Executar comando"
                    title="Executar comando"
                    x-on:click="$wire.executeCommand(commandInput)"
                    loading="executeCommand"
                    class="size-10 rounded-l-none p-0 focus-visible:outline-offset-[-3px]"
                />
            </x-slot>
        </x-ui.input>

        <div
            x-show="open"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-lg border border-base-300 bg-base-100 shadow-panel"
            style="display: none"
        >
            <ul id="{{ $id }}-suggestions" role="listbox" class="space-y-1 p-1" aria-label="Sugestões de comandos">
                <template x-if="filtered.length === 0">
                    <li role="option" aria-disabled="true" class="px-3 py-2 text-sm text-base-content/65">Nenhum comando encontrado.</li>
                </template>

                <template x-for="(item, index) in filtered" :key="item">
                    <li role="presentation">
                        <button
                            type="button"
                            role="option"
                            tabindex="-1"
                            x-bind:id="@js($id . '-option-') + index"
                            x-bind:aria-selected="selectedIndex === index"
                            x-on:mousedown.prevent
                            class="w-full rounded-lg px-3 py-2 text-left font-mono text-sm wrap-anywhere transition focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-focus"
                            :class="selectedIndex === index
                                ? 'bg-primary text-primary-content'
                                : 'text-base-content hover:bg-accent hover:text-accent-content active:bg-primary active:text-primary-content'"
                            x-on:click="select(item)"
                        >
                            <span x-text="`php artisan ${item}`"></span>
                        </button>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</div>
