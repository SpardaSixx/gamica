<x-guest-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>

    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <a class="navbar-brand gamica-logo" href="/">Gamica</a>
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}" class="submit-form">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="username" :value="old('username')" />

                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" placeholder="Felhasználónév" required autofocus />

                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="old('email')" />

                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="E-mail cím" required />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="old('password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Jelszó" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="old('password_confirmation')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" placeholder="Jelszó újra" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-4">
                <div class="row">
                    <div class="col-6 text-end" id="security_numbers" style="color: #eee; font-size: 1.5rem;"></div>

                    <div class="col-6">
                        <input type="text" name="security_input" id="security_input" class="input-dark rounded-md">
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="consent">
                    <label class="form-check-label" for="exampleCheck1" style="color: #eee;">Elfogadom a <a href="https://gamica.hu/docs/aszf.pdf" target="_blank" style="color: #eee; text-decoration: underline;">felhasználási feltételeket</a> és elolvastam az <a href="https://gamica.hu/docs/aszf.pdf" target="_blank" style="color: #eee; text-decoration: underline;">adatkezelési tájékoztatót</a></label>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="color-darkwhite underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    Van már fiókod?
                </a>

                <x-primary-button class="ml-4" id="submit-button" disabled>
                    Küldés
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>

    <script>
        var number_a = Math.floor(Math.random() * 10);
        var number_b = Math.floor(Math.random() * 10);

        document.getElementById('security_numbers').innerText = number_a + ' + ' + number_b + ' = ';

        var input = $("#security_input");
        var check = document.getElementById('consent');
        var inputOK = false;
        var checkOK = false;

        input.keyup(function(){
            if(input.val() == number_a + number_b){
                inputOK = true;

                if(inputOK == true && checkOK == true){
                    $('#submit-button').prop("disabled", false);
                }
            } else{
                $('#submit-button').prop("disabled", true);
            }
        });

        check.addEventListener("click", function(){
            if(check.checked){
                checkOK = true;
                
                if(inputOK == true && checkOK == true){
                    $('#submit-button').prop("disabled", false);
                }
            } else{
                $('#submit-button').prop("disabled", true);
            }
        });
    </script>

    <style>
        .bg-white{
            background-color: rgba(0, 0, 0, .75) !important;
        }

        .navbar-brand{
            font-size: 2rem;
        }

        .navbar-brand:hover{
            color: #eee;
        }

        .input-dark{
            width: 100%;
            background-color:#222 !important;
        }
    </style>
</x-guest-layout>
