<x-guest-layout>
    <div class="mb-8 flex flex-col gap-2">
        <p class="text-sm font-semibold text-primary">Segurança</p>
        <h1 class="font-display text-3xl leading-tight text-base-content">Confirmar senha</h1>
        <p class="text-sm leading-relaxed text-secondary">Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-5">
        @csrf

        <div>
            <x-ui.input label="Senha" name="password" type="password" required autocomplete="current-password" />
        </div>

        <div>
            <x-ui.button primary block type="submit"> Confirmar </x-ui.button>
        </div>
    </form>
</x-guest-layout>
