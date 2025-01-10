<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <a class="navbar-brand gamica-logo" href="/">Gamica</a>
            </a>
        </x-slot>

        <div class="color-darkwhite mb-4 text-sm text-gray-600">
            Elfelejtetted a jelszavad? Add meg az e-mail címed, hogy küldhessünk egy linket, ahol újra beállíthatod!
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="old('email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    Küldés
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

