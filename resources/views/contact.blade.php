@extends('layouts.default')

@section('content')
    <h2 class="entity-title text-center">Elérhetőség</h2>

    <div class="text-center my-5">
        <a href="https://www.facebook.com/gamica.official.page" target="_blank" class="contact-link me-3">
            <svg xmlns="http://www.w3.org/2000/svg" height="2rem" fill="#a73737" viewBox="0 0 512 512">
                <path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/>
            </svg> Facebook
        </a>

        <a href="https://www.instagram.com/gamica_official" target="_blank" class="contact-link me-3">
            <svg xmlns="http://www.w3.org/2000/svg" height="2rem" fill="#a73737" viewBox="0 0 448 512">
                <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
            </svg> Instagram
        </a>

        <a href="https://www.tiktok.com/@gamica_official" target="_blank" class="contact-link me-3">
            <svg xmlns="http://www.w3.org/2000/svg" height="2rem" fill="#a73737" viewBox="0 0 448 512">
                <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/>
            </svg> TikTok
        </a>
    </div>

    <h3 class="text-center">Ha kérdésed vagy észrevételed van, írhatsz is nekünk!</h3>

    <form action="{{route('send-contact-email')}}" method="post">
        @csrf
    
        <div class="form-group mb-3">
            <label for="name">Név</label>
            <input type="text" class="form-control input-dark" id="name" name="name" placeholder="Név" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">E-mail</label>
            <input type="email" class="form-control input-dark" id="email" name="email" placeholder="E-mail" required>
        </div>

        <div class="form-group">
            <label for="text">Üzenet</label>
            <textarea class="form-control input-dark" id="text" name="text" placeholder="Maximum 1000 karakter..." rows="5" required></textarea>
        </div>

        <div class="mt-4">
            <div class="row">
                <div class="col-6 text-end" id="security_numbers" style="color: #eee; font-size: 1.5rem;"></div>

                <div class="col-6">
                    <input type="text" name="security_input" id="security_input" class="input-dark rounded-md" style="position: relative; top: 8px;">
                </div>
            </div>
        </div>

        <div class="my-3 text-center">
            <input type="submit" class="btn btn-red" id="submit-button" value="Mehet" disabled>
        </div>
    </form>

    <br>

    <script>
        var number_a = Math.floor(Math.random() * 10);
        var number_b = Math.floor(Math.random() * 10);

        document.getElementById('security_numbers').innerText = number_a + ' + ' + number_b + ' = ';

        var input = $("#security_input");

        input.keyup(function(){
            if( input.val() == number_a + number_b ){
                $('#submit-button').prop("disabled", false);
            } else{
                $('#submit-button').prop("disabled", true);
            }
        });
    </script>
@stop

