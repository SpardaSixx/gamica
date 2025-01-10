@extends('layouts.default')
 
@section('content')
    @if(Auth::check() && Auth::id() == $wanted->getUser->id && $wanted->is_found == 0)
    <div class="owner-panel p-2 text-center" style="background: rgba(0, 0, 0, .75);">
        <small>Tulajdonosi műveletek</small>
        <br>
        <form action="{{ route('wanteds.destroy', $wanted->id) }}" method="POST" class="d-inline-block">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger my-2" type="submit" onclick="confirmDelete()">
                Törlés
            </button>
        </form>

        <a href="{{ route('wanteds-found', $wanted->id) }}" class="d-inline-block btn btn-red">Lezár</a>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <h2 class="entity-title d-inline-block">{{ $wanted->title }}</h2>
            <a href="{{ route('users.show', $wanted->getUser->id) }}" class="d-inline-block text-light fst-italic">{{ '('.$wanted->getUser->username.')' }}</a>

            @if($wanted->is_found == 1)
            <div class="col-12 text-center">
                <h1 class="alert alert-success" style="dispaly: table; font-size: 1rem; font-weight: 400; margin: 1rem auto;">Lezárt</h1>
            </div>
            @endif
            
            <br>
            <h2 class="entity-title d-inline-block">{{ $wanted->getPrice() }} Ft</h2>
        </div>

        <div class="col-12 col-md-4 col-lg-3">
            <a data-fancybox="gallery" href="{{ $wanted->getPhoto() }}">
                <img src="{{ $wanted->getPhoto() }}" class="mb-3 show-image" style="max-width: 100%;">
            </a>
        </div>

        @if($wanted->gallery_amount > 0)
        <div class="col-12 col-md-4 col-lg-3">
            <div class="row">
                @for($i = 0; $i < $wanted->gallery_amount; $i++)
                <div class="col-6">
                    <a data-fancybox="gallery" href="/img/wanteds/{{ $wanted->id.'_'.strtolower(str_replace(" ", "_", $wanted->title)).'_'.$i }}.jpg">
                        <div class="gallery_image show-image" style="background-image:url(/img/wanteds/{{ $wanted->id.'_'.strtolower(str_replace(" ", "_", $wanted->title)).'_'.$i }}.jpg); background-size: cover; background-position: center; height: 10rem; margin-bottom: 1rem;"></div>
                    </a>
                </div>
                @endfor
            </div>
        </div>
        @endif

        <div class="col-12 col-md-4 col-lg-3">
            <p class="entity-attribute">Konzol: {{ $wanted->getPlatform->title }}</p>

            @if($wanted->release_year)
            <p class="entity-attribute">Kiadás éve: {{ $wanted->release_year }}</p>
            @endif

            @if($wanted->serial_number)
            <p class="entity-attribute">Sorszám: {{ $wanted->serial_number }}</p>
            @endif

            <p class="entity-attribute">Régió: {{ $wanted->getRegion->title }}</p>
            <p class="entity-attribute">Kiadás: {{ $wanted->getRelease->title }}</p>
            <p class="entity-attribute">Borító nyelve: {{ $wanted->getCoverLanguage->title }}</p>
            <p class="entity-attribute">Játék nyelve: {{ $wanted->getGameLanguage->title }}</p>

            @if($wanted->preferred_area)
            <p class="entity-attribute">Preferált terület: {{ $wanted->preferred_area }}</p>
            @endif

            @if($wanted->manual)
            <p class="entity-attribute">Legyen manual</p>
            @else
            <p class="entity-attribute">Nem fontos a manual</p>
            @endif

            @if($wanted->sealed)
            <p class="entity-attribute">Bontatlan</p>
            @endif
            
            @if($wanted->special_edition)
            <p class="entity-attribute">Special edition</p>
            @endif

            <p class="entity-attribute">{{ $wanted->delivery ? 'Szeretne szállítást' : 'Nem szeretne szállítást' }}</p>
        </div>

        @if($wanted->is_found == 0)
        <div class="col-12 text-center">
            @if(Auth::check())
                @if(Auth::id() != $wanted->getUser->id)
                    <a href="{{ route('message-offer', $wanted->id) }}" class="btn btn-red my-3">Üzenet a létrehozónak</a>
                @endif
            @else
                <div class="col-12 text-center">
                    <h1 class="alert alert-success" style="width: fit-content; dispaly: table; font-size: 1rem; font-weight: 400; margin: 2rem auto;">Üzenetküldéshez jelentkezz be!</h1>
                </div>
            @endif
        </div>        
        @endif
        
    </div>

    @section('recommendfromuser')
    @if($wanted->getUser->getWanteds()->count() > 1 && $wanted->getUser->deleted == 0)
    <div class="recommend position-relative p-3 mt-3" style="background: rgba(0, 0, 0, .5);">
        <h3 class="entity-title text-center mb-3">Több játék {{ $wanted->getUser->username }} kéréseiből</h3>
        <div class="owl-carousel">
            @foreach($wanted->getUser->getWanteds() as $recommend)
            @if($recommend->id != $wanted->id)
            <a href="{{ route('wanteds.show', $recommend->id) }}">
                <div class="item-card mb-4 {{ strtolower($recommend->getPlatform->getCompany->name) }}">
                    <div class="card-image position-relative" style="background-image: url({{ $recommend->getPhoto() }});">
                        <p class="card-status {{$recommend->is_found ? 'sold' : ''}} m-0">{{$recommend->is_found ? 'Lezárt' : 'Aktv'}}</p>
                    </div>
                    <div class="card-body" style="height: 9.5rem;">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                        
                        <p class="card-text d-inline-block platform {{ strtolower($recommend->getPlatform->getCompany->name) }}">{{ $recommend->getPlatform->title_short }}</p>
                        
                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $recommend->getPrice() }} Ft
                        </p>
                        
                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $recommend->preferred_area }}
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
    @if($wanted->getPlatform->getWanteds()->count() > 1)
    <div class="recommend position-relative p-3" style="background: rgba(0, 0, 0, .75);">
        <h3 class="entity-title text-center mb-3">Több kérés {{ $wanted->getPlatform->title }} konzolról</h3>
        <div class="owl-carousel">
            @foreach($wanted->getPlatform->getWanteds() as $recommend)
            @if($recommend->id != $wanted->id)
            <a href="{{ route('wanteds.show', $recommend->id) }}">
                <div class="item-card mb-4 {{ strtolower($recommend->getPlatform->getCompany->name) }}">
                    <div class="card-image position-relative" style="background-image: url({{ $recommend->getPhoto() }});">
                        <p class="card-status {{$recommend->is_found ? 'sold' : ''}} m-0">{{$recommend->is_found ? 'Lezárt' : 'Aktv'}}</p>
                    </div>
                    <div class="card-body" style="height: 9.5rem;">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                        <p class="card-text d-inline-block platform {{ strtolower($recommend->getPlatform->getCompany->name) }}">{{ $recommend->getPlatform->title_short }}</p>
                        
                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $recommend->getPrice() }} Ft
                        </p>
                        
                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $recommend->preferred_area }}
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