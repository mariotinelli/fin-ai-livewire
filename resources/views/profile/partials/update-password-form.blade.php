<section>
    <header>
        <h2 class="text-lg font-medium text-base-content">Atualizar Senha</h2>

        <p class="mt-1 text-sm text-base-content/75">Certifique-se de que sua conta está usando uma senha longa e aleatória para se manter segura.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        <div>
            <x-ui.input
                label="Senha Atual"
                name="current_password"
                type="password"
                autocomplete="current-password"
                readonly
                class="bg-base-200"
            />
        </div>

        <div>
            <x-ui.input label="Nova Senha" name="password" type="password" autocomplete="new-password" readonly class="bg-base-200" />
        </div>

        <div>
            <x-ui.input
                label="Confirmar Nova Senha"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                readonly
                class="bg-base-200"
            />
        </div>
    </form>
</section>
