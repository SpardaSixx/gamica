<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <a class="navbar-brand gamica-logo" href="/">Gamica</a>
            </a>
        </x-slot>

        <div class="color-darkwhite mb-4 text-sm text-gray-600">
            Mielőtt belépnél, kérjük, erősítsd meg regisztrációd a linkkel, amit e-mailben elküldtünk!
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="color-darkwhite mb-4 font-medium text-sm text-green-600">
                Elküldtük a linket a megadott e-mail címre.
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-primary-button>
                        Megerősítő e-mail újraküldése
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="color-darkwhite underline text-sm text-gray-600 hover:text-gray-900">
                    Kilépés
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
