<x-guest-layout variant="split">
    <div class="mb-8 flex flex-col gap-2">
        <p class="text-sm font-semibold text-primary">Cadastro</p>
        <h1 class="font-display text-3xl leading-tight text-base-content">Criar conta</h1>
    </div>

    @isset($retryAfter)
        <div class="mb-6">
            <x-ui.alert warning :title="'Limite de cadastros atingido. Tente novamente em ' . $retryAfter . ' segundos.'" />
        </div>
    @endisset

    <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
        @csrf

        <div>
            <x-ui.input label="Nome" name="name" type="text" :value="old('name')" required autofocus autocomplete="name" />
        </div>

        <div>
            <x-ui.input label="Email" name="email" type="email" :value="old('email')" required autocomplete="username" />
        </div>

        <div>
            <x-ui.input label="Senha" name="password" type="password" required autocomplete="new-password" />
        </div>

        <div>
            <x-ui.input label="Confirmar Senha" name="password_confirmation" type="password" required autocomplete="new-password" />
        </div>

        <div class="flex flex-col gap-3">
            <x-ui.button primary block type="submit"> Registrar </x-ui.button>
            <x-ui.button link :href="route('customer.login')" sm> Já está registrado? </x-ui.button>
        </div>
    </form>
</x-guest-layout>
