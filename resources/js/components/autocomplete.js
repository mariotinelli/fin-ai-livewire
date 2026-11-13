let autocomplete = function (t) {
    let destroyed = false;
    let request;
    let loadedContext;
    const loadedPages = new Set();

    return {
        element: null,
        initialValue: null,
        selectedItem: null,
        value: null,
        withInfinityScroll: true,
        open: false,
        name: null,
        route: null,
        items: [],
        wireModel: null,
        wire: null,
        search: null,
        isLive: false,
        activeIndex: null,
        get activeDescendant() {
            const item = this.items[this.activeIndex];
            return this.open && !this.loading && item ? this.$refs.ul.id + '-option-' + item.id : null;
        },
        onArrowDown() {
            this.open = true;
            this.activeIndex = this.items.length && !this.loading ? Math.min((this.activeIndex ?? -1) + 1, this.items.length - 1) : null;
            this.scrollActiveOption();
        },
        onArrowUp() {
            this.open = true;
            this.activeIndex = this.items.length && !this.loading ? Math.max((this.activeIndex ?? this.items.length) - 1, 0) : null;
            this.scrollActiveOption();
        },
        scrollActiveOption() {
            this.$nextTick(() => {
                if (destroyed) return;
                this.$refs.ul.querySelectorAll('li[role="option"]:not([aria-disabled="true"])')[this.activeIndex]?.scrollIntoView({
                    block: 'nearest',
                    inline: 'nearest',
                });
            });
        },
        onOptionSelect() {
            if (!this.loading && this.activeIndex !== null) this.choose(this.activeIndex);
        },
        onEscape() {
            this.open = false;
            this.activeIndex = null;
        },
        selectedColumn: 'id',
        loading: false,
        focus: false,
        oldValue: null,
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
        init() {
            this.element = this.$el;

            this.$watch('value', (value) => {
                if (destroyed) return;
                if (!value || value.length <= 1) {
                    request?.abort();
                    request = null;
                    this.loading = false;
                    this.open = false;
                    this.items = [];
                    return;
                }
                if (value === this.oldValue) return;
                this.activeIndex = null;
                this.open = true;
                this.getOptions();
            });
        },
        async getOptions(page = null, append = false) {
            if (destroyed) return;
            const context = JSON.stringify([this.route, this.value]);
            if (append && (request || this.loading || context !== loadedContext || !page || loadedPages.has(String(page)))) return;
            if (!append) {
                loadedContext = null;
                loadedPages.clear();
            }
            request?.abort();
            const controller = new AbortController();
            request = controller;
            this.loading = true;

            let url = this.route;

            if (page) {
                url += url.includes('?') ? '&' : '?';
                url += new URLSearchParams({ page: page });
            }

            if (this.value) {
                url += url.includes('?') ? '&' : '?';
                url += new URLSearchParams({ search: this.value });
            }

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
                    context !== JSON.stringify([this.route, this.value])
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
                loadedContext = context;
                loadedPages.add(String(page ?? 1));
            } catch (error) {
                if (!destroyed && !controller.signal.aborted && request === controller) {
                    console.error('Failed to load options:', error);
                }
            } finally {
                if (!destroyed && request === controller) {
                    this.loading = false;
                    request = null;
                }
            }
        },
        onFocus() {
            this.focus = true;
            this.open = true;
        },
        choose(index) {
            if (index === null || !this.items[index]) return;
            this.value = this.items[index].name;
            this.setWireValue();
            this.open = false;
        },
        close() {
            if (this.focus || this.open) {
                this.setWireValue();
            }

            this.open = false;
        },
        setWireValue() {
            if (this.oldValue !== this.value) {
                this.oldValue = this.value;
                this.$wire.set(this.wireModel, this.value, this.isLive);
            }
        },
        destroy() {
            destroyed = true;
            request?.abort();
        },
        ...t,
    };
};

export default autocomplete;
