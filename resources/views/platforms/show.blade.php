@extends('layouts.default')
 
@section('content')
    @if(Auth::user() && Auth::user()->rank_id == 3)
        <div class="owner-panel p-2 text-center" style="background: rgba(0, 0, 0, .75);">
            <small>Tulajdonosi műveletek</small>
            <br>

            <a href="{{ route('platforms.edit', $platform->id) }}" class="btn btn-red">Szerkesztés</a>

            <form action="{{ route('platforms.destroy', $platform->id) }}" method="POST" class="d-inline-block">
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
            <h2 class="entity-title d-inline-block">{{ $platform->title }}</h2>
        </div>

        <div class="col-12 col-md-4 col-lg-3">
            @if($platform->has_photo == 1)
            <a data-fancybox="gallery" href="{{ $platform->getPhoto() }}">
                <img src="{{ $platform->getPhoto() }}" class="show-image" style="max-width: 100%;">
            </a>
            @endif
        </div>

        <div class="col-12 col-md-4 col-lg-3">
            @if($platform->title_short)
            <p class="entity-attribute">Rövid név: {{ $platform->title_short }}</p>
            @endif

            <p class="entity-attribute">Cég: {{ $platform->getCompany->name }}</p>

            @if($platform->release_year)
            <p class="entity-attribute">Kiadás dátuma: {{ $platform->release_year }}</p>
            @endif

            <p class="entity-attribute">Származás: {{ $platform->getCompany->getCountry->country_name }}</p>

            <p class="entity-attribute">{{ $platform->title_short }} játékok jelenleg: {{ $platform->getGames()->count() }}</p>

	   <p class="entity-attribute">{{ $platform->title_short }} adás-vételek jelenleg: {{ $platform->getSales()->count() }}</p>

            <p class="entity-attribute">{{ $platform->title_short }} kérések jelenleg: {{ $platform->getWanteds()->count() }}</p>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
            <hr>
            <div class="entity-description">{!! $platform->description !!}</div>
        </div>
    </div>

    <!-- Adás-vételek -->
    @if($platform->getSales()->count() > 0)
    <h3 class="mt-5">{{ $platform->title }} eladó játékok</h3>
    <div class="owl-carousel">
        @foreach($platform->getSales() as $sale)
            <a href="/sales/games/{{$sale->id}}">
                <div class="item-card mb-4 {{ strtolower($sale->getPlatform->getCompany->name) }}">
                    <div class="card-image position-relative" style="background-image: url({{ $sale->getPhoto() }});">
                        <p class="card-status m-0" style="{{$sale->is_sold ? 'background: rgba(0, 0, 0, .75);' : 'background: rgba(0, 0, 0, .5);'}}">{{$sale->is_sold ? 'Elkelt' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body {{ strtolower($sale->getPlatform->getCompany->name) }}">
                        <h5 class="card-title">{{ $sale->title }}</h5>
                        
                        <p class="card-text d-inline-block platform {{ strtolower($sale->getPlatform->getCompany->name) }}">{{ $sale->getPlatform->title_short }}</p>
                        
                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $sale->getPrice() }} Ft 
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    @endif

    <!-- Kérések -->
    @if($platform->getWanteds()->count() > 0)
    <h3 class="mt-5">{{ $platform->title }} kérések</h3>
    <div class="owl-carousel">
        @foreach($platform->getWanteds() as $wanted)
            <a href="{{ route('wanteds.show', $wanted->id) }}">
                <div class="item-card mb-4 {{ strtolower($wanted->getPlatform->getCompany->name) }}">
                    <div class="card-image" style="background-image: url({{ $wanted->getPhoto() }});"></div>
                    <div class="card-body" style="height: 9.5rem;">
                        <h5 class="card-title">{{ $wanted->title }}</h5>
                        <p class="card-text d-inline-block platform {{ strtolower($wanted->getPlatform->getCompany->name) }}">{{ $wanted->getPlatform->title_short }}</p>

                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $wanted->getPrice() }} Ft
                        </p>

                        {{-- <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $wanted->preferred_area }}
                        </p> --}}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    @endif

    <!-- Játékok -->
    @if($platform->getRecommendations()->count() > 0)
    <h3 class="mt-5">{{ $platform->title }} játékok</h3>
    <div class="owl-carousel">
        @foreach($platform->getRecommendations() as $game)
            <a href="/collections/games/{{$game->id}}">
                <div class="item-card mb-4 {{ strtolower($game->getPlatform->getCompany->name) }}">
                    <div class="card-image" style="background-image: url({{ $game->getPhoto() }});"></div>
                    <div class="card-body {{ strtolower($game->getPlatform->getCompany->name) }}">
                        <h5 class="card-title">{{ $game->title }}</h5>
                        <p class="card-text platform {{ strtolower($game->getPlatform->getCompany->name) }}">{{ $game->getPlatform->title_short }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    @endif
@stop
