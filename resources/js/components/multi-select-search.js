import { attachSelectDropdown, positionSelectDropdown } from './select-dropdown.js';

let multiSelectSearch = function (t) {
    let destroyed = false;
    let positionListener;
    let cleanupDropdown;
    let request;
    let failedRequest;
    let loadedContext;
    let paramsSnapshot;
    let paramsInitialized = false;
    let valueResetPending = false;
    const loadedPages = new Set();

    return {
        init() {
            cleanupDropdown = attachSelectDropdown(this, 'multiSelectSearchBox');
            this.element = this.$el;

            this.selectedItems = Array.isArray(this.value) ? this.value.map(String) : [];
            this.$watch('value', (value) => {
                if (destroyed) return;
                if (valueResetPending) {
                    valueResetPending = false;
                    if (Array.isArray(value) && value.length === 0) return;
                }
                this.selectedItems = Array.isArray(value) ? value.map(String) : [];
                if (this.selectedItems.some((id) => !this.items.some((item) => String(item.id) === id))) {
                    this.search = null;
                    this.loadOptionsWhenReady();
                }
            });

            positionListener = () => {
                if (this.open && !destroyed) this.checkDropdownPosition();
            };
            window.addEventListener('resize', positionListener);
            window.addEventListener('scroll', positionListener, true);
            this.$watch('params', (params) => this.syncParams(params));
            if (Object.keys(this.paramBindings).length === 0) this.syncParams(this.params);
        },
        get activeDescendant() {
            const item = this.filteredItems[this.activeIndex];
            const listId = this.$refs.ul?.id;
            return this.open && item && listId ? listId + '-option-' + item.id : null;
        },
        activeIndex: null,
        element: null,
        initialValue: [],
        selectedItems: [],
        value: null,
        withInfinityScroll: true,
        open: false,
        name: null,
        loading: true,
        hasLoaded: false,
        loadFailed: false,
        loadOnOpen: false,
        get showEmptyOptions() {
            return this.hasLoaded && !this.loading && !this.loadFailed && this.filteredItems.length === 0;
        },
        route: null,
        items: [],
        search: null,
        withSearch: null,
        selectedColumn: 'id',
        defaultOptionLabel: 'Selecione uma ou mais opções',
        isLive: false,
        params: {},
        paramBindings: {},
        syncParams(nextParams) {
            if (destroyed) return;
            const snapshot = JSON.stringify(nextParams);
            if (paramsInitialized && snapshot === paramsSnapshot) return;
            const resetSelection = paramsInitialized;
            paramsInitialized = true;
            paramsSnapshot = snapshot;
            this.params = JSON.parse(snapshot);

            if (resetSelection) {
                request?.abort();
                failedRequest = null;
                this.hasLoaded = false;
                this.loadFailed = false;
                loadedContext = null;
                loadedPages.clear();
                this.items = [];
                this.search = null;
                this.activeIndex = null;
                this.open = false;
                this.initialValue = [];
                this.data = { meta: { current_page: null }, links: { next: null } };
                this.selectedItems = [];
                if (Array.isArray(this.value) && this.value.length > 0) {
                    valueResetPending = true;
                    this.value = [];
                    this.$wire.set(this.wireModel, [], this.isLive);
                }
            }

            return this.loadOptionsWhenReady();
        },
        loadOptionsWhenReady() {
            if (destroyed) return;
            if (this.loadOnOpen && !this.open) {
                request?.abort();
                request = null;
                failedRequest = null;
                this.loading = false;
                this.hasLoaded = false;
                this.loadFailed = false;
                return;
            }
            return this.getOptions();
        },
        dropdownUp: false,
        get optionCount() {
            return this.filteredItems.length;
        },
        data: {
            meta: {
                current_page: null,
                from: null,
                last_page: null,
                links: {},
                path: null,
                per_page: null,
                to: null,
                total: null,
            },
            links: {
                first: null,
                last: null,
                next: null,
            },
        },
        get selected() {
            if (this.selectedItems.length === 0) {
                return [{ id: null, name: this.defaultOptionLabel }];
            }

            return this.items.filter((item) => this.selectedItems.includes(item.id.toString()));
        },
        get filteredItems() {
            return this.items.filter((item) => !this.selectedItems.includes(item.id.toString()));
        },
        buildQuery(query) {
            const queryParams = new URLSearchParams(query);
            const reserved = ['search', 'page', 'selected', 'selectedColumn'];
            for (const key of ['search', 'selected', 'selected[]', 'selectedColumn']) queryParams.delete(key);
            for (const [key, value] of Object.entries(this.params)) {
                if (reserved.includes(key.replace(/\[.*$/, ''))) continue;
                queryParams.delete(key);
                queryParams.delete(key + '[]');
                const values = Array.isArray(value) ? value : [value];
                for (const entry of values) {
                    if (entry !== null && entry !== undefined && entry !== '') {
                        queryParams.append(Array.isArray(value) ? key + '[]' : key, entry);
                    }
                }
            }
            if (this.search) queryParams.set('search', this.search);
            queryParams.set('selectedColumn', this.selectedColumn);
            return queryParams;
        },
        async getOptions(route = null, append = false) {
            if (destroyed || (!paramsInitialized && Object.keys(this.paramBindings).length > 0)) return;
            const context = JSON.stringify([this.route, this.search, this.selectedColumn, this.params]);
            if (append && (request || this.loading || context !== loadedContext || !route || loadedPages.has(String(route)))) return;
            if (!append) {
                loadedContext = null;
                loadedPages.clear();
            }
            request?.abort();
            const controller = new AbortController();
            request = controller;
            this.loading = true;
            this.loadFailed = false;
            const [path, query = ''] = (route || this.route).split('?');
            const queryParams = this.buildQuery(query);
            if (!route) queryParams.delete('page');
            if (Array.isArray(this.value)) this.value.forEach((id) => queryParams.append('selected[]', id));
            const url = path + '?' + queryParams;

            try {
                const response = await fetch(url, {
                    signal: controller.signal,
                });
                if (!response.ok) throw new Error('Failed to load options: ' + response.status);
                const { meta, links, data } = await response.json();
                if (
                    destroyed ||
                    controller.signal.aborted ||
                    request !== controller ||
                    context !== JSON.stringify([this.route, this.search, this.selectedColumn, this.params])
                )
                    return;
                const items = append ? [...this.items, ...data] : data;
                const seen = new Set();
                this.items = items.filter((item) => {
                    const key = String(item.id);
                    if (seen.has(key)) return false;
                    seen.add(key);
                    return true;
                });
                this.data = { meta, links };
                this.hasLoaded = true;
                failedRequest = null;
                loadedContext = context;
                loadedPages.add(String(route ?? 1));
            } catch (error) {
                if (
                    !destroyed &&
                    !controller.signal.aborted &&
                    request === controller &&
                    context === JSON.stringify([this.route, this.search, this.selectedColumn, this.params])
                ) {
                    this.loadFailed = true;
                    failedRequest = { route, append, context };
                    console.error('Failed to load options:', error);
                }
            } finally {
                if (!destroyed && request === controller) {
                    this.loading = false;
                    request = null;
                }
            }
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
        isSelected(index) {
            const item = this.filteredItems[index];

            if (!item) {
                return false;
            }

            return this.selectedItems.includes(item.id.toString());
        },
        remove(itemId) {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            this.selectedItems = this.selectedItems.filter((id) => id !== itemId.toString());
            this.$wire.set(this.wireModel, [...this.selectedItems], this.isLive);
        },
        async doSearch() {
            await this.getOptions();
        },
        async retryLoading() {
            if (destroyed || this.loading || !failedRequest) return;
            if (failedRequest.context !== JSON.stringify([this.route, this.search, this.selectedColumn, this.params])) return;
            await this.getOptions(failedRequest.route, failedRequest.append);
        },
        async infinityScroll() {
            if (!this.withInfinityScroll || this.loading || this.loadFailed || !this.$refs.multiSelectSearchBox) {
                return;
            }

            if (this.data.links?.next) {
                let scroll = this.$refs.multiSelectSearchBox.scrollTop;
                let scrollHeight = this.$refs.multiSelectSearchBox.scrollHeight;
                let clientHeight = this.$refs.multiSelectSearchBox.clientHeight;

                if (scroll >= scrollHeight - clientHeight) {
                    await this.loadMore();
                }
            }
        },
        async loadMore() {
            if (!this.withInfinityScroll || this.loadFailed || !this.data.links?.next) return;
            await this.getOptions(this.data.links?.next, true);
        },
        openList() {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            this.checkDropdownPosition();
            this.open = !this.open;
            if (this.open && this.loadOnOpen && !this.hasLoaded && !this.loading && !this.loadFailed) this.loadOptionsWhenReady();

            this.$nextTick(() => {
                if (destroyed) return;
                this.checkDropdownPosition();
                if (this.withSearch) {
                    this.$refs.search?.focus({ preventScroll: true });
                } else {
                    this.$refs.ul?.focus({ preventScroll: true });
                }

                // Inicializa activeIndex no primeiro item
                if (this.open && this.filteredItems.length > 0) {
                    this.activeIndex = 0;
                }

                this.$refs.multiSelectSearchBox.style.width = this.element.offsetWidth + 'px';
            });
        },
        checkDropdownPosition() {
            positionSelectDropdown(this, 'multiSelectSearchBox', 240);
        },
        onEscape() {
            this.open = false;
            this.activeIndex = null;
            this.$refs.button.focus({ preventScroll: true });
        },
        onOptionSelect() {
            if (this.activeIndex !== null) {
                this.choose(this.activeIndex);
            }
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
                const container = this.$refs.multiSelectSearchBox;

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

            // Verifica se precisa carregar mais itens
            this.infinityScroll();
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
                const container = this.$refs.multiSelectSearchBox;

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

            // Verifica se precisa carregar mais itens
            this.infinityScroll();
        },
        destroy() {
            cleanupDropdown?.();
            destroyed = true;
            window.removeEventListener('resize', positionListener);
            window.removeEventListener('scroll', positionListener, true);
            request?.abort();
        },
        ...t,
    };
};

export default multiSelectSearch;
