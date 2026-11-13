<section>
    <header>
        <h2 class="text-lg font-medium text-base-content">Informações do Perfil</h2>

        <p class="mt-1 text-sm text-base-content/75">Atualize as informações do perfil e o endereço de email da sua conta.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        <div>
            <x-ui.input label="Nome" name="name" type="text" :value="old('name', $user->name)" readonly class="bg-base-200" />
        </div>

        <div>
            <x-ui.input label="Email" name="email" type="email" :value="old('email', $user->email)" readonly class="bg-base-200" />
        </div>

        <div class="flex items-center gap-4">
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => (show = false), 2000)"
                    class="text-sm text-base-content/75"
                >Salvo.</p>
            @endif
        </div>
    </form>
</section>
