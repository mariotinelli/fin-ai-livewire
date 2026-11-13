import { attachSelectDropdown, positionSelectDropdown } from './select-dropdown.js';

let select = function (t) {
    let destroyed = false;
    let positionListener;
    let cleanupDropdown;
    let cleanupRefresh;

    return {
        init() {
            cleanupDropdown = attachSelectDropdown(this, 'selectBox');
            this.optionCount = this.$refs.selectBox.children.length;
            this.formatItems();

            this.$watch('value', (value) => {
                if (destroyed) return;
                if (!value) {
                    this.selectedItem = {
                        id: null,
                        name: this.defaultOptionLabel,
                    };

                    this.selectedIndex = null;
                }
            });

            const livewireElement = this.$wire.$el;
            const refreshOptions = ({ detail: event }) => {
                if (event.model === this.wireModel) {
                    this.items = event.options;
                    this.formatItems();
                }
            };
            livewireElement.addEventListener('refresh::options', refreshOptions);
            cleanupRefresh = () => livewireElement.removeEventListener('refresh::options', refreshOptions);

            positionListener = () => {
                if (this.open && !destroyed) {
                    this.checkDropdownPosition();
                }
            };
            window.addEventListener('resize', positionListener);
            window.addEventListener('scroll', positionListener, true);
        },
        get activeDescendant() {
            const item = this.items[this.activeIndex];
            return this.open && item ? this.$refs.ul.id + '-option-' + item.id : null;
        },
        optionCount: null,
        open: !1,
        activeIndex: null,
        selectedIndex: null,
        defaultOptionLabel: 'Selecione uma opção',
        items: [],
        value: null,
        clearable: true,
        isLive: false,
        dropdownUp: false,
        formatItems() {
            if (Array.isArray(this.items)) {
                return;
            }

            this.items = Object.entries(this.items).map(([key, value]) => {
                return {
                    id: key,
                    name: value,
                };
            });
        },
        get active() {
            return this.items[this.activeIndex];
        },
        get selected() {
            if (!this.value || this.items.length === 0) {
                return {
                    id: null,
                    name: this.defaultOptionLabel,
                };
            }

            this.selectedIndex = this.items.findIndex((s) => s.id.toString() === this.value.toString());

            if (this.selectedIndex === -1) {
                return {
                    id: null,
                    name: this.defaultOptionLabel,
                };
            }

            return this.items.find((s) => s.id.toString() === this.value.toString());
        },
        choose(t) {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            if (t === null || !this.items[t]) return;
            if (this.selectedIndex === t) {
                if (!this.clearable) {
                    return;
                }

                this.$refs.button.focus({ preventScroll: true });
                this.selectedIndex = null;
                this.open = false;
                this.$wire.set(this.wireModel, null, this.isLive);
                return;
            }

            this.$refs.button.focus({ preventScroll: true });
            this.selectedIndex = t;
            this.open = false;
            this.value = this.items[this.selectedIndex]['id'];
            this.$wire.set(this.wireModel, this.items[this.selectedIndex]['id'], this.isLive);
        },
        remove() {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            this.selectedIndex = null;
            this.open = false;
            this.selectedItem = {
                id: null,
                name: this.defaultOptionLabel,
            };
            this.$wire.set(this.wireModel, null, this.isLive);
        },
        onButtonClick() {
            this.openList();
        },
        openList() {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            if (this.open) {
                this.open = false;
                this.activeIndex = null;
                return;
            }

            this.checkDropdownPosition();
            this.open = true;

            this.$nextTick(() => {
                if (destroyed) return;
                this.checkDropdownPosition();
                this.$refs.ul.focus({ preventScroll: true });

                // Inicializa activeIndex com o item selecionado ou primeiro item
                if (this.selectedIndex !== null && this.selectedIndex >= 0) {
                    this.activeIndex = this.selectedIndex;
                } else if (this.items.length > 0) {
                    this.activeIndex = 0;
                }

                const listItems = this.$refs.ul.querySelectorAll('li[role="option"]:not([aria-disabled="true"])');
                if (this.activeIndex !== null && listItems[this.activeIndex]) {
                    listItems[this.activeIndex].scrollIntoView({
                        block: 'nearest',
                        inline: 'nearest',
                    });
                }
            });
        },
        checkDropdownPosition() {
            positionSelectDropdown(this, 'selectBox', 224);
        },
        onOptionSelect() {
            if (this.activeIndex !== null) {
                this.choose(this.activeIndex);
            }
        },
        onEscape() {
            this.open = false;
            this.activeIndex = null;
            this.$refs.button.focus({ preventScroll: true });
        },
        onArrowUp() {
            if (this.items.length === 0) {
                this.activeIndex = null;
                return;
            }
            if (this.activeIndex >= this.items.length) this.activeIndex = null;
            if (this.activeIndex === null) {
                this.activeIndex = this.items.length - 1;
            } else if (this.activeIndex > 0) {
                this.activeIndex--;
            }

            // Scroll imediatamente - pega apenas os <li>
            const listItems = this.$refs.ul.querySelectorAll('li[role="option"]:not([aria-disabled="true"])');
            if (this.activeIndex !== null && listItems[this.activeIndex]) {
                const activeElement = listItems[this.activeIndex];
                const container = this.$refs.ul;

                const elementRect = activeElement.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();

                if (elementRect.top < containerRect.top) {
                    container.scrollTop -= containerRect.top - elementRect.top;
                }

                // Se voltou para o índice 0, garante que está no topo
                if (this.activeIndex === 0) {
                    container.scrollTop = 0;
                }

                if (this.activeIndex === this.items.length - 1) {
                    container.scrollTop = container.scrollHeight;
                }
            }
        },
        onArrowDown() {
            if (this.items.length === 0) {
                this.activeIndex = null;
                return;
            }
            if (this.activeIndex >= this.items.length) this.activeIndex = null;
            if (this.activeIndex === null) {
                this.activeIndex = 0;
            } else if (this.activeIndex < this.items.length - 1) {
                this.activeIndex++;
            }

            // Scroll imediatamente - pega apenas os <li>
            const listItems = this.$refs.ul.querySelectorAll('li[role="option"]:not([aria-disabled="true"])');
            if (this.activeIndex !== null && listItems[this.activeIndex]) {
                const activeElement = listItems[this.activeIndex];
                const container = this.$refs.ul;

                const elementRect = activeElement.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();

                if (elementRect.bottom > containerRect.bottom) {
                    const scrollAmount = elementRect.bottom - containerRect.bottom;
                    container.scrollTop += scrollAmount;
                }

                if (this.activeIndex === 0) {
                    container.scrollTop = 0;
                }

                if (this.activeIndex === this.items.length - 1) {
                    container.scrollTop = container.scrollHeight;
                }
            }
        },
        destroy() {
            cleanupDropdown?.();
            destroyed = true;
            window.removeEventListener('resize', positionListener);
            window.removeEventListener('scroll', positionListener, true);
            cleanupRefresh?.();
        },
        ...t,
    };
};

export default select;
