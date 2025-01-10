@extends('layouts.default')
 
@section('content')
    <div class="filter-kit-desktop mb-3 position-relative">
        <form  action="/users" method="get" class="filter-form">
            <div class="filters">
                <div class="form-group d-inline-block me-2 mb-2">
                    <input type="text" class="form-control input-dark mb-1" name="name" placeholder="Felhasználónév" value="{{ isset($_GET['username']) ? $_GET['username'] : '' }}">
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <select class="form-control input-dark mb-1" name="city_id">
                        <option selected disabled>Város</option>
                        @foreach($cities as $city)
                        @if($city->id != 3154)
                        <option value="{{ $city->id }}" {{ isset($_GET['city_id']) && $_GET['city_id'] == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <select class="form-control input-dark mb-1" name="rank_id">
                        <option selected disabled>Rank</option>
                        @foreach($ranks as $rank)
                        @if($rank->id != 3 && $rank->id != 20)
                        <option value="{{ $rank->id }}" {{ isset($_GET['rank_id']) && $_GET['rank_id'] == $rank->id ? 'selected' : '' }}>{{ $rank->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-red d-inline-block mt-2 me-2 px-4">Szűrés</button>
            <a href="/users" class="d-inline-block mt-2" style="color: #eee;">Szűrők törlése</a>

            <div class="orderby position-absolute dropdown">
                <button class="btn btn-drk dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="material-symbols-outlined">
                        swap_vert
                    </span>
                </button>

                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" name="orderby" value="username_asc">Név szerint növekvő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="username_desc">Név szerint csökkenő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="xp_asc">XP szerint növekvő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="xp_desc">XP szerint csökkenő</button></li>
                </ul>
            </div>
        </form>
    </div>

    <div class="filter-kit-mobile mb-3">
        <form  action="/users" method="get" class="filter-form">
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
                <li><button class="dropdown-item" name="orderby" value="username_asc">Név szerint növekvő</button></li>
                <li><button class="dropdown-item" name="orderby" value="username_desc">Név szerint csökkenő</button></li>
                <li><button class="dropdown-item" name="orderby" value="xp_asc">XP szerint növekvő</button></li>
                <li><button class="dropdown-item" name="orderby" value="xp_desc">XP szerint csökkenő</button></li>
            </ul>

            <div class="collapse" id="collapseFilters">
                <div class="filters mt-3">
                    <div class="form-group d-inline-block me-2 mb-2">
                        <input type="text" class="form-control input-dark mb-1" name="name" placeholder="Felhasználónév" value="{{ isset($_GET['name']) ? $_GET['name'] : '' }}">
                    </div>

                    <div class="form-group d-inline-block me-2 mb-2">
                        <select class="form-control input-dark mb-1" name="city_id">
                            <option selected disabled>Város</option>
                            @foreach($cities as $city)
                            @if($city->id != 3154)
                            <option value="{{ $city->id }}" {{ isset($_GET['city_id']) && $_GET['city_id'] == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-inline-block me-2 mb-2">
                        <select class="form-control input-dark mb-1" name="rank_id">
                            <option selected disabled>Rank</option>
                            @foreach($ranks as $rank)
                            @if($rank->id != 3 && $rank->id != 20)
                            <option value="{{ $rank->id }}" {{ isset($_GET['rank_id']) && $_GET['rank_id'] == $rank->id ? 'selected' : '' }}>{{ $rank->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-red d-inline-block mt-2 me-2 px-4">Szűrés</button>
                <a href="/users" class="d-inline-block mt-2" style="color: #eee;">Szűrők törlése</a>
            </div>
        </form>
    </div>

    <span>Összesen: {{ $users->total() }} tag</span>

    <br><br>

    <div class="row">
        @foreach($users as $user)
        <div class="col-6 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('users.show', $user->id) }}" class="user-card">
                <div class="item-card mb-4">
                    <div class="card-image" style="background-image: url({{ $user->getPhoto() }});"></div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->username }}</h5>
                        @if($user->getCity)
                        <p class="card-text d-inline-block">{{ $user->getCity->name }}</p>
                        @endif

                        <p class="card-text d-inline-block">
                            <i class="fas fa-circle"></i>
                            {{ $user->xp_points }} XP
                        </p>

                        <p class="card-text d-inline-block rank {{\Str::slug($user->getRank->name)}}">
                            
                            {{ $user->getRank->name }}
                        </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    @if($users->total() > 20)
    <div class="pagination text-center d-block mb-4">
        <a href="{{ $users->withQueryString()->previousPageUrl() }}" class="d-inline-block {{ $users->onFirstPage() ? 'disabled' : '' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_left
            </span>
        </a>
        @php
         $totalPages = ceil( $users->total() / $users->perPage() );
         if($totalPages == 0){
            $totalPages = 1;
         }
        @endphp
        <span>{{ $users->currentPage().'/'.$totalPages }}</span>
        <a href="{{ $users->withQueryString()->nextPageUrl() }}" class="d-inline-block {{ $users->hasMorePages() ? '' : 'disabled' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_right
            </span>
        </a>
    </div>
    @endif
@stop
