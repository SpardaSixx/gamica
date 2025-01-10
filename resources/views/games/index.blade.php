@extends('layouts.default')
 
@section('content')
    <h2 class="page-title text-center mb-5">Gyűjtemény játékok</h2>

    <div class="filter-kit-desktop mb-3 position-relative">
        <form  action="/collections/games" method="get" class="filter-form">
            <div class="filters">
                <div class="form-group d-inline-block me-2 mb-2">
                    <input type="text" class="form-control input-dark mb-1" name="title" placeholder="Cím" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <select class="form-control input-dark mb-1" name="platform_id">
                        <option selected disabled>Konzol</option>
                        @foreach($platforms as $platform)
                        <option value="{{ $platform->id }}" {{ isset($_GET['platform_id']) && $_GET['platform_id'] == $platform->id ? 'selected' : '' }}>{{ $platform->title_short }}</option>
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
                    <select class="form-control input-dark mb-1" name="release_id">
                        <option selected disabled>Kiadás</option>
                        @foreach($releases as $release)
                        <option value="{{ $release->id }}" {{ isset($_GET['release_id']) && $_GET['release_id'] == $release->id ? 'selected' : '' }}>{{ $release->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <select class="form-control input-dark mb-1" name="cover_language_id">
                        <option selected disabled>Borító nyelve</option>
                        @foreach($languages as $language)
                        <option value="{{ $language->id }}" {{ isset($_GET['cover_language_id']) && $_GET['cover_language_id'] == $language->id ? 'selected' : '' }}>{{ $language->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-inline-block me-2 mb-2">
                    <select class="form-control input-dark mb-1" name="game_language_id">
                        <option selected disabled>Játék nyelve</option>
                        @foreach($languages as $language)
                        <option value="{{ $language->id }}" {{ isset($_GET['game_language_id']) && $_GET['game_language_id'] == $language->id ? 'selected' : '' }}>{{ $language->title }}</option>
                        @endforeach
                    </select>
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

                <label class="check-container d-inline-block me-2">Manual
                    <input type="checkbox" class="form-check-input mb-1" id="manual" name="manual" {{ isset($_GET['manual']) && $_GET['manual'] == 'on' ? 'checked' : '' }}>
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
            </div>

            <button type="submit" class="btn btn-red d-inline-block mt-2 me-2 px-4">Szűrés</button>
            <a href="/collections/games" class="d-inline-block mt-2" style="color: #eee;">Szűrők törlése</a>

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
                    <li><button class="dropdown-item" name="orderby" value="likes_asc">Lájkok szerint növekvő</button></li>
                    <li><button class="dropdown-item" name="orderby" value="likes_desc">Lájkok szerint csökkenő</button></li>
                </ul>
            </div>
        </form>
    </div>

    <div class="filter-kit-mobile mb-3">
        <form  action="/collections/games" method="get" class="filter-form">
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
                <li><button class="dropdown-item" name="orderby" value="likes_asc">Lájkok szerint növekvő</button></li>
                <li><button class="dropdown-item" name="orderby" value="likes_desc">Lájkok szerint csökkenő</button></li>
            </ul>

            
            <div class="collapse" id="collapseFilters">
                <div class="filters mt-3">
                    <div class="form-group d-inline-block me-2">
                        <input type="text" class="form-control input-dark mb-1" name="title" placeholder="Cím" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                    </div>

                    <div class="form-group d-inline-block me-2">
                        <select class="form-control input-dark mb-1" name="platform_id">
                            <option selected disabled>Konzol</option>
                            @foreach($platforms as $platform)
                            <option value="{{ $platform->id }}" {{ isset($_GET['platform_id']) && $_GET['platform_id'] == $platform->id ? 'selected' : '' }}>{{ $platform->title_short }}</option>
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
                        <select class="form-control input-dark mb-1" name="release_id">
                            <option selected disabled>Kiadás</option>
                            @foreach($releases as $release)
                            <option value="{{ $release->id }}" {{ isset($_GET['release_id']) && $_GET['release_id'] == $release->id ? 'selected' : '' }}>{{ $release->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-inline-block me-2">
                        <select class="form-control input-dark mb-1" name="cover_language_id">
                            <option selected disabled>Borító nyelve</option>
                            @foreach($languages as $language)
                            <option value="{{ $language->id }}" {{ isset($_GET['cover_language_id']) && $_GET['cover_language_id'] == $language->id ? 'selected' : '' }}>{{ $language->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-inline-block me-2">
                        <select class="form-control input-dark mb-1" name="game_language_id">
                            <option selected disabled>Játék nyelve</option>
                            @foreach($languages as $language)
                            <option value="{{ $language->id }}" {{ isset($_GET['game_language_id']) && $_GET['game_language_id'] == $language->id ? 'selected' : '' }}>{{ $language->title }}</option>
                            @endforeach
                        </select>
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

                    <label class="check-container d-inline-block me-2 mb-2">Manual
                        <input type="checkbox" class="form-check-input mb-1" id="manual" name="manual" {{ isset($_GET['manual']) && $_GET['manual'] == 'on' ? 'checked' : '' }}>
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
                </div>

                <button type="submit" class="btn btn-red d-inline-block mt-2 me-2 px-4">Szűrés</button>
                <a href="/collections/games" class="d-inline-block mt-2" style="color: #eee;">Szűrők törlése</a>
            </div>
        </form>
    </div>

    <span>Összesen: {{ $games->total() }} játék</span>

    <br><br>

    @if($games->count() > 0)
    <section class="games mainsection">
        <div class="row">
            @foreach($games as $game)
            <div class="col-6 col-md-6 col-lg-4 col-xl-3">
                <a href="/collections/games/{{$game->id}}" class="game-card">
                    <div class="item-card mb-4 {{ strtolower($game->getPlatform->getCompany->name) }}">
                        <div class="card-image" style="background-image: url({{ $game->getPhoto() }});"></div>
                        <div class="card-body {{ strtolower($game->getPlatform->getCompany->name) }}">
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

    @if($games->total() > 28)
    <div class="pagination text-center d-block mb-4">
        <a href="{{ $games->withQueryString()->previousPageUrl() }}" class="d-inline-block {{ $games->onFirstPage() ? 'disabled' : '' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_left
            </span>
        </a>
        @php
         $totalPages = ceil( $games->total() / $games->perPage() );
         if($totalPages == 0){
            $totalPages = 1;
         }
        @endphp
        <span>{{ $games->currentPage().'/'.$totalPages }}</span>
        <a href="{{ $games->withQueryString()->nextPageUrl() }}" class="d-inline-block {{ $games->hasMorePages() ? '' : 'disabled' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_right
            </span>
        </a>
    </div>
    @endif
@stop
