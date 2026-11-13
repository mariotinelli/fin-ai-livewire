import { attachSelectDropdown, positionSelectDropdown } from './select-dropdown.js';

let multiSelect = function (t) {
    let destroyed = false;
    let positionListener;
    let cleanupDropdown;

    return {
        get activeDescendant() {
            const item = this.filteredItems[this.activeIndex];
            return this.open && item ? this.$refs.ul.id + '-option-' + item.id : null;
        },
        open: false,
        activeIndex: null,
        initialValue: [],
        selectedItems: [],
        defaultOptionLabel: 'Selecione uma ou mais opções',
        items: [],
        remainingOptions: [],
        value: null,
        isLive: false,
        dropdownUp: false,
        get optionCount() {
            return this.filteredItems.length;
        },
        init() {
            cleanupDropdown = attachSelectDropdown(this, 'selectMultipleBox');
            this.formatItems();

            if (Array.isArray(this.value)) {
                this.selectedItems = this.value.map((id) => id.toString());
            }

            this.$watch('value', (value) => {
                if (destroyed) return;
                this.selectedItems = Array.isArray(value) ? value.map((id) => id.toString()) : [];
            });

            positionListener = () => {
                if (this.open && !destroyed) {
                    this.checkDropdownPosition();
                }
            };
            window.addEventListener('resize', positionListener);
            window.addEventListener('scroll', positionListener, true);
        },
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
            return this.filteredItems[this.activeIndex];
        },
        get filteredItems() {
            return this.items.filter((item) => !this.selectedItems.includes(item.id.toString()));
        },
        get selected() {
            if (this.selectedItems.length === 0) {
                return [{ id: null, name: this.defaultOptionLabel }];
            }

            return this.items.filter((item) => this.selectedItems.includes(item.id.toString()));
        },
        choose(index) {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            const item = this.filteredItems[index];

            if (!item) {
                return;
            }

            if (this.selectedItems.includes(item.id.toString())) {
                this.selectedItems = this.selectedItems.filter((id) => id !== item.id.toString());
            } else {
                this.selectedItems.push(item.id.toString());
            }

            this.$wire.set(this.wireModel, [...this.selectedItems], this.isLive);
        },
        remove(itemId) {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            this.selectedItems = this.selectedItems.filter((id) => id !== itemId.toString());
            this.$wire.set(this.wireModel, [...this.selectedItems], this.isLive);
        },
        removeAll() {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            this.selectedItems = [];
            this.$wire.set(this.wireModel, [...this.selectedItems], this.isLive);
        },
        onButtonClick() {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            this.checkDropdownPosition();
            this.open = !this.open;
            this.$nextTick(() => {
                if (destroyed) return;
                this.checkDropdownPosition();
                if (this.open) {
                    this.$refs.ul?.focus({ preventScroll: true });

                    // Inicializa activeIndex no primeiro item
                    if (this.filteredItems.length > 0) {
                        this.activeIndex = 0;
                    }

                    const listItems = this.$refs.ul?.querySelectorAll('li[role="option"]:not([aria-disabled="true"])');
                    if (this.activeIndex !== null && listItems?.[this.activeIndex]) {
                        listItems[this.activeIndex].scrollIntoView({
                            block: 'nearest',
                            inline: 'nearest',
                        });
                    }
                }
            });
        },
        checkDropdownPosition() {
            positionSelectDropdown(this, 'selectMultipleBox', 224);
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
            if (this.filteredItems.length === 0) {
                this.activeIndex = null;
                return;
            }
            if (this.activeIndex >= this.filteredItems.length) this.activeIndex = null;
            if (this.activeIndex === null) {
                this.activeIndex = this.filteredItems.length - 1;
            } else if (this.activeIndex > 0) {
                this.activeIndex--;
            }

            // Scroll imediatamente - pega apenas os <li>
            const listItems = this.$refs.ul.querySelectorAll('li[role="option"]:not([aria-disabled="true"])');
            if (this.activeIndex !== null && listItems[this.activeIndex]) {
                const activeElement = listItems[this.activeIndex];
                const container = this.$refs.selectMultipleBox;

                const elementRect = activeElement.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();

                if (elementRect.top < containerRect.top) {
                    container.scrollTop -= containerRect.top - elementRect.top;
                }

                // Se voltou para o índice 0, garante que está no topo
                if (this.activeIndex === 0) {
                    container.scrollTop = 0;
                }

                if (this.activeIndex === this.filteredItems.length - 1) {
                    container.scrollTop = container.scrollHeight;
                }
            }
        },
        onArrowDown() {
            if (this.filteredItems.length === 0) {
                this.activeIndex = null;
                return;
            }
            if (this.activeIndex >= this.filteredItems.length) this.activeIndex = null;
            if (this.activeIndex === null) {
                this.activeIndex = 0;
            } else if (this.activeIndex < this.filteredItems.length - 1) {
                this.activeIndex++;
            }

            // Scroll imediatamente - pega apenas os <li>
            const listItems = this.$refs.ul.querySelectorAll('li[role="option"]:not([aria-disabled="true"])');
            if (this.activeIndex !== null && listItems[this.activeIndex]) {
                const activeElement = listItems[this.activeIndex];
                const container = this.$refs.selectMultipleBox;

                const elementRect = activeElement.getBoundingClientRect();
                const containerRect = container.getBoundingClientRect();

                if (elementRect.bottom > containerRect.bottom) {
                    const scrollAmount = elementRect.bottom - containerRect.bottom;
                    container.scrollTop += scrollAmount;
                }

                if (this.activeIndex === 0) {
                    container.scrollTop = 0;
                }

                if (this.activeIndex === this.filteredItems.length - 1) {
                    container.scrollTop = container.scrollHeight;
                }
            }
        },
        isSelected(index) {
            const item = this.items[index];
            return this.selectedItems.includes(item.id.toString());
        },
        getSelectedNames() {
            return this.selected.map((item) => item.name).join(', ');
        },
        destroy() {
            cleanupDropdown?.();
            destroyed = true;
            window.removeEventListener('resize', positionListener);
            window.removeEventListener('scroll', positionListener, true);
        },
        ...t,
    };
};

export default multiSelect;
