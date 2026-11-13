import { attachSelectDropdown, positionSelectDropdown } from './select-dropdown.js';

let selectSearch = function (t) {
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
            cleanupDropdown = attachSelectDropdown(this, 'searchBox');
            this.element = this.$el;

            this.$watch('value', (value) => {
                if (destroyed) return;
                if (valueResetPending) {
                    valueResetPending = false;
                    if (value === null) return;
                }
                this.selectedIndex = null;
                if (!value) {
                    this.search = null;
                    this.selectedItem = {
                        id: null,
                        name: this.defaultOptionLabel,
                    };
                }
                if (!value || !this.items.some((item) => String(item.id) === String(value))) {
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
        element: null,
        initialValue: null,
        selectedItem: null,
        value: null,
        withInfinityScroll: true,
        open: false,
        name: null,
        loading: true,
        hasLoaded: false,
        loadFailed: false,
        loadOnOpen: false,
        get showEmptyOptions() {
            return this.hasLoaded && !this.loading && !this.loadFailed && this.items.length === 0;
        },
        isLoadingOptions: false,
        route: null,
        items: [],
        activeIndex: null,
        selectedIndex: null,
        get activeDescendant() {
            const item = this.items[this.activeIndex];
            return this.open && item ? this.$refs.ul.id + '-option-' + item.id : null;
        },
        wireModel: null,
        wire: null,
        search: null,
        defaultOptionLabel: 'Selecione uma opção',
        selectedColumn: 'id',
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
                this.initialValue = null;
                this.data = { meta: { current_page: null }, links: { next: null } };
                this.selectedIndex = null;
                this.selectedItem = { id: null, name: this.defaultOptionLabel };
                if (this.value !== null && this.value !== undefined && this.value !== '') {
                    valueResetPending = true;
                    this.value = null;
                    this.$wire.set(this.wireModel, null, this.isLive);
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
        get optionCount() {
            return this.items.length;
        },
        get selected() {
            if (!this.value || this.value === null || this.value === '') {
                const defaultItem = {
                    id: null,
                    name: this.defaultOptionLabel,
                };

                this.selectedItem = defaultItem;
                return defaultItem;
            }

            if (this.loading) {
                let name = this.initialValue || this.selectedItem?.name || this.defaultOptionLabel || 'Selecione uma opção';

                const loadingItem = {
                    id: this.value,
                    name: name,
                };

                this.selectedItem = loadingItem;
                return loadingItem;
            }

            this.selectedIndex = this.items.findIndex((s) => s.id.toString() === this.value.toString());
            let foundItem = this.items.find((s) => s.id.toString() === this.value.toString());

            if (foundItem) {
                this.selectedItem = foundItem;
                return foundItem;
            }

            return (
                this.selectedItem || {
                    id: this.value,
                    name: this.initialValue || this.defaultOptionLabel,
                }
            );
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
        async getOptions(page = null, append = false) {
            if (destroyed || (!paramsInitialized && Object.keys(this.paramBindings).length > 0)) return;
            const context = JSON.stringify([this.route, this.search, this.selectedColumn, this.params]);
            if (append && (request || this.loading || context !== loadedContext || !page || loadedPages.has(String(page)))) return;
            if (!append) {
                loadedContext = null;
                loadedPages.clear();
            }
            request?.abort();
            const controller = new AbortController();
            request = controller;
            this.loading = true;
            this.loadFailed = false;
            const [path, query = ''] = this.route.split('?');
            const queryParams = this.buildQuery(query);
            queryParams.delete('page');
            if (page) queryParams.set('page', page);
            if (this.value !== null && this.value !== undefined && this.value !== '') queryParams.append('selected[]', this.value);
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
                loadedPages.add(String(page ?? 1));
            } catch (error) {
                if (
                    !destroyed &&
                    !controller.signal.aborted &&
                    request === controller &&
                    context === JSON.stringify([this.route, this.search, this.selectedColumn, this.params])
                ) {
                    this.loadFailed = true;
                    failedRequest = { page, append, context };
                    console.error('Failed to load options:', error);
                }
            } finally {
                if (!destroyed && request === controller) {
                    this.loading = false;
                    request = null;
                }
            }
        },
        async retryLoading() {
            if (destroyed || this.loading || !failedRequest) return;
            if (failedRequest.context !== JSON.stringify([this.route, this.search, this.selectedColumn, this.params])) return;
            await this.getOptions(failedRequest.page, failedRequest.append);
        },
        async infinityScroll() {
            if (!this.withInfinityScroll || this.loading || this.loadFailed || !this.$refs.ul) {
                return;
            }

            if (this.data.links?.next) {
                let scroll = this.$refs.ul.scrollTop;
                let scrollHeight = this.$refs.ul.scrollHeight;
                let clientHeight = this.$refs.ul.clientHeight;

                if (scroll + 10 >= scrollHeight - clientHeight) {
                    await this.loadMore();
                }
            }
        },
        async loadMore() {
            if (!this.withInfinityScroll || this.loadFailed || !this.data.links?.next) return;
            await this.getOptions(this.data.meta.current_page + 1, true);
        },
        async doSearch() {
            await this.getOptions();
            if (destroyed || this.loading || loadedContext !== JSON.stringify([this.route, this.search, this.selectedColumn, this.params]))
                return;
            this.activeIndex = this.items.length > 0 ? 0 : null;
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
            if (this.loadOnOpen && !this.hasLoaded && !this.loading && !this.loadFailed) this.loadOptionsWhenReady();

            this.$nextTick(() => {
                if (destroyed) return;
                this.checkDropdownPosition();
                if (this.withSearch) {
                    this.$refs.search?.focus({ preventScroll: true });
                } else {
                    this.$refs.ul.focus({ preventScroll: true });
                }

                let index = this.items.findIndex(
                    (s) => s.id.toString() === (this.selectedItem?.id ? this.selectedItem.id.toString() : null),
                );

                // Inicializa activeIndex com o item selecionado ou primeiro item
                if (index >= 0) {
                    this.activeIndex = index;
                } else if (this.items.length > 0) {
                    this.activeIndex = 0;
                }

                this.$refs.ul.querySelectorAll('li[role="option"]:not([aria-disabled="true"])')[index]?.scrollIntoView({
                    block: 'nearest',
                    inline: 'nearest',
                });

                this.$refs.searchBox.style.width = this.element.offsetWidth + 'px';
            });
        },

        selectSearchFocus() {
            if (this.loadFailed) {
                this.$refs.retryButton?.focus({ preventScroll: true });
                return;
            }
            this.$refs.ul.focus({ preventScroll: true });

            if (this.selectedItem?.id) {
                let index = this.items.findIndex((s) => s.id.toString() === this.selectedItem.id.toString());

                if (index >= 0) {
                    this.activeIndex = index;
                    this.$refs.ul.querySelectorAll('li[role="option"]:not([aria-disabled="true"])')[index]?.scrollIntoView({
                        block: 'nearest',
                    });
                }
            } else if (this.items.length > 0) {
                this.activeIndex = 0;
            }
        },
        onEscape() {
            this.open = false;
            this.activeIndex = null;
            this.$refs.button.focus({ preventScroll: true });
        },
        choose(t) {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            if (t === null || !this.items[t]) return;
            this.$refs.button.focus({ preventScroll: true });
            this.selectedIndex = t;
            this.open = false;
            this.activeIndex = null;
            this.selectedItem = this.items[this.selectedIndex];
            this.value = this.selectedItem['id'];

            this.$wire.set(this.wireModel, this.selectedItem['id'], this.isLive);

            this.$nextTick(() => {});
        },
        forceUpdate() {
            this.$nextTick(() => {});
        },
        resetState() {
            this.selectedIndex = null;
            this.activeIndex = null;
            this.search = null;
            this.open = false;

            this.selectedItem = {
                id: null,
                name: this.defaultOptionLabel,
            };

            this.loadOptionsWhenReady();
        },
        remove() {
            if (this.$refs.button?.matches?.(':disabled')) {
                this.open = false;
                return;
            }
            this.selectedIndex = null;
            this.open = false;

            this.$wire.set(this.wireModel, null, this.isLive);

            this.value = null;
            this.selectedItem = {
                id: null,
                name: this.defaultOptionLabel,
            };
        },
        checkDropdownPosition() {
            positionSelectDropdown(this, 'searchBox', 240);
        },
        onOptionSelect() {
            null !== this.activeIndex && (this.selectedIndex = this.activeIndex);
            this.$refs.button.focus({ preventScroll: true });
            this.choose(this.activeIndex);
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

            // Verifica se precisa carregar mais itens
            this.infinityScroll();
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

            // Verifica se precisa carregar mais itens
            this.infinityScroll();
        },
        scrollToActiveItem() {
            // Função mantida para compatibilidade, mas o scroll agora é feito diretamente nas funções de seta
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

export default selectSearch;
