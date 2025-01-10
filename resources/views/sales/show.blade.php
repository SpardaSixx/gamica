@extends('layouts.default')
 
@section('content')
    @if(Auth::id() == $sale->getUser->id && $sale->is_sold == 0)
        <div class="owner-panel p-2 text-center" style="background: rgba(0, 0, 0, .75);">
            <small>Tulajdonosi műveletek</small>
            <br>
            
            <form action="/sales/games/{{$sale->id}}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger my-2" type="submit" onclick="confirmDelete()">
                    Törlés
                </button>
            </form>

            <a href="/sales/games/sold/{{$sale->id}}" class="d-inline-block btn btn-red">Eladva</a>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <h2 class="entity-title d-inline-block">{{ $sale->title }}</h2>
            <a href="{{ route('users.show', $sale->getUser->id) }}" class="d-inline-block text-light fst-italic">{{ '('.$sale->getUser->username.')' }}</a>
            <p class="d-block fst-italic">Megtekintések: {{$sale->views}}</p>

            @if($sale->is_sold == 1)
            <div class="col-12 text-center">
                <h1 class="alert alert-success" style="dispaly: table; font-size: 1rem; font-weight: 400; margin: 1rem auto;">Eladva</h1>
            </div>
            @endif
            
            <h2 class="entity-title d-inline-block">{{ $sale->getPrice() }} Ft</h2>
        </div>

        <div class="col-12 col-md-4 col-lg-3">
            <a data-fancybox="gallery" href="{{ $sale->getPhoto() }}">
                <img src="{{ $sale->getPhoto() }}" class="mb-3 show-image" style="max-width: 100%;">
            </a>
        </div>

        @if($sale->gallery_amount > 0)
        <div class="col-12 col-md-4 col-lg-3">
            <div class="row">
                @for($i = 0; $i < $sale->gallery_amount; $i++)
                <div class="col-6">
                    <a data-fancybox="gallery" href="/img/sales/{{ $sale->getGalleryPhotoName().'_'.$i }}.jpg">
                        <div class="gallery_image show-image" style="background-image:url(/img/sales/{{ $sale->getGalleryPhotoName().'_'.$i }}.jpg); background-size: cover; background-position: center; height: 10rem; margin-bottom: 1rem;"></div>
                    </a>
                </div>
                @endfor
            </div>
        </div>
        @endif

        <div class="col-12 col-md-4 col-lg-3">
            <p class="entity-attribute">Konzol: {{ $sale->getPlatform->title }}</p>

            @if($sale->release_year)
            <p class="entity-attribute">Kiadás éve: {{ $sale->release_year }}</p>
            @endif

            @if($sale->serial_number)
            <p class="entity-attribute">Sorszám: {{ $sale->serial_number }}</p>
            @endif

            <p class="entity-attribute">Régió: {{ $sale->getRegion->title }}</p>
            <p class="entity-attribute">Kiadás: {{ $sale->getRelease->title }}</p>
            <p class="entity-attribute">Borító nyelve: {{ $sale->getCoverLanguage->title }}</p>
            <p class="entity-attribute">Játék nyelve: {{ $sale->getGameLanguage->title }}</p>

            @if($sale->manual)
            <p class="entity-attribute">Van manual</p>
            @else
            <p class="entity-attribute">Nincs manual</p>
            @endif

            @if($sale->sealed)
            <p class="entity-attribute">Bontatlan</p>
            @endif
            
            @if($sale->special_edition)
            <p class="entity-attribute">Special edition</p>
            @endif

            <p class="entity-attribute">{{ $sale->delivery ? 'Van szállítás' : 'Nincs szállítás' }}</p>
        </div>

        @if($sale->is_sold == 0)
        <div class="col-12 text-center">
            @if(Auth::check())
                @if(Auth::id() != $sale->getUser->id)
                    <a href="{{ route('message-buy', [1, $sale->id]) }}" class="btn btn-red my-3">Üzenet az eladónak</a>
                @endif
            @else
                <div class="col-12 text-center">
                    <h1 class="alert alert-success" style="width: fit-content; dispaly: table; font-size: 1rem; font-weight: 400; margin: 2rem auto;">Üzenetküldéshez jelentkezz be!</h1><br>
                </div>
            @endif
        </div>        
        @endif
        
    </div>

    @section('recommendfromuser')
    @if($sale->getUser->getSales()->count() > 1)
    <div class="recommend position-relative p-3 mt-3" style="background: rgba(0, 0, 0, .5);">
        <h3 class="entity-title text-center mb-3">Több eladó {{ $sale->getUser->username }} játékaiból</h3>
        <div class="owl-carousel">
            @foreach($sale->getUser->getSales() as $recommend)
            @if($recommend->id != $sale->id)
            <a href="/sales/games/{{$recommend->id}}">
                <div class="item-card mb-4">
                    <div class="card-image position-relative" style="background-image: url({{ $recommend->getPhoto() }});">
                        <p class="card-status {{$recommend->is_sold ? 'sold' : ''}} m-0">{{$recommend->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                        
                        <p class="card-text d-inline-block platform {{ strtolower($recommend->getPlatform->getCompany->name) }}">{{ $recommend->getPlatform->title_short }}</p>
                        
                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $recommend->getPrice() }} Ft
                        </p>
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
    @if($sale->getPlatform->getSales()->count() > 1)
    <div class="recommend position-relative p-3" style="background: rgba(0, 0, 0, .75);">
        <h3 class="entity-title text-center mb-3">Több eladó játék {{ $sale->getPlatform->title }} konzolról</h3>
        <div class="owl-carousel">
            @foreach($sale->getPlatform->getSales() as $recommend)
            @if($recommend->id != $sale->id)
            <a href="/sales/games/{{$recommend->id}}">
                <div class="item-card mb-4">
                    <div class="card-image position-relative" style="background-image: url({{ $recommend->getPhoto() }});">
                        <p class="card-status {{$recommend->is_sold ? 'sold' : ''}} m-0">{{$recommend->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                        
                        <p class="card-text d-inline-block platform {{ strtolower($recommend->getPlatform->getCompany->name) }}">{{ $recommend->getPlatform->title_short }}</p>
                        
                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $recommend->getPrice() }} Ft
                        </p>
                    </div>
                </div>
            </a>
            @endif
            @endforeach
        </div>
    </div>
    @endif
    @stop
@stop