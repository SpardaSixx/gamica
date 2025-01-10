@extends('layouts.default')
 
@section('content')
    @if(Auth::id() == $accessory->getUser->id && $accessory->is_sold == 0)
        <div class="owner-panel p-2 text-center" style="background: rgba(0, 0, 0, .75);">
            <small>Tulajdonosi műveletek</small>
            <br>
            
            <form action="{{ route('accessories.destroy', $accessory->id) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger my-2" type="submit" onclick="confirmDelete()">
                    Törlés
                </button>
            </form>

            <a href="/sales/accessories/sold/{{$accessory->id}}" class="d-inline-block btn btn-red">Eladva</a>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <h2 class="entity-title d-inline-block">{{ $accessory->title }}</h2>
            <a href="{{ route('users.show', $accessory->getUser->id) }}" class="d-inline-block text-light fst-italic">{{ '('.$accessory->getUser->username.')' }}</a>
            <p class="d-block fst-italic">Megtekintések: {{$accessory->views}}</p>

            @if($accessory->is_sold == 1)
            <div class="col-12 text-center">
                <h1 class="alert alert-success" style="dispaly: table; font-size: 1rem; font-weight: 400; margin: 1rem auto;">Eladva</h1>
            </div>
            @endif
            
            <h2 class="entity-title d-inline-block">{{ $accessory->getPrice() }} Ft</h2>
        </div>

        <div class="col-12 col-md-4 col-lg-3">
            <a data-fancybox="gallery" href="{{ $accessory->getPhoto() }}">
                <img src="{{ $accessory->getPhoto() }}" class="mb-3 show-image" style="max-width: 100%;">
            </a>
        </div>

        @if($accessory->gallery_amount > 0)
        <div class="col-12 col-md-4 col-lg-3">
            <div class="row">
                @for($i = 0; $i < $accessory->gallery_amount; $i++)
                <div class="col-6">
                    <a data-fancybox="gallery" href="/img/accessories/{{ $accessory->getGalleryPhotoName().'_'.$i }}.jpg">
                        <div class="gallery_image show-image" style="background-image:url(/img/accessories/{{ $accessory->getGalleryPhotoName().'_'.$i  }}.jpg); background-size: cover; background-position: center; height: 10rem; margin-bottom: 1rem;"></div>
                    </a>
                </div>
                @endfor
            </div>
        </div>
        @endif

        <div class="col-12 col-md-4 col-lg-3">
            <p class="entity-attribute">Gyártó: {{ $accessory->getCompany->name }}</p>

            @if($accessory->release_year)
            <p class="entity-attribute">Kiadás éve: {{ $accessory->release_year }}</p>
            @endif

            @if($accessory->serial_number)
            <p class="entity-attribute">Sorszám: {{ $accessory->serial_number }}</p>
            @endif

            @if($accessory->box)
            <p class="entity-attribute">Van doboz</p>
            @else
            <p class="entity-attribute">Nincs doboz</p>
            @endif

            @if($accessory->papers)
            <p class="entity-attribute">Vannak papírok</p>
            @else
            <p class="entity-attribute">Nincsenek papírok</p>
            @endif

            @if($accessory->sealed)
            <p class="entity-attribute">Bontatlan</p>
            @endif
            
            @if($accessory->special_edition)
            <p class="entity-attribute">Special edition</p>
            @endif

            <p class="entity-attribute">{{ $accessory->delivery ? 'Van szállítás' : 'Nincs szállítás' }}</p>
        </div>

        @if($accessory->is_sold == 0)
        <div class="col-12 text-center">
            @if(Auth::check())
                @if(Auth::id() != $accessory->getUser->id)
                    <a href="{{ route('message-buy', [3, $accessory->id]) }}" class="btn btn-red my-3">Üzenet az eladónak</a>
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
    @if($accessory->getUser->getAccessories()->count() > 1)
    <div class="recommend position-relative p-3 mt-3" style="background: rgba(0, 0, 0, .5);">
        <h3 class="entity-title text-center mb-3">Több eladó {{ $accessory->getUser->username }} kiegészítőiből</h3>
        <div class="owl-carousel">
            @foreach($accessory->getUser->getAccessories() as $recommend)
            @if($recommend->id != $accessory->id)
            <a href="/sales/accessories/{{$recommend->id}}">
                <div class="item-card mb-4">
                    <div class="card-image position-relative" style="background-image: url({{ $recommend->getPhoto() }});">
                        <p class="card-status {{$recommend->is_sold ? 'sold' : ''}} m-0">{{$recommend->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recommend->title }}</h5>
                        
                        <p class="card-text display-inline-block platform {{ strtolower($recommend->getCompany->name) }}">{{ $recommend->getCompany->name }}</p>
                        
                        <p class="card-text display-inline-block">
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
    @if($accessory->getCompany->getAccessories()->count() > 1)
    <div class="recommend position-relative p-3" style="background: rgba(0, 0, 0, .75);">
        <h3 class="entity-title text-center mb-3">Több eladó kiegészítő {{ $accessory->getCompany->name }} gyártótól</h3>
        <div class="owl-carousel">
            @foreach($accessory->getCompany->getAccessories() as $recommend)
            @if($recommend->id != $accessory->id)
            <a href="/sales/accessories/{{$recommend->id}}">
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