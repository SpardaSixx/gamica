@extends('layouts.default')
 
@section('content')
    @if(Auth::id() == $series->getUser->id)
        <div class="owner-panel p-2 text-center" style="background: rgba(0, 0, 0, .75);">
            <small>Tulajdonosi műveletek</small>
            <br>

            <a href="{{ route('series.edit', $series->id) }}" class="btn btn-red">Szerkesztés</a>
            
            <form action="{{ route('series.destroy', $series->id) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger my-2" type="submit" onclick="confirmDelete()">
                    Törlés
                </button>
            </form> 
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <h2 class="entity-title">{{ $series->title }}</h2>
            <span>{{ count($series->getGames()) }} db összesen - </span>
            <a href="{{ route('users.show', $series->getUser->id) }}" class="d-inline-block text-light fst-italic mb-2">{{ $series->getUser->username }}</a>
            <p class="d-block fst-italic">Megtekintések: {{$series->views}}</p>
        </div>

        @foreach($series->getGames() as $game)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="/collections/games/{{$game->id}}" class="game-card">
                <div class="item-card mb-4">
                    <div class="card-image" style="background-image: url({{ $game->getPhoto() }});"></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $game->title }}</h5>
                        <p class="card-text platform {{ strtolower($game->getPlatform->getCompany->name) }}">{{ $game->getPlatform->title_short }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
@stop
