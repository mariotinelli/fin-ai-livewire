let repeater = function (model, items, fields, itemTitleColumn = null, openAll = false) {
    return {
        wireModel: model,
        fields: fields,
        items: items,
        openAll: openAll,
        itemTitleColumn: itemTitleColumn,
        init() {
            this.$watch('items', () => {
                this.syncItems();
            });

            if (this.items.length === 0) {
                this.addItem();
            }
        },
        get totalItems() {
            return `${this.items.length} ${this.items.length > 1 ? 'items' : 'item'}`;
        },
        itemTitle(index) {
            return this.itemTitleColumn ? this.items[index][this.itemTitleColumn] : `Item ${index + 1}`;
        },
        addItem() {
            this.items.push({ ...fields });
        },
        removeItem(index) {
            console.log('remove::item', index);
            this.items.splice(index, 1);
            this.$wire.dispatch('close-modal', { id: 'repeater-delete-item' });
        },
        duplicateItem(index) {
            this.items.push({ ...this.items[index] });
        },
        syncItems() {
            this.$wire.set(this.wireModel, this.items);
        },
    };
};

export default repeater;
