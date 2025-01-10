@extends('layouts.default')
 
@section('content')
    @if(Auth::id() == $game->getUser->id)
        <div class="owner-panel p-2 text-center" style="background: rgba(0, 0, 0, .75);">
            <small>Tulajdonosi műveletek</small>
            <br>

            <a href="/collections/games/{{$game->id}}/edit" class="btn btn-red">Szerkesztés</a>

            <form action="/collections/games/{{$game->id}}" method="POST" class="d-inline-block">
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
            <h2 class="entity-title d-inline-block">{{ $game->title }}</h2>
            <a href="{{ route('users.show', $game->getUser->id) }}" class="d-inline-block text-light fst-italic">{{ '('.$game->getUser->username.')' }}</a>
            <p class="d-block fst-italic">Megtekintések: {{$game->views}}</p>
        </div>

        <div class="col-12 col-lg-4">
            <a data-fancybox="gallery" href="{{ $game->getPhoto() }}">
                <img src="{{ $game->getPhoto() }}" class="show-image" style="max-width: 100%;">
            </a>
        </div>

        <div class="col-12 col-lg-4">
            <p class="entity-attribute">Konzol: {{ $game->getPlatform->title }}</p>

            @if($game->release_year)
            <p class="entity-attribute">Kiadás éve: {{ $game->release_year }}</p>
            @endif

            @if($game->serial_number)
            <p class="entity-attribute">Sorszám: {{ $game->serial_number }}</p>
            @endif

            <p class="entity-attribute">Régió: {{ $game->getRegion->title }}</p>
            <p class="entity-attribute">Kiadás: {{ $game->getRelease->title }}</p>
            <p class="entity-attribute">Borító nyelve: {{ $game->getCoverLanguage->title }}</p>
            <p class="entity-attribute">Játék nyelve: {{ $game->getGameLanguage->title }}</p>

            @if($game->manual)
            <p class="entity-attribute">Van manual</p>
            @else
            <p class="entity-attribute">Nincs manual</p>
            @endif

            @if($game->sealed)
            <p class="entity-attribute">Bontatlan</p>
            @endif
            
            @if($game->special_edition)
            <p class="entity-attribute">Special edition</p>
            @endif

            @if($game->series_id)
            <p class="entity-attribute">Sorozat: <a href="{{ route('series.show', $game->getSeries->id) }}" class="text-light fst-italic">{{ $game->getSeries->title }}</a></p>
            @endif
        </div>

        <div class="col-12 col-lg-4 text-center py-2 like-counter">
            @if(!$game->getLike())
                <a href="/collections/games/{{$game->id}}/count-like">
                    <span class="material-symbols-outlined like-button">
                        favorite
                    </span>
                </a>
            @else
                <span class="material-symbols-outlined liked-button"> 
                    heart_check
                </span>
            @endif
            <br>
            {{$game->likes}}
        </div>
    </div>

    @section('recommendfromuser')
    @if($game->getUser->getRecommendations()->count() > 1 && $game->getUser->deleted == 0)
    <div class="recommend position-relative p-3" style="background: rgba(0, 0, 0, .5);">
        <h3 class="entity-title text-center mb-3">Több játék {{ $game->getUser->username }} gyűjteményéből</h3>
        <div class="owl-carousel">
            @foreach($game->getUser->getRecommendations() as $recommend)
            @if($recommend->id != $game->id)
            <a href="/collections/games/{{$recommend->id}}">
                <div class="item-card mb-4">
                    <div class="card-image" style="background-image: url({{ $recommend->getPhoto() }});"></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                        <p class="card-text platform {{ strtolower($recommend->getPlatform->getCompany->name) }}">{{ $recommend->getPlatform->title_short }}</p>
                    </div>
                </div>
            </a>
            @endif
            @endforeach
        </div>
    </div>
    @endif
    @stop

    @section('recommendfromplatform')
    @if($game->getPlatform->getRecommendations()->count() > 1)
    <div class="recommend position-relative p-3" style="background: rgba(0, 0, 0, .75);">
        <h3 class="entity-title text-center mb-3">Több játék {{ $game->getPlatform->title }} konzolról</h3>
        <div class="owl-carousel">
            @foreach($game->getPlatform->getRecommendations() as $recommend)
            @if($recommend->id != $game->id)
            <a href="/collections/games/{{$recommend->id}}">
                <div class="item-card mb-4">
                    <div class="card-image" style="background-image: url({{ $recommend->getPhoto() }});"></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                        <p class="card-text platform {{ strtolower($recommend->getPlatform->getCompany->name) }}">{{ $recommend->getPlatform->title_short }}</p>
                    </div>
                </div>
            </a>
            @endif
            @endforeach
        </div>
    </div>
    @endif
    @stop

    <!-- <br> -->
@stop
