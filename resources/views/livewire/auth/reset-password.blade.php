<div class="flex flex-col gap-8">
    <div class="flex flex-col gap-2 text-center">
        <p class="text-sm font-semibold tracking-widest text-primary uppercase">Recuperação de acesso</p>
        <h1 class="text-2xl font-bold text-base-content">Redefinir senha</h1>
        <p class="text-sm text-base-content/75">Cadastre sua senha para concluir o primeiro acesso ou recuperar sua conta.</p>
    </div>

    <form wire:submit="save" class="flex flex-col gap-5">
        <input type="hidden" name="token" wire:model="token" />

        <x-ui.input label="Email" type="email" wire:model="email" required disabled autocomplete="username" />

        <x-ui.input.password label="Senha" wire:model="password" required autocomplete="new-password" />

        <x-ui.input.password label="Confirmar senha" wire:model="password_confirmation" required autocomplete="new-password" />

        <x-ui.button primary block uppercase type="submit" loading="save"> Redefinir senha </x-ui.button>
    </form>

    <x-ui.button link :href="route('password.forgot', ['context' => $context])" sm>Solicitar novo link</x-ui.button>
</div>
