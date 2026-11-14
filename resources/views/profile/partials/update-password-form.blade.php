<section>
    <header>
        <h2 class="text-xl font-semibold text-base-content">Atualizar Senha</h2>

        <p class="mt-2 text-sm leading-relaxed text-secondary">Certifique-se de que sua conta está usando uma senha longa e aleatória para se manter segura.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        <div>
            <x-ui.input
                label="Senha Atual"
                name="current_password"
                type="password"
                autocomplete="current-password"
                readonly
                class="min-h-11 border-base-300 bg-base-200"
            />
        </div>

        <div>
            <x-ui.input
                label="Nova Senha"
                name="password"
                type="password"
                autocomplete="new-password"
                readonly
                class="min-h-11 border-base-300 bg-base-200"
            />
        </div>

        <div>
            <x-ui.input
                label="Confirmar Nova Senha"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                readonly
                class="min-h-11 border-base-300 bg-base-200"
            />
        </div>
    </form>
</section>
