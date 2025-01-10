@extends('layouts.default')
 
@section('content')
    @if(Auth::id() == $pack->getUser->id && $pack->is_sold == 0)
        <div class="owner-panel p-2 text-center" style="background: rgba(0, 0, 0, .75);">
            <small>Tulajdonosi műveletek</small>
            <br>
            
            <form action="{{ route('packs.destroy', $pack->id) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger my-2" type="submit" onclick="confirmDelete()">
                    Törlés
                </button>
            </form>

            <a href="/sales/packs/sold/{{$pack->id}}" class="d-inline-block btn btn-red">Eladva</a>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <h2 class="entity-title d-inline-block">{{ $pack->title }}</h2>
            <a href="{{ route('users.show', $pack->getUser->id) }}" class="d-inline-block text-light fst-italic">{{ '('.$pack->getUser->username.')' }}</a>
            <p class="d-block fst-italic">Megtekintések: {{$pack->views}}</p>

            @if($pack->is_sold == 1)
            <div class="col-12 text-center">
                <h1 class="alert alert-success" style="dispaly: table; font-size: 1rem; font-weight: 400; margin: 1rem auto;">Eladva</h1>
            </div>
            @endif
            
            <h2 class="entity-title d-inline-block">{{ $pack->getPrice() }} Ft</h2>
        </div>

        <div class="col-12 col-md-4 col-lg-3">
            <a data-fancybox="gallery" href="{{ $pack->getPhoto() }}">
                <img src="{{ $pack->getPhoto() }}" class="mb-3 show-image" style="max-width: 100%;">
            </a>
        </div>

        @if($pack->gallery_amount > 0)
        <div class="col-12 col-md-4 col-lg-3">
            <div class="row">
                @for($i = 0; $i < $pack->gallery_amount; $i++)
                <div class="col-6">
                    <a data-fancybox="gallery" href="/img/packs/{{ $pack->getGalleryPhotoName().'_'.$i }}.jpg">
                        <div class="gallery_image show-image" style="background-image:url(/img/packs/{{ $pack->getGalleryPhotoName().'_'.$i }}.jpg); background-size: cover; background-position: center; height: 10rem; margin-bottom: 1rem;"></div>
                    </a>
                </div>
                @endfor
            </div>
        </div>
        @endif

        <div class="col-12 col-md-4 col-lg-3">
            <p class="entity-attribute">{{ $pack->description }}</p>

            <p class="entity-attribute">{{ $pack->delivery ? 'Van szállítás' : 'Nincs szállítás' }}</p>
        </div>

        @if($pack->is_sold == 0)
        <div class="col-12 text-center">
            @if(Auth::check())
                @if(Auth::id() != $pack->getUser->id)
                    <a href="{{ route('message-buy',[4, $pack->id]) }}" class="btn btn-red my-3">Üzenet az eladónak</a>
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
    @if($pack->getUser->getPacks()->count() > 1)
    <div class="recommend position-relative p-3 mt-3" style="background: rgba(0, 0, 0, .5);">
        <h3 class="entity-title text-center mb-3">Több eladó {{ $pack->getUser->username }} csomagjaiból</h3>
        <div class="owl-carousel">
            @foreach($pack->getUser->getPacks() as $recommend)
            @if($recommend->id != $pack->id)
            <a href="/sales/packs/{{$recommend->id}}">
                <div class="item-card mb-4">
                    <div class="card-image position-relative" style="background-image: url({{ $recommend->getPhoto() }});">
                        <p class="card-status {{$recommend->is_sold ? 'sold' : ''}} m-0">{{$recommend->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                                                
                        <p class="card-text">
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