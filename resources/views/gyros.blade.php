@extends('layouts.default')

@section('content')
    <h2 class="text-center">Gyros számláló</h2>

    <br>

    @if($user == 28)

    <h4 class="text-center">Márton eddig ennyi Gyros-t vágott be: </h4>

    <h1 class="text-center">{{$counter}}</h1>

    <div class="text-center">
        <a href="{{route('gyros-increment')}}" class="btn btn-red">Megettem!</a>
    </div>

    @else

    <p class="text-center">Te itt nem Gyros-ozol!</p>

    @endif
    <br>
@stop
