@extends('layouts.default')
 
@section('content')
    @section('mainsearch')
        @include('components.search-form')
    @stop

    @if($queryCategory == 'all')
        @if($resultSales->count() > 0)
            <h2>Eladó játékok - {{$resultSales->count()}} db</h2>
            <section class="result-sales mainsection pb-5">
                <div class="row">
                    @foreach($resultSales as $sales)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="/sales/games/{{$sales->id}}" class="sale-card">
                            <div class="item-card mb-4">
                                <div class="card-image position-relative" style="background-image: url({{ $sales->getPhoto() }});">
                                    <p class="card-status {{$sales->is_sold ? 'sold' : ''}} m-0">{{$sales->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">{{ $sales->title }}</h5>
                                        
                                    <p class="card-text d-inline-block platform {{ strtolower($sales->getPlatform->getCompany->name) }}">{{ $sales->getPlatform->title_short }}</p>
                                    
                                    <p class="card-text d-inline-block">
                                        <i class="fas fa-circle"></i>
                                        {{ $sales->getPrice() }} Ft
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($resultConsoles->count() > 0)
            <h2>Eladó konzolok - {{$resultConsoles->count()}} db</h2>
            <section class="result-platforms mainsection pb-5">
                <div class="row">
                    @foreach($resultConsoles as $console)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('consoles.show', $console->id) }}" class="sale-card">
                            <div class="item-card mb-4">
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
                    </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($resultAccessories->count() > 0)
            <h2>Eladó kiegészítők - {{$resultAccessories->count()}} db</h2>
            <section class="result-platforms mainsection pb-5">
                <div class="row">
                    @foreach($resultAccessories as $accessory)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('accessories.show', $accessory->id) }}" class="sale-card">
                            <div class="item-card mb-4">
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
                    </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($resultPacks->count() > 0)
            <h2>Eladó csomagok - {{$resultPacks->count()}} db</h2>
            <section class="result-platforms mainsection pb-5">
                <div class="row">
                    @foreach($resultPacks as $pack)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('packs.show', $pack->id) }}" class="sale-card">
                            <div class="item-card mb-4">
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
                    </div>
                    @endforeach
                </div>
            </section>
        @endif
        
        @if($resultWanteds->count() > 0)
            <h2>Kérések - {{$resultWanteds->count()}} db</h2>
            <section class="result-wanteds mainsection pb-5">
                <div class="row">
                    @foreach($resultWanteds as $wanted)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('wanteds.show', $wanted->id) }}" class="wanted-card">
                            <div class="item-card mb-4">
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
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>
        @endif
        
        @if($resultGames->count() > 0)
            <h2>Gyűjtemény játékok - {{$resultGames->count()}} db</h2>
            <section class="result-games mainsection pb-5">
                <div class="row">
                    @foreach($resultGames as $game)
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
            </section>
        @endif

        @if($resultSeries->count() > 0)
            <h2>Sorozatok - {{$resultSeries->count()}} db</h2>
            <section class="result-collections mainsection pb-5">
                <div class="row">
                    @foreach($resultSeries as $series)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('series.show', $series->id) }}" class="game-card">
                            <div class="item-card mb-4">
                                <div class="card-image" style="background-image: url({{ $series->getPhoto() }});"></div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $series->title }}</h5>
                                    <p class="card-text">{{ count($series->getGames()).' db'  }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($resultSales->count() == 0 && $resultConsoles->count() == 0 && $resultAccessories->count() == 0 && $resultPacks->count() == 0 && $resultWanteds->count() == 0 && $resultGames->count() == 0 && $resultSeries->count() == 0)
            <h4 class="text-center pb-3 mb-0">Nincs aktív találat a kifejezésre!</h4>
        @endif
    @elseif($queryCategory == 'sales')
        @if($resultSales->count() > 0)
            <h2>Eladó játékok - {{$resultSales->count()}} db</h2>
            <section class="result-sales mainsection pb-5">
                <div class="row">
                    @foreach($resultSales as $sales)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="/sales/games/{{$sales->id}}" class="sale-card">
                            <div class="item-card mb-4">
                                <div class="card-image position-relative" style="background-image: url({{ $sales->getPhoto() }});">
                                    <p class="card-status {{$sales->is_sold ? 'sold' : ''}} m-0">{{$sales->is_sold ? 'Eladva' : 'Elérhető'}}</p>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">{{ $sales->title }}</h5>
                                        
                                    <p class="card-text d-inline-block platform {{ strtolower($sales->getPlatform->getCompany->name) }}">{{ $sales->getPlatform->title_short }}</p>
                                    
                                    <p class="card-text d-inline-block">
                                        <i class="fas fa-circle"></i>
                                        {{ $sales->getPrice() }} Ft
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>
        @else
            <h4 class="text-center pb-3 mb-0">Nincs aktív találat a kifejezésre!</h4>
        @endif
    @elseif($queryCategory == 'consoles')
        @if($resultConsoles->count() > 0)
            <h2>Eladó konzolok - {{$resultConsoles->count()}} db</h2>
            <section class="result-platforms mainsection pb-5">
                <div class="row">
                    @foreach($resultConsoles as $console)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('consoles.show', $console->id) }}" class="sale-card">
                            <div class="item-card mb-4">
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
                    </div>
                    @endforeach
                </div>
            </section>
        @else
            <h4 class="text-center pb-3 mb-0">Nincs aktív találat a kifejezésre!</h4>
        @endif
    @elseif($queryCategory == 'accessories')
        @if($resultAccessories->count() > 0)
            <h2>Eladó kiegészítők - {{$resultAccessories->count()}} db</h2>
            <section class="result-platforms mainsection pb-5">
                <div class="row">
                    @foreach($resultAccessories as $accessory)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('accessories.show', $accessory->id) }}" class="sale-card">
                            <div class="item-card mb-4">
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
                    </div>
                    @endforeach
                </div>
            </section>
        @else
            <h4 class="text-center pb-3 mb-0">Nincs aktív találat a kifejezésre!</h4>
        @endif
    @elseif($queryCategory == 'packs')
        @if($resultPacks->count() > 0)
            <h2>Eladó csomagok - {{$resultPacks->count()}} db</h2>
            <section class="result-platforms mainsection pb-5">
                <div class="row">
                    @foreach($resultPacks as $pack)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('packs.show', $pack->id) }}" class="sale-card">
                            <div class="item-card mb-4">
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
                    </div>
                    @endforeach
                </div>
            </section>
        @else
            <h4 class="text-center pb-3 mb-0">Nincs aktív találat a kifejezésre!</h4>
        @endif
    @elseif($queryCategory == 'wanteds')
        @if($resultWanteds->count() > 0)
            <h2>Kérések - {{$resultWanteds->count()}} db</h2>
            <section class="result-wanteds mainsection pb-5">
                <div class="row">
                    @foreach($resultWanteds as $wanted)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('wanteds.show', $wanted->id) }}" class="wanted-card">
                            <div class="item-card mb-4">
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
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>
        @else
            <h4 class="text-center pb-3 mb-0">Nincs aktív találat a kifejezésre!</h4>
        @endif
    @elseif($queryCategory == 'games')
        @if($resultGames->count() > 0)
            <h2>Gyűjtemény játékok - {{$resultGames->count()}} db</h2>
            <section class="result-games mainsection pb-5">
                <div class="row">
                    @foreach($resultGames as $game)
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
            </section>
        @else
            <h4 class="text-center pb-3 mb-0">Nincs aktív találat a kifejezésre!</h4>
        @endif
    @elseif($queryCategory == 'series')
        @if($resultSeries->count() > 0)
            <h2>Sorozatok - {{$resultSeries->count()}} db</h2>
            <section class="result-collections mainsection pb-5">
                <div class="row">
                    @foreach($resultSeries as $series)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('series.show', $series->id) }}" class="game-card">
                            <div class="item-card mb-4">
                                <div class="card-image" style="background-image: url({{ $series->getPhoto() }});"></div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $series->title }}</h5>
                                    <p class="card-text">{{ count($series->getGames()).' db'  }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>
        @else
            <h4 class="text-center pb-3 mb-0">Nincs aktív találat a kifejezésre!</h4>
        @endif
    @endif
@stop

