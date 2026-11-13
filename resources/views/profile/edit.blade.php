<x-app-layout>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h2 class="text-3xl leading-tight font-semibold text-base-content">{{ __('Profile') }}</h2>

        <div class="py-12">
            <div class="space-y-6">
                <div class="bg-base-100 p-4 shadow-sm sm:rounded-lg sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="bg-base-100 p-4 shadow-sm sm:rounded-lg sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="bg-base-100 p-4 shadow-sm sm:rounded-lg sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
