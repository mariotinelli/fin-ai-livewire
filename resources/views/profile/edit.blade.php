<x-app-layout>
    <div class="mx-auto w-full max-w-5xl min-w-0">
        <h1 class="font-display text-3xl leading-tight text-base-content sm:text-4xl">Perfil</h1>

        <div class="py-8">
            <div class="space-y-6">
                <div class="rounded-2xl border border-base-300 bg-base-100 p-4 sm:p-6">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="rounded-2xl border border-base-300 bg-base-100 p-4 sm:p-6">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="rounded-2xl border border-base-300 bg-base-100 p-4 sm:p-6">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
