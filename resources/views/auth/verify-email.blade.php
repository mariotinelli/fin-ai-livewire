<x-guest-layout>
    <div class="mb-8 flex flex-col gap-2">
        <p class="text-sm font-semibold text-primary">Verificação de acesso</p>
        <h1 class="font-display text-3xl leading-tight text-base-content">Verificar email</h1>
        <p class="text-sm leading-relaxed text-secondary">Obrigado por se registrar! Antes de começar, poderia verificar seu endereço de email clicando no link que acabamos de enviar? Se você não recebeu o email, ficaremos felizes em enviar outro.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6">
            <x-ui.alert
                success
                soft
                title="Um novo link de verificação foi enviado para o endereço de email que você forneceu durante o registro."
            />
        </div>
    @endif

    <div class="flex flex-col gap-3">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf

            <div>
                <x-ui.button primary block type="submit"> Reenviar Email de Verificação </x-ui.button>
            </div>
        </form>

        <div class="self-center rounded-lg focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-primary">
            <livewire:auth.logout />
        </div>
    </div>
</x-guest-layout>
