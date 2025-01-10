@extends('layouts.default')
 
@section('content')
    <div class="row">
        <div class="col-12">
            <h2 class="entity-title d-inline-block">{{ $user->username }}</h2>
        </div>

        <div class="col-12 col-lg-4">
            <a data-fancybox="gallery" href="{{ $user->getPhoto() }}">
                <div class="profile-picture" style="background-image: url({{ $user->getPhoto() }})"></div>
                {{-- <img src="{{ $user->getPhoto() }}" class="profile-picture" style="max-width: 100%;"> --}}
            </a>
        </div>

        <div class="col-12 col-lg-4">
            <p class="entity-attribute">{{ $user->xp_points }} TP</p>
            <p class="entity-attribute">{{ $user->getRank->name }}</p>
            @if($user->getCity)
            <p class="entity-attribute">{{ $user->getCity->name }}</p>
            @endif
            <p class="entity-attribute">{{ count($user->getSales()) }} db eladó játék</p>
            <p class="entity-attribute">{{ count($user->getConsoles()) }} db eladó konzol</p>
            <p class="entity-attribute">{{ count($user->getAccessories()) }} db eladó kiegészítő</p>
            <p class="entity-attribute">{{ count($user->getPacks()) }} db eladó csomag</p>
            <p class="entity-attribute">{{ count($user->getGames()) }} db játék</p>
            <p class="entity-attribute">{{ count($user->getSeries()) }} db sorozat</p>
        </div>

        <div class="col-12 col-lg-4">
            <p class="entity-attribute">Utoljára belépve:<br>{{ $user->last_login }}</p>
            <p class="entity-attribute">{{ $user->email }}</p>
            <p class="entity-attribute" style="{{$user->email_verified_at ? 'background-color: green;' : 'background-color: red;'}} border-radius: 4px; padding: 0 5px; width: fit-content; display: table;">{{$user->email_verified_at ? 'E-mail cím megerőstve' : 'E-mail cím nincs megerősítve'}}</p>
            @if($user->fb_profile)
            <p class="entity-attribute"><a href="{{ $user->fb_profile }}" class="text-light fst-italic" target="_blank">Facebook</a></p>
            @endif
            @if($user->ig_profile)
            <p class="entity-attribute"><a href="{{ $user->ig_profile }}" class="text-light fst-italic" target="_blank">Instagram</a></p>
            @endif
        </div>
    </div>

    <br>

    <!-- Eladó játék -->
    @if($user->getSales()->count() > 0)
    <h3 class="d-inline-block mt-5">{{ $user->username }} eladó játékai ({{ $user->getSales()->count() }} db)</h3>
    @if($user->getSales()->count() > 10)
    <a href="/sales/games?user_id={{$user->id}}" class="hoverline-link d-inline-block">Összes mutatása</a>
    @endif
    <div class="owl-carousel">
        @foreach($user->getSalesLimited() as $sale)
        <a href="/sales/games/{{$sale->id}}">
            <div class="item-card mb-4">
                <div class="card-image position-relative" style="background-image: url({{ $sale->getPhoto() }});">
                    <p class="card-status {{$sale->is_sold ? 'sold' : ''}} m-0">{{$sale->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                </div>
                <div class="card-body">
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

    <!-- Eladó konzol -->
    @if($user->getConsoles()->count() > 0)
    <h3 class="d-inline-block mt-5">{{ $user->username }} eladó konzoljai ({{ $user->getConsoles()->count() }} db)</h3>
    @if($user->getConsoles()->count() > 10)
    <a href="/sales/consoles?user_id={{$user->id}}" class="hoverline-link d-inline-block">Összes mutatása</a>
    @endif
    <div class="owl-carousel">
        @foreach($user->getConsolesLimited() as $console)
        <a href="/sales/consoles/{{$console->id}}">
            <div class="item-card mb-4">
                <div class="card-image position-relative" style="background-image: url({{ $console->getPhoto() }});">
                    <p class="card-status {{$console->is_sold ? 'sold' : ''}} m-0">{{$console->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $console->title }}</h5>
                    
                    <p class="card-text  d-inline-block platform {{ strtolower($console->getCompany->name) }}">{{ $console->getCompany->name}}</p>

                    <p class="card-text  d-inline-block">
                        <i class="fas fa-circle"></i>
                        {{ $console->getPrice() }} Ft
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    <!-- Eladó tartozék -->
    @if($user->getAccessories()->count() > 0)
    <h3 class="d-inline-block mt-5">{{ $user->username }} eladó tartozékai ({{ $user->getAccessories()->count() }} db)</h3>
    @if($user->getAccessories()->count() > 10)
    <a href="/sales/accessories?user_id={{$user->id}}" class="hoverline-link d-inline-block">Összes mutatása</a>
    @endif
    <div class="owl-carousel">
        @foreach($user->getAccessoriesLimited() as $accessory)
        <a href="{{route('accessories.show', $accessory->id)}}">
            <div class="item-card mb-4">
                <div class="card-image position-relative" style="background-image: url({{ $accessory->getPhoto() }});">
                    <p class="card-status {{$accessory->is_sold ? 'sold' : ''}} m-0">{{$accessory->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $accessory->title }}</h5>
                    
                    <p class="card-text d-inline-block platform {{ strtolower($accessory->getCompany->name) }}">{{ $accessory->getCompany->name}}</p>

                    <p class="card-text  d-inline-block">
                        <i class="fas fa-circle"></i>
                        {{ $accessory->getPrice() }} Ft
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    <!-- Eladó csomag -->
    @if($user->getPacks()->count() > 0)
    <h3 class="d-inline-block mt-5">{{ $user->username }} eladó csomagjai ({{ $user->getPacks()->count() }} db)</h3>
    @if($user->getPacks()->count() > 10)
    <a href="/sales/packs?user_id={{$user->id}}" class="hoverline-link d-inline-block">Összes mutatása</a>
    @endif
    <div class="owl-carousel">
        @foreach($user->getPacksLimited() as $pack)
        <a href="{{route('packs.show', $pack->id)}}">
            <div class="item-card mb-4">
                <div class="card-image position-relative" style="background-image: url({{ $pack->getPhoto() }});">
                    <p class="card-status {{$pack->is_sold ? 'sold' : ''}} m-0">{{$pack->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $pack->title }}</h5>
                    
                    <p class="card-text">
                        {{ $pack->getPrice() }} Ft
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    <!-- Kérések -->
    @if($user->getWanteds()->count() > 0)
    <h3 class="d-inline-block mt-5">{{ $user->username }} kérései ({{ $user->getWanteds()->count() }} db)</h3>
    @if($user->getWanteds()->count() > 10)
    <a href="/wanteds?user_id={{$user->id}}" class="hoverline-link d-inline-block">Összes mutatása</a>
    @endif
    <div class="owl-carousel">
        @foreach($user->getWantedsLimited() as $wanted)
        <a href="{{ route('wanteds.show', $wanted->id) }}">
            <div class="item-card mb-4">
                <div class="card-image  position-relative" style="background-image: url({{ $wanted->getPhoto() }});">
                    <p class="card-status {{$wanted->is_found ? 'sold' : ''}} m-0">{{$wanted->is_found ? 'Lezárt' : 'Aktív'}}</p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $wanted->title }}</h5>
                    <p class="card-text d-inline-block platform {{ strtolower($wanted->getPlatform->getCompany->name) }}">{{ $wanted->getPlatform->title_short }}</p>

                    <p class="card-text d-inline-block">
                        <i class="fas fa-circle"></i>
                        {{ $wanted->getPrice() }} Ft
                    </p>

                    {{-- <p class="card-text">
                        <i class="fas fa-circle"></i>
                        {{ $wanted->preferred_area }}
                    </p> --}}
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    <!-- Játék -->
    @if($user->getGames()->count() > 0)
    <h3 class="d-inline-block mt-5">{{ $user->username }} játékai ({{ $user->getGames()->count() }} db)</h3>
    @if($user->getGames()->count() > 10)
    <a href="/collections/games?user_id={{$user->id}}" class="hoverline-link d-inline-block">Összes mutatása</a>
    @endif
    <div class="owl-carousel">
        @foreach($user->getGamesLimited() as $game)
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

    <!-- Sorozat -->
    @if($user->getSeries()->count() > 0)
    <h3 class="d-inline-block mt-5">{{ $user->username }} sorozatai ({{ $user->getSeries()->count() }} db)</h3>
    @if($user->getSeries()->count() > 10)
    <a href="/collections/series?user_id={{$user->id}}" class="hoverline-link d-inline-block">Összes mutatása</a>
    @endif
    <div class="owl-carousel">
        @foreach($user->getSeriesLimited() as $series)
        <a href="{{ route('series.show', $series->id) }}">
            <div class="item-card mb-4">
                <div class="card-image" style="background-image: url({{ $series->getPhoto() }});"></div>
                <div class="card-body">
                    <h5 class="card-title">{{ $series->title }}</h5>
                    <p class="card-text">{{ count($series->getGames()).' db'  }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif
@stop
