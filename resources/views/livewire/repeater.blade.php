<div>
    <x-ui.repeater
        title="Itens do Pedido"
        subtitle="Adicione os produtos que deseja incluir no pedido"
        add-button-text="Adicionar produto"
        :items="$products"
        wire:model="products"
        :fields="[
            'name' => null,
            'price' => null,
            'qty' => null,
            'total' => null,
        ]"
    >
        <div class="grid grid-cols-2 gap-6">
            <x-ui.input required label="Produto" x-model.lazy="item.name" name="name" />

            <x-ui.input.money required label="Preço" x-model.lazy="item.price" name="price" />

            <x-ui.input type="number" required label="Quantidade" x-model.lazy="item.qty" name="qty" />

            <x-ui.input.money required label="Total" x-model="item.total" name="total" disabled />
        </div>
    </x-ui.repeater>

    <button data-ui-loading-control wire:click="save">
        Click<span data-ui-loading-spinner class="loading hidden loading-xs loading-spinner" aria-hidden="true"></span>
    </button>
</div>
