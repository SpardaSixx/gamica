@extends('layouts.default')
 
@section('content')
    @if(Auth::id() == $console->getUser->id && $console->is_sold == 0)
        <div class="owner-panel p-2 text-center" style="background: rgba(0, 0, 0, .75);">
            <small>Tulajdonosi műveletek</small>
            <br>
            
            <form action="{{ route('consoles.destroy', $console->id) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger my-2" type="submit" onclick="confirmDelete()">
                    Törlés
                </button>
            </form>

            <a href="/sales/consoles/sold/{{$console->id}}" class="d-inline-block btn btn-red">Eladva</a>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <h2 class="entity-title d-inline-block">{{ $console->title }}</h2>
            <a href="{{ route('users.show', $console->getUser->id) }}" class="d-inline-block text-light fst-italic">{{ '('.$console->getUser->username.')' }}</a>
            <p class="d-block fst-italic">Megtekintések: {{$console->views}}</p>

            @if($console->is_sold == 1)
            <div class="col-12 text-center">
                <h1 class="alert alert-success" style="dispaly: table; font-size: 1rem; font-weight: 400; margin: 1rem auto;">Eladva</h1>
            </div>
            @endif
            
            <h2 class="entity-title d-inline-block">{{ $console->getPrice() }} Ft</h2>
        </div>

        <div class="col-12 col-md-4 col-lg-3">
            <a data-fancybox="gallery" href="{{ $console->getPhoto() }}">
                <img src="{{ $console->getPhoto() }}" class="mb-3 show-image" style="max-width: 100%;">
            </a>
        </div>

        @if($console->gallery_amount > 0)
        <div class="col-12 col-md-4 col-lg-3">
            <div class="row">
                @for($i = 0; $i < $console->gallery_amount; $i++)
                <div class="col-6">
                    <a data-fancybox="gallery" href="/img/consoles/{{ $console->getGalleryPhotoName().'_'.$i }}.jpg">
                        <div class="gallery_image show-image" style="background-image:url(/img/consoles/{{ $console->getGalleryPhotoName().'_'.$i }}.jpg); background-size: cover; background-position: center; height: 10rem; margin-bottom: 1rem;"></div>
                    </a>
                </div>
                @endfor
            </div>
        </div>
        @endif

        <div class="col-12 col-md-4 col-lg-3">
            <p class="entity-attribute">Gyártó: {{ $console->getCompany->name }}</p>

            @if($console->release_year)
            <p class="entity-attribute">Kiadás éve: {{ $console->release_year }}</p>
            @endif

            @if($console->serial_number)
            <p class="entity-attribute">Sorszám: {{ $console->serial_number }}</p>
            @endif

            <p class="entity-attribute">Régió: {{ $console->getRegion->title }}</p>

            @if($console->version)
            <p class="entity-attribute">Verzió: {{ $console->version }}</p>
            @endif

            @if($console->box)
            <p class="entity-attribute">Van doboz</p>
            @else
            <p class="entity-attribute">Nincs doboz</p>
            @endif

            @if($console->papers)
            <p class="entity-attribute">Vannak papírok</p>
            @else
            <p class="entity-attribute">Nincsenek papírok</p>
            @endif

            @if($console->sealed)
            <p class="entity-attribute">Bontatlan</p>
            @endif
            
            @if($console->special_edition)
            <p class="entity-attribute">Special edition</p>
            @endif

            <p class="entity-attribute">{{ $console->delivery ? 'Van szállítás' : 'Nincs szállítás' }}</p>
        </div>

        @if($console->is_sold == 0)
        <div class="col-12 text-center">
            @if(Auth::check())
                @if(Auth::id() != $console->getUser->id)
                    <a href="{{ route('message-buy',[2, $console->id]) }}" class="btn btn-red my-3">Üzenet az eladónak</a>
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
    @if($console->getUser->getConsoles()->count() > 1)
    <div class="recommend position-relative p-3 mt-3" style="background: rgba(0, 0, 0, .5);">
        <h3 class="entity-title text-center mb-3">Több eladó {{ $console->getUser->username }} konzoljaiból</h3>
        <div class="owl-carousel">
            @foreach($console->getUser->getConsoles() as $recommend)
            @if($recommend->id != $console->id)
            <a href="/sales/consoles/{{$recommend->id}}">
                <div class="item-card mb-4">
                    <div class="card-image position-relative" style="background-image: url({{ $recommend->getPhoto() }});">
                        <p class="card-status {{$recommend->is_sold ? 'sold' : ''}} m-0">{{$recommend->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                        
                        <p class="card-text d-inline-block platform {{ strtolower($recommend->getCompany->name) }}">{{ $recommend->getCompany->name }}</p>
                        
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
    @if($console->getCompany->getConsoles()->count() > 1)
    <div class="recommend position-relative p-3" style="background: rgba(0, 0, 0, .75);">
        <h3 class="entity-title text-center mb-3">Több eladó konzol {{ $console->getCompany->name }} gyártótól</h3>
        <div class="owl-carousel">
            @foreach($console->getCompany->getConsoles() as $recommend)
            @if($recommend->id != $console->id)
            <a href="/sales/consoles/{{$recommend->id}}">
                <div class="item-card mb-4">
                    <div class="card-image position-relative" style="background-image: url({{ $recommend->getPhoto() }});">
                        <p class="card-status {{$recommend->is_sold ? 'sold' : ''}} m-0">{{$recommend->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                        
                        <p class="card-text d-inline-block platform {{ strtolower($recommend->getCompany->name) }}">{{ $recommend->getCompany->name }}</p>
                        
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