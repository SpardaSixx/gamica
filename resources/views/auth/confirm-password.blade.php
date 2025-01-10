<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <a class="navbar-brand gamica-logo" href="/">Gamica</a>
            </a>
        </x-slot>

        <div class="color-darkwhite mb-4 text-sm text-gray-600">
            Mielőtt folytatnád, kérlek add meg a jelszavad!
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="Password" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Jelszó" required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-4">
                <x-primary-button>
                    Küldés
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
