@extends('layouts.default')

@section('content')
    @section('mainsearch')
        @include('components.search-form')
    @stop

    <!-- Gyorslinkek -->
    <h2 class="entity-title">Gyorslinkek</h2>
    <a href="#highlights" class="badge quicklink">Kiemelt hirdetések</a>
    <a href="#sales" class="badge quicklink">Új eladó játékok</a>
    <a href="#consoles" class="badge quicklink">Új eladó konzolok</a>
    <a href="#accessories" class="badge quicklink">Új eladó kiegészítők</a>
    <a href="#packs" class="badge quicklink">Új eladó csomagok</a>
    <a href="#wanteds" class="badge quicklink">Új kérések</a>
    <a href="#games" class="badge quicklink">Új gyűjtemény játékok</a>
    <a href="#series" class="badge quicklink">Új sorozatok</a>

    <br><br>

    <h2 class="entity-title" id="highlights">Kiemelt hirdetések</h2>
    <section class="highlighted mainsection mb-5 py-3">
        <div class="owl-carousel">
            @if($highlights->count() > 0)
                @foreach($highlights as $highlight)
                    <a href="/sales/{{$highlight->item_type}}/{{$highlight->item_id}}">
                        <div class="item-card">
                            <div class="card-image position-relative" style="background-image: url({{ $highlight->getItem($highlight->item_id)->getPhoto() }});">
                                <p class="card-status m-0" style="background: rgba(0, 0, 0, .75);">{{$highlight->getItem($highlight->item_id)->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $highlight->getItem($highlight->item_id)->title }}</h5>
                                
                                @if($highlight->getItem($highlight->item_id)->company_id)
                                <p class="card-text d-inline-block platform {{ strtolower($highlight->getItem($highlight->item_id)->getCompany->name) }}">{{ $highlight->getItem($highlight->item_id)->getCompany->name }}</p>
                                @endif

                                @if($highlight->getItem($highlight->item_id)->platform_id)
                                <p class="card-text d-inline-block platform {{ strtolower($highlight->getItem($highlight->item_id)->getPlatform->getCompany->name) }}">{{ $highlight->getItem($highlight->item_id)->getPlatform->title_short }}</p>
                                @endif

                                <p class="card-text d-inline-block">
                                    @if($highlight->item_type != 'packs')
                                    <i class="fas fa-circle"></i>
                                    @endif
                                    {{ $highlight->getItem($highlight->item_id)->getPrice() }} Ft
                                </p>
                            </div>
                        </div>
                    </a>            
                @endforeach
            @endif
        </div>        
    </section>

    <!-- Eladó játékok -->
    <h2 class="entity-title" id="sales">Új eladó játékok</h2>
    <section class="new-sales mainsection mb-5">
        @if($sales->count() > 0)
        <div class="owl-carousel">
            @foreach($sales as $sale)
            <a href="/sales/games/{{$sale->id}}">
                <div class="item-card">
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
            <a href="/sales/games">
                <div class="item-card">
                    <div class="card-body">
                        <h5 class="card-title">Összes mutatása</h5>
                    </div>
                </div>
            </a>
        </div>
        @else
        <p class="text-center">Jelenleg nincs aktív adás-vétel!</p>
        @endif
    </section>

    <!-- Eladó konzolok -->
    <h2 class="entity-title" id="consoles">Új eladó konzolok</h2>
    <section class="new-sales mainsection mb-5">
        @if($consoles->count() > 0)
        <div class="owl-carousel">
            @foreach($consoles as $console)
            <a href="{{route('consoles.show', $console->id)}}">
                <div class="item-card">
                    <div class="card-image position-relative" style="background-image: url({{ $console->getPhoto() }});">
                        <p class="card-status {{$console->is_sold ? 'sold' : ''}} m-0">{{$console->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $console->title }}</h5>
                        
                        <p class="card-text d-inline-block platform {{ strtolower($console->getCompany->name) }}">{{ $console->getCompany->name }}</p>
                        
                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $console->getPrice() }} Ft
                        </p>
                    </div>
                </div>
            </a>            
            @endforeach
            <a href="{{route('consoles.index')}}">
                <div class="item-card">
                    <div class="card-body">
                        <h5 class="card-title">Összes mutatása</h5>
                    </div>
                </div>
            </a>
        </div>
        @else
        <p class="text-center">Jelenleg nincs aktív eladó konzol!</p>
        @endif
    </section>

    <!-- Eladó kiegészítők -->
    <h2 class="entity-title" id="accessories">Új eladó kiegészítők</h2>
    <section class="new-accessories mainsection mb-5">
        @if($accessories->count() > 0)
        <div class="owl-carousel">
            @foreach($accessories as $accessory)
            <a href="{{route('accessories.show', $accessory->id)}}">
                <div class="item-card">
                    <div class="card-image position-relative" style="background-image: url({{ $accessory->getPhoto() }});">
                        <p class="card-status {{$accessory->is_sold ? 'sold' : ''}} m-0">{{$accessory->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $accessory->title }}</h5>
                        
                        <p class="card-text d-inline-block platform {{ strtolower($accessory->getCompany->name) }}">{{ $accessory->getCompany->name }}</p>
                        
                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $accessory->getPrice() }} Ft
                        </p>
                    </div>
                </div>
            </a>            
            @endforeach
            <a href="{{route('accessories.index')}}">
                <div class="item-card">
                    <div class="card-body">
                        <h5 class="card-title">Összes mutatása</h5>
                    </div>
                </div>
            </a>
        </div>
        @else
        <p class="text-center">Jelenleg nincs aktív eladó kiegészítő!</p>
        @endif
    </section>

    <!-- Eladó csomagok -->
    <h2 class="entity-title" id="packs">Új eladó csomagok</h2>
    <section class="new-packs mainsection mb-5">
        @if($accessories->count() > 0)
        <div class="owl-carousel">
            @foreach($packs as $pack)
            <a href="{{route('packs.show', $pack->id)}}">
                <div class="item-card">
                    <div class="card-image position-relative" style="background-image: url({{ $pack->getPhoto() }});">
                        <p class="card-status {{$pack->is_sold ? 'sold' : ''}} m-0">{{$pack->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $pack->title }}</h5>
                                                
                        <p class="card-text d-inline-block">
                            {{ $pack->getPrice() }} Ft
                        </p>
                    </div>
                </div>
            </a>            
            @endforeach
            <a href="{{route('packs.index')}}">
                <div class="item-card">
                    <div class="card-body">
                        <h5 class="card-title">Összes mutatása</h5>
                    </div>
                </div>
            </a>
        </div>
        @else
        <p class="text-center">Jelenleg nincs aktív eladó csomag!</p>
        @endif
    </section>

    <!-- Kérések -->
    <h2 class="entity-title" id="wanteds">Új kérések</h2>
    <section class="new-wanteds mainsection mb-5">
        @if($wanteds->count() > 0)
        <div class="owl-carousel">
            @foreach($wanteds as $wanted)
            <a href="{{ route('wanteds.show', $wanted->id) }}">
                <div class="item-card">
                    <div class="card-image position-relative" style="background-image: url({{ $wanted->getPhoto() }});">
                        <p class="card-status {{$wanted->is_found ? 'sold' : ''}} m-0">{{$wanted->is_found ? 'Lezárt' : 'Aktív'}}</p>
                    </div>
                    <div class="card-body">
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
            <a href="{{ route('wanteds.index') }}">
                <div class="item-card">
                    <div class="card-body">
                        <h5 class="card-title">Összes mutatása</h5>
                    </div>
                </div>
            </a>
        </div>
        @else
        <p class="text-center">Jelenleg nincs aktív kérés!</p>
        @endif
    </section>

    <!-- Gyűjtemény játékok -->
    <h2 class="entity-title" id="games">Új gyűjtemény játékok</h2>
    <section class="new-games mainsection mb-5">
        @if($games->count() > 0)
        <div class="owl-carousel">
            @foreach($games as $game)
            <a href="/collections/games/{{$game->id}}">
                <div class="item-card">
                    <div class="card-image" style="background-image: url({{ $game->getPhoto() }});"></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $game->title }}</h5>
                        <p class="card-text d-inline-block platform {{ strtolower($game->getPlatform->getCompany->name) }}">{{ $game->getPlatform->title_short }}</p>
                    </div>
                </div>
            </a>            
            @endforeach
            <a href="/collections/games/">
                <div class="item-card">
                    <div class="card-body">
                        <h5 class="card-title">Összes mutatása</h5>
                    </div>
                </div>
            </a>
        </div>
        @else
        <p class="text-center">Jelenleg nincs aktív játék!</p>
        @endif
    </section>

    <!-- Sorozatok -->
    <h2 class="entity-title" id="series">Új sorozatok</h2>
    <section class="new-collections mainsection mb-5">
        @if($series->count() > 0)
        <div class="owl-carousel">
            @foreach($series as $s)
            <a href="{{ route('series.show', $s->id) }}">
                <div class="item-card">
                    <div class="card-image" style="background-image: url({{ $s->getPhoto() }});"></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $s->title }}</h5>
                        <p class="card-text d-inline-block">{{ count($s->getGames()).' db'  }}</p>
                    </div>
                </div>
            </a>            
            @endforeach
            <a href="{{ route('series.index') }}">
                <div class="item-card">
                    <div class="card-body">
                        <h5 class="card-title">Összes mutatása</h5>
                    </div>
                </div>
            </a>
        </div>
        @else
        <p class="text-center">Jelenleg nincs aktív gyűjtemény!</p>
        @endif
    </section>
@stop
