<div class="mx-auto flex w-full max-w-5xl min-w-0 flex-col gap-8">
    <header class="flex flex-col gap-2">
        <p class="text-sm font-semibold text-secondary">Sua conta</p>
        <h1 class="font-display text-3xl leading-tight text-base-content sm:text-4xl">Perfil</h1>
        <p class="max-w-2xl text-sm leading-relaxed text-secondary">Gerencie seus dados pessoais e a segurança da sua conta.</p>
    </header>

    <div class="flex min-w-0 flex-col gap-6">
        <livewire:auth.profile.partials.update-profile-information-form />
        <livewire:auth.profile.partials.update-password-form />
    </div>
</div>
