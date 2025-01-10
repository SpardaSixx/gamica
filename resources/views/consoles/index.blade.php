@extends('layouts.default')
 
@section('content')
    <h2 class="page-title text-center mb-5">Eladó konzolok</h2>

    <div class="filter-kit-desktop mb-3 position-relative">
        <form  action="/sales/consoles" method="get" class="filter-form">
            <div class="filters">
                <div class="form-group d-inline-block me-2 mb-2">
                    <input type="text" class="form-control input-dark mb-1" name="title" placeholder="Cím" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <select class="form-control input-dark mb-1" name="company_id">
                        <option selected disabled>Gyártó</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ isset($_GET['company_id']) && $_GET['company_id'] == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <select class="form-control input-dark mb-1" name="region_id">
                        <option selected disabled>Régió</option>
                        @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ isset($_GET['region_id']) && $_GET['region_id'] == $region->id ? 'selected' : '' }}>{{ $region->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <input type="text" class="form-control input-dark mb-1" name="version" placeholder="Verzió" value="{{ isset($_GET['version']) ? $_GET['version'] : '' }}">
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <select class="form-control input-dark mb-1" name="user_id">
                        <option selected disabled>Tag</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ isset($_GET['user_id']) && $_GET['user_id'] == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                        @endforeach
                    </select>
                </div>

                <br>

                <label class="check-container d-inline-block me-2">Doboz
                    <input type="checkbox" class="form-check-input mb-1" id="box" name="box" {{ isset($_GET['box']) && $_GET['box'] == 'on' ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                </label>

                <label class="check-container d-inline-block me-2">Papírok
                    <input type="checkbox" class="form-check-input mb-1" id="papers" name="papers" {{ isset($_GET['papers']) && $_GET['papers'] == 'on' ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                </label>

                <label class="check-container d-inline-block me-2">Special edition
                    <input type="checkbox" class="form-check-input mb-1" id="special_edition" name="special_edition" {{ isset($_GET['special_edition']) && $_GET['special_edition'] == 'on' ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                </label>

                <label class="check-container d-inline-block me-2">Bontatlan
                    <input type="checkbox" class="form-check-input mb-1" id="sealed" name="sealed" {{ isset($_GET['sealed']) && $_GET['sealed'] == 'on' ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                </label>

                <label class="check-container d-inline-block me-2">Posta
                    <input type="checkbox" class="form-check-input mb-1" id="delivery" name="delivery" {{ isset($_GET['delivery']) && $_GET['delivery'] == 'on' ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                </label>
            </div>

            <button type="submit" class="btn btn-red d-inline-block mt-2 me-2 px-4">Szűrés</button>
            <a href="/sales/consoles" class="d-inline-block mt-2" style="color: #eee;">Szűrők törlése</a>

            <div class="orderby position-absolute dropdown">
                <button class="btn btn-drk dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="material-symbols-outlined">
                        swap_vert
                    </span>
                </button>

                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" name="orderby" value="title_asc">Név szerint növekvő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="title_desc">Név szerint csökkenő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="price_asc">Ár szerint növekvő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="price_desc">Ár szerint csökkenő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="views_asc">Nézettség szerint növekvő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="views_desc">Nézettség szerint csökkenő</button></li>
                </ul>
            </div>
        </form>
    </div>

    <div class="filter-kit-mobile mb-3">
        <form  action="/sales/consoles" method="get" class="filter-form">
            <a class="btn btn-red d-inline-block mt-2 me-2 px-2" style="line-height: 1;" data-bs-toggle="collapse" href="#collapseFilters" role="button" aria-expanded="false" aria-controls="collapseFilters">
                <span class="material-symbols-outlined">
                    filter_alt
                </span>
            </a>

            <button class="btn btn-red mt-2 me-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="material-symbols-outlined">
                    swap_vert
                </span>
            </button>

            <ul class="dropdown-menu">
                <li><button class="dropdown-item" name="orderby" value="title_asc">Név szerint növekvő</button></li>
                <li><button class="dropdown-item" name="orderby" value="title_desc">Név szerint csökkenő</button></li>
                <li><button class="dropdown-item" name="orderby" value="price_asc">Ár szerint növekvő</button></li>
                <li><button class="dropdown-item" name="orderby" value="price_desc">Ár szerint csökkenő</button></li>
                <li><button class="dropdown-item" name="orderby" value="views_asc">Nézettség szerint növekvő</button></li>
                <li><button class="dropdown-item" name="orderby" value="views_desc">Nézettség szerint csökkenő</button></li>
            </ul>

            <div class="collapse" id="collapseFilters">
                <div class="filters mt-3">
                    <div class="form-group d-inline-block me-2">
                        <input type="text" class="form-control input-dark mb-1" name="title" placeholder="Cím" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                    </div>

                    <div class="form-group d-inline-block me-2">
                        <select class="form-control input-dark mb-1" name="company_id">
                            <option selected disabled>Gyártó</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ isset($_GET['company_id']) && $_GET['company_id'] == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-inline-block me-2">
                        <select class="form-control input-dark mb-1" name="region_id">
                            <option selected disabled>Régió</option>
                            @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ isset($_GET['region_id']) && $_GET['region_id'] == $region->id ? 'selected' : '' }}>{{ $region->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-inline-block me-2">
                        <input type="text" class="form-control input-dark mb-1" name="version" placeholder="Verzió" value="{{ isset($_GET['version']) ? $_GET['version'] : '' }}">
                    </div>

                    <div class="form-group d-inline-block me-2 mb-2">
                        <select class="form-control input-dark mb-1" name="user_id">
                            <option selected disabled>Tag</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ isset($_GET['user_id']) && $_GET['user_id'] == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <br><br>

                    <label class="check-container d-inline-block me-2 mb-2">Doboz
                        <input type="checkbox" class="form-check-input mb-1" id="box" name="box" {{ isset($_GET['box']) && $_GET['box'] == 'on' ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>

                    <label class="check-container d-inline-block me-2 mb-2">Papírok
                        <input type="checkbox" class="form-check-input mb-1" id="papers" name="papers" {{ isset($_GET['papers']) && $_GET['papers'] == 'on' ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>

                    <label class="check-container d-inline-block me-2 mb-2">Special edition
                        <input type="checkbox" class="form-check-input mb-1" id="special_edition" name="special_edition" {{ isset($_GET['special_edition']) && $_GET['special_edition'] == 'on' ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>

                    <label class="check-container d-inline-block me-2 mb-2">Bontatlan
                        <input type="checkbox" class="form-check-input mb-1" id="sealed" name="sealed" {{ isset($_GET['sealed']) && $_GET['sealed'] == 'on' ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>

                    <label class="check-container d-inline-block me-2 mb-2">Posta
                        <input type="checkbox" class="form-check-input mb-1" id="delivery" name="delivery" {{ isset($_GET['delivery']) && $_GET['delivery'] == 'on' ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>
                </div>

                <button type="submit" class="btn btn-red d-inline-block mt-2 me-2 px-4">Szűrés</button>
                <a href="/sales/consoles" class="d-inline-block mt-2" style="color: #eee;">Szűrők törlése</a>
            </div>
        </form>
    </div>

    <span>Összesen: {{ $consoles->total() }} eladó konzol</span>

    <br><br>

    @if($consoles->count() > 0)
    <section class="sales mainsection">
        <div class="row">
            @foreach($consoles as $console)
                <div class="col-6 col-md-6 col-lg-4 col-xl-3">
                    <a href="{{route('consoles.show', $console->id)}}" class="sale-card">
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
    <p class="text-center m-0 py-2">Jelenleg nincs aktív eladó konzol!</p>
    @endif

    @if($consoles->total() > 28)
    <div class="pagination text-center d-block mb-4">
        <a href="{{ $consoles->withQueryString()->previousPageUrl() }}" class="d-inline-block {{ $consoles->onFirstPage() ? 'disabled' : '' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_left
            </span>
        </a>
        @php
         $totalPages = ceil( $consoles->total() / $consoles->perPage() );
         if($totalPages == 0){
            $totalPages = 1;
         }
        @endphp
        <span>{{ $consoles->currentPage().'/'.$totalPages }}</span>
        <a href="{{ $consoles->withQueryString()->nextPageUrl() }}" class="d-inline-block {{ $consoles->hasMorePages() ? '' : 'disabled' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_right
            </span>
        </a>
    </div>
    @endif
@stop
