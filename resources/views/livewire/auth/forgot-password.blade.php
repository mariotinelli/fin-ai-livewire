<div class="flex flex-col gap-8">
    <div class="flex flex-col gap-2">
        <p class="text-sm font-semibold text-primary">Recuperação de acesso</p>
        <h1 class="font-display text-3xl leading-tight text-base-content">Esqueci minha senha</h1>
        <p class="text-sm leading-relaxed text-secondary">Informe seu email e enviaremos um link para você criar uma nova senha.</p>
    </div>

    @if (session('status'))
        <x-ui.alert success soft title="{{ session('status') }}" />
    @endif

    <form novalidate wire:submit="sendResetLink" class="flex flex-col gap-5">
        <x-ui.input label="Email" type="email" wire:model.defer="email" required autofocus autocomplete="username" />

        <div class="flex flex-col gap-3">
            <x-ui.button primary block type="submit" loading="sendResetLink"> Enviar link </x-ui.button>
            <x-ui.button link :href="route($loginRoute)" sm> Voltar para o login </x-ui.button>
        </div>
    </form>
</div>
