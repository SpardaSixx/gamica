<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <a class="navbar-brand gamica-logo" href="/">Gamica</a>
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="submit-form">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="old('email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="E-mail cím" required autofocus />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="old('password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Jelszó" required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="color-darkwhite inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="color-darkwhite  ml-2 text-sm text-gray-600">Emlékezz rám</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="color-darkwhite underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        Elfelejtetted a jelszavad?
                    </a>
                @endif

                <x-primary-button class="ml-3">
                    Belépés
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>

    <style>
        .input-dark{
            width: 100%;
            background-color:#222 !important;
        }
    </style>
</x-guest-layout>
