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
            this.selectedIndex = -1;
            this.open = false;
            this.$dispatch(@js($eventName), { value: this.query });
        },
        chooseByIndex() {
            if (this.selectedIndex < 0 || this.selectedIndex >= this.filtered.length) {
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
    @click.outside="open = false"
    x-on:artisan-commands-clear-input.window="
        query = '';
        open = false;
        selectedIndex = -1;
    "
>
    <div class="relative">
        <x-ui.input
            :id="$id"
            :label="$label"
            :placeholder="$placeholder"
            :helper-text="$helperText"
            x-model="query"
            x-on:focus="open = true"
            x-on:input="update($event.target.value)"
            x-on:keydown.escape.prevent="open = false"
            x-on:keydown.arrow-down.prevent="selectNext()"
            x-on:keydown.arrow-up.prevent="selectPrevious()"
            x-on:keydown.enter.prevent="chooseByIndex()"
            autocomplete="off"
        >
            <x-slot name="suffix">
                <x-ui.button
                    id="run-artisan-command"
                    primary
                    icon="play"
                    x-on:click="$wire.executeCommand(commandInput)"
                    loading="executeCommand"
                    class="w-full lg:w-auto"
                ></x-ui.button>
            </x-slot>
        </x-ui.input>

        <div
            x-show="open"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="ring-opacity-5 absolute z-10 mt-1 w-full overflow-auto rounded-md bg-base-100 text-base shadow-lg ring-1 ring-base-300 sm:text-sm"
            style="display: none"
        >
            <ul class="max-h-56 space-y-1 p-1" role="listbox">
                <template x-if="filtered.length === 0">
                    <li class="px-3 py-2 text-sm text-base-content/65">Nenhum comando encontrado.</li>
                </template>

                <template x-for="(item, index) in filtered" :key="item">
                    <li>
                        <button
                            type="button"
                            class="w-full rounded-md px-3 py-2 text-left text-sm transition"
                            :class="selectedIndex === index
                                ? 'bg-primary text-primary-content'
                                : 'text-base-content hover:bg-primary hover:text-primary-content'"
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
