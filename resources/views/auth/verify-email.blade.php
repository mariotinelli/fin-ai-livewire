<x-guest-layout>
    <div class="mb-8 flex flex-col gap-2">
        <p class="text-sm font-semibold text-primary">Verificação de acesso</p>
        <h1 class="font-display text-3xl leading-tight text-base-content">Confirmar e-mail</h1>
        <p class="text-sm leading-relaxed text-secondary">
            @if (authenticatedUser()->hasVerifiedEmail())
                O endereço <strong class="break-all">{{ authenticatedUser()->email }}</strong> já está confirmado.
            @else
                Para confirmar <strong class="break-all">{{ authenticatedUser()->email }}</strong>, abra o link recebido nesse endereço.
            @endif
        </p>
    </div>

    @if ($invalidLink ?? false)
        <div class="mb-6">
            <x-ui.alert error soft title="Este link não é válido para o e-mail atual desta conta. Confira se você entrou com a conta correta." />
        </div>
    @elseif (isset($retryAfter))
        <div class="mb-6">
            <x-ui.alert warning :title="'Limite de solicitações atingido. Tente novamente em ' . $retryAfter . ' segundos.'" />
        </div>
    @elseif (session('status') === 'verification-link-failed')
        <div class="mb-6">
            <x-ui.alert error soft title="Sua conta está salva. Não foi possível solicitar o envio. Você pode tentar novamente." />
        </div>
    @elseif (session('status') === 'verification-link-sent')
        <div class="mb-6">
            <x-ui.alert
                success
                soft
                title="Solicitação de envio recebida. Confira sua caixa de entrada e a pasta de spam."
            />
        </div>
    @endif

    <div class="flex flex-col gap-3">
        @if (authenticatedUser()->hasVerifiedEmail())
            <x-ui.button primary block :href="route(authenticatedUser()->type->initialRouteName())">Continuar</x-ui.button>
        @else
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <x-ui.button primary block type="submit"> Solicitar novo link </x-ui.button>
            </form>
        @endif

        <x-ui.button link :href="route(authenticatedUser()->type->profileRouteName())">Acessar meu perfil</x-ui.button>
        <div class="self-center rounded-lg focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-primary">
            <livewire:auth.logout />
        </div>
    </div>
</x-guest-layout>
