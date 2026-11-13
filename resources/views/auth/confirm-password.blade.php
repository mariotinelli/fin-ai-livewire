<x-guest-layout>
    <div class="mb-4 text-sm text-base-content/75">
        Esta é uma área segura da aplicação. Por favor, confirme sua senha antes de continuar.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <x-ui.input label="Senha" name="password" type="password" required autocomplete="current-password" />
        </div>

        <div class="mt-4 flex justify-end">
            <x-ui.button primary sm uppercase type="submit"> Confirmar </x-ui.button>
        </div>
    </form>
</x-guest-layout>
