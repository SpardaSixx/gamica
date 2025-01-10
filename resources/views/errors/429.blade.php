@extends('layouts.default')

<style>
    header, .bottom-section, footer{
        display: none;
    }

    main{
        margin-top: -3rem !important;
        padding-bottom: 20rem;
    }
</style>

@section('content')
    <div class="error-message py-5">
        <h1 class="text-center" style="font-family: 'Shadows Into Light', cursive; font-size: 10rem;">429</h1>

        <br>

        <h2 class="text-center">Hoppá!</h2>

        <h3 class="text-center">Too many requests</h3>

        <br>

        <div class="text-center">
            <a href="/" style="color: #eee; text-decoration: underline;">Vissza a főoldalra</a>
        </div>
    </div>
@stop

