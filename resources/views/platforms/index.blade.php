@extends('layouts.default')
 
@section('content')
    @if(Auth::user() && Auth::user()->rank_id == 3)
    <a href="{{ route('platforms.create') }}" class="btn btn-brand">Létrehozás</a>
    <br><br>
    @endif

    {{-- <div class="filter-kit mb-3">
        <a class="btn btn-brand d-inline-block mt-2 me-2 px-2" style="line-height: 1;" data-bs-toggle="collapse" href="#collapseFilters" role="button" aria-expanded="false" aria-controls="collapseFilters">
            <span class="material-symbols-outlined">
            tune
            </span>
            <span style="position: relative; bottom: 6px;">Szűrők</span>
        </a>

        <a class="btn btn-brand d-inline-block mt-2 px-2" style="line-height: 1;" data-bs-toggle="collapse" href="#collapseSort" role="button" aria-expanded="false" aria-controls="collapseSort">
            <span class="material-symbols-outlined">
            filter_list
            </span>
            <span style="position: relative; bottom: 6px;">Rendezés</span>
        </a>

        <form  action="{{ route('platforms.index') }}" method="get">
            <div class="collapse {{ isset($_GET['title']) || isset($_GET['company_id'])  ? 'show' : '' }}" id="collapseFilters">
                <div class="filters mt-3">
                    <div class="form-group d-inline-block me-2">
                        <input type="text" class="form-control input-dark mb-1" name="title" placeholder="Név" value="{{ isset($_GET['title']) ? $_GET['title'] : '' }}">
                    </div>
                </div>
            </div>

            <div class="collapse {{ isset($_GET['order']) || isset($_GET['orderby']) ? 'show' : '' }}" id="collapseSort">
                <div class="filters mt-3">
                    <div class="form-group d-inline-block me-2">
                        <select class="form-control input-dark mb-1" name="orderby">
                            <option selected disabled>Rendezés</option>
                            <option value="title" {{ isset($_GET['orderby']) && $_GET['orderby'] == 'title' ? 'selected' : '' }}>Név szerint</option>
                            <option value="company_id" {{ isset($_GET['orderby']) && $_GET['orderby'] == 'company_id' ? 'selected' : '' }}>Cég szerint</option>
                        </select>
                    </div>

                    <div class="form-group d-inline-block me-2">
                        <select class="form-control input-dark mb-1" name="order">
                            <option selected disabled>Sorrend</option>
                            <option value="asc" {{ isset($_GET['order']) && $_GET['order'] == 'asc' ? 'selected' : '' }}>Növekvő</option>
                            <option value="desc" {{ isset($_GET['order']) && $_GET['order'] == 'desc' ? 'selected' : '' }}>Csökkenő</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-brand d-inline-block mt-2 me-2 px-4">Szűrés</button>
            <a href="{{ route('platforms.index') }}" class="btn btn-danger d-inline-block mt-2">Szűrők törlése</a>
        </form>
    </div> --}}

    <span>Összesen: {{ $platforms->count() }} db konzol</span>

    <div class="row">
        @foreach($platforms as $platform)
        <div class="col-6 col-md-6 col-lg-4 col-xl-3">
            <a href="{{ route('platforms.show', $platform->id) }}" class="sale-card">
                <div class="item-card mb-4 {{ strtolower($platform->getCompany->name) }}">
                    <div class="card-image" style="background-image: url({{ $platform->getPhoto() }});"></div>
                    <div class="card-body {{ strtolower($platform->getCompany->name) }}">
                        <h5 class="card-title">{{ $platform->title }}</h5>
                        <p class="card-text platform {{ strtolower($platform->getCompany->name) }}">{{ $platform->getCompany->name }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- @if($platforms->total() > 30)
    <div class="pagination text-center d-block mb-4">
        <a href="{{ $platforms->withQueryString()->previousPageUrl() }}" class="d-inline-block {{ $platforms->onFirstPage() ? 'disabled' : '' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_left
            </span>
        </a>
        @php
         $totalPages = ceil( $platforms->total() / $platforms->perPage() );
         if($totalPages == 0){
            $totalPages = 1;
         }
        @endphp
        <span>{{ $platforms->currentPage().'/'.$totalPages }}</span>
        <a href="{{ $platforms->withQueryString()->nextPageUrl() }}" class="d-inline-block {{ $platforms->hasMorePages() ? '' : 'disabled' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_right
            </span>
        </a>
    </div>
    @endif --}}
@stop
