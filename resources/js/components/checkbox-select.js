import multiSelectSearch from './multi-select-search.js';

const normalize = (value) =>
    String(value)
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLocaleLowerCase('pt-BR');

export default function checkboxSelect(configuration = {}) {
    const source = configuration.items ?? [];
    const items = Array.isArray(source) ? source : Object.entries(source).map(([id, name]) => ({ id, name }));
    const component = multiSelectSearch({ ...configuration, route: configuration.route ?? null, items });
    const remoteLoad = component.loadOptionsWhenReady;

    Object.defineProperties(component, {
        filteredItems: {
            get() {
                const seen = new Set();
                const search = normalize(this.search ?? '').trim();
                return this.items.filter((item) => {
                    if (item.id === null || item.id === undefined || seen.has(String(item.id))) return false;
                    seen.add(String(item.id));
                    return normalize(item.name).includes(search);
                });
            },
        },
        availableItems: {
            get() {
                return this.filteredItems.filter((item) => !item.disabled);
            },
        },
        allFilteredSelected: {
            get() {
                return this.availableItems.length > 0 && this.availableItems.every((item) => this.selectedItems.includes(String(item.id)));
            },
        },
        someFilteredSelected: {
            get() {
                return !this.allFilteredSelected && this.availableItems.some((item) => this.selectedItems.includes(String(item.id)));
            },
        },
        selectionLabel: {
            get() {
                const count = new Set(this.selectedItems).size;
                return count ? `${count} ${count === 1 ? 'selecionado' : 'selecionados'}` : this.defaultOptionLabel;
            },
        },
        canEdit: {
            get() {
                return !this.loading && !this.loadFailed && !this.$refs.button?.matches?.(':disabled');
            },
        },
    });

    Object.assign(component, {
        loadOptionsWhenReady() {
            if (this.route) return remoteLoad.call(this);
            this.items = items;
            this.loading = false;
            this.hasLoaded = true;
        },
        doSearch() {
            if (this.route) return this.getOptions();
        },
        commitSelection(ids) {
            this.selectedItems = [...new Set(ids.map(String))];
            this.$wire.set(this.wireModel, [...this.selectedItems], this.isLive);
        },
        choose(index) {
            const item = this.filteredItems[index];
            if (!this.canEdit || !item || item.disabled) return;
            const id = String(item.id);
            this.commitSelection(
                this.selectedItems.includes(id) ? this.selectedItems.filter((selected) => selected !== id) : [...this.selectedItems, id],
            );
        },
        toggleAll() {
            if (!this.canEdit) return;
            const ids = this.availableItems.map((item) => String(item.id));
            this.commitSelection(
                this.allFilteredSelected ? this.selectedItems.filter((id) => !ids.includes(id)) : [...this.selectedItems, ...ids],
            );
        },
        clearSelection() {
            if (this.canEdit) this.commitSelection([]);
        },
    });

    return component;
}
