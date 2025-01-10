@extends('layouts.default')
 
@section('content')
    <h2 class="page-title text-center mb-5">Gyűjtemény sorozatok</h2>

    <div class="filter-kit-desktop mb-3 position-relative">
        <form  action="/collections/series" method="get" class="filter-form">
            <div class="filters">
                <div class="form-group d-inline-block me-2">
                    <input type="text" class="form-control input-dark mb-1" name="title" placeholder="Név" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <select class="form-control input-dark mb-1" name="user_id">
                        <option selected disabled>Tag</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ isset($_GET['user_id']) && $_GET['user_id'] == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-red d-inline-block mt-2 me-2 px-4">Szűrés</button>
            <a href="/collections/series" class="d-inline-block mt-2" style="color: #eee;">Szűrők törlése</a>

            <div class="orderby position-absolute dropdown">
                <button class="btn btn-drk dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="material-symbols-outlined">
                        swap_vert
                    </span>
                </button>

                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" name="orderby" value="title_asc">Név szerint növekvő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="title_desc">Név szerint csökkenő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="views_asc">Nézettség szerint növekvő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="views_desc">Nézettség szerint csökkenő</button></li>
                </ul>
            </div>
        </form>
    </div>

    <div class="filter-kit-mobile mb-3">
        <form  action="/collections/series" method="get" class="filter-form">
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
                <li><button class="dropdown-item" name="orderby" value="views_asc">Nézettség szerint növekvő</button></li>
                <li><button class="dropdown-item" name="orderby" value="views_desc">Nézettség szerint csökkenő</button></li>
            </ul>

            
            <div class="collapse" id="collapseFilters">
                <div class="filters mt-3">
                    <div class="form-group d-inline-block me-2">
                        <input type="text" class="form-control input-dark mb-1" name="title" placeholder="Név" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                    </div>

                    <div class="form-group d-inline-block me-2 mb-2">
                        <select class="form-control input-dark mb-1" name="user_id">
                            <option selected disabled>Tag</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ isset($_GET['user_id']) && $_GET['user_id'] == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-red d-inline-block mt-2 me-2 px-4">Szűrés</button>
                <a href="/collections/series" class="d-inline-block mt-2" style="color: #eee;">Szűrők törlése</a>
            </div>
        </form>
    </div>

    <span>Összesen: {{ $series->total() }} sorozat</span>

    <br><br>

    <section class="collections mainsection">
    <div class="row">
        @foreach($series as $s)
        <div class="col-6 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('series.show', $s->id) }}" class="series-card">
                <div class="item-card mb-4">
                    <div class="card-image" style="background-image: url({{ $s->getPhoto() }})"></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $s->title }}</h5>
                        <p class="card-text">{{ count($s->getGames()).' db'  }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    </section>

    @if($series->total() > 28)
    <div class="pagination text-center d-block mb-4">
        <a href="{{ $series->withQueryString()->previousPageUrl() }}" class="d-inline-block {{ $series->onFirstPage() ? 'disabled' : '' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_left
            </span>
        </a>
        @php
         $totalPages = ceil( $series->total() / $series->perPage() );
         if($totalPages == 0){
            $totalPages = 1;
         }
        @endphp
        <span>{{ $series->currentPage().'/'.$totalPages }}</span>
        <a href="{{ $series->withQueryString()->nextPageUrl() }}" class="d-inline-block {{ $series->hasMorePages() ? '' : 'disabled' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_right
            </span>
        </a>
    </div>
    @endif
@stop
