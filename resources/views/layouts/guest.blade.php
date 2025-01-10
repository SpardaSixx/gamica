<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gamica') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Play:wght@700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&family=Titillium+Web:wght@300&display=swap" rel="stylesheet">

        <!-- CSS -->
        <link href="/css/style.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Titillium Web', sans-serif;
            }

            @font-face {
                font-family: PoiretOne;
                src: url(/public/fonts/PoiretOne-Regular.ttf);
            }
            .brand-logo{
                font-family: 'Play', sans-serif;
                font-size: 2rem;
                color: #7303c0;
            }
            i{
                font-size: 2.25rem;
            }
            .gamica-logo{
                font-family: 'Shadows Into Light', cursive;
                font-size: 2rem;
                padding: 0.5rem;
                color: #eee;
            }
            .auth-body{
                /*background-color: #111;*/
                background-image: url(/img/bodybg.jpg);
            }
            .auth-card{
                background: rgba(0, 0, 0, .75);
            }
            .bg-darkwhite{
                background-color: #eee !important;
            }
            .color-darkwhite{
                color: #eee;
            }
            .color-darkwhite:hover{
                color: #ccc;
            }

            .input-dark{
                background: rgba(0, 0, 0, .75);
                color: #eee;
                border: 0;
            }
            .input-dark:focus{
                background: rgba(0, 0, 0, .25);
                color: #eee;
            }
        </style>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
