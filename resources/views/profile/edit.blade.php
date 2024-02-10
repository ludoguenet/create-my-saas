<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            @if (auth()->user()->subscribed())
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @if (auth()->user()->subscription('default')->onGracePeriod())
                    Votre abonnement prendra fin le {{ auth()->user()->subscription('default')->ends_at->format('d/m/Y') }}
                @else
                    <div class="max-w-xl">
                        @include('profile.partials.cancel-form')
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
