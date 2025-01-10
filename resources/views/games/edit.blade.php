@extends('layouts.default')
@section('content')
<form action="/collections/games/{{$game->id}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="title">Cím</label>
        <input type="text" class=" form-control input-dark" id="title" name="title" value="{{ $game->title }}" required>
    </div>

    <div class="form-group mb-3">
        <label for="release_year">Kiadás éve</label>
        <input type="text" class=" form-control input-dark" id="release_year" name="release_year" value="{{ $game->release_year }}">
    </div>

    <div class="form-group mb-3">
        <label for="platform_id">Konzol</label>
        <select class=" form-select input-dark" name="platform_id" id="platform_id" required>
            @foreach($platforms as $platform)
            <option value="{{ $platform->id }}" {{ $game->getPlatform->id == $platform->id ? 'selected' : '' }}>{{ $platform->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="serial_number">Sorszám</label>
        <input type="text" class="form-control input-dark" id="serial_number" name="serial_number" value="{{ $game->serial_number ? $game->serial_number : '' }}">
        <small>A játék sorszáma, ami általában a tok gerincén és a lemezen található (pl. SCES-01489)</small>
    </div>

    <div class="form-group mb-3">
        <label for="region_id">Régió</label>
        <select class=" form-select input-dark" name="region_id" id="region_id" required>
            @foreach($regions as $region)
            <option value="{{ $region->id }}" {{ $game->getRegion->id == $region->id ? 'selected' : '' }}>{{ $region->title }}</option>
            @endforeach
        </select>
        <small>PAL - Európa, Ázsia, Afrika, Dél-Amerika<br>NTSC-U - Észak-Amerika<br>NTSC-J - Japán</small>
    </div>

    <div class="form-group mb-3">
        <label for="release_id">Kiadás</label>
        <select class=" form-select input-dark" name="release_id" id="release_id" required>
            @foreach($releases as $release)
            <option value="{{ $release->id }}" {{ $game->getRelease->id == $release->id ? 'selected' : '' }}>{{ $release->title }}</option>
            @endforeach
        </select>
        <small>Egyéb: Az eredeti (pl. Black Label) kiadáshoz képest későbbi újrakiadás (pl.: Platinum, Essentials, Hits, stb.)</small>
    </div>

    <div class="form-group mb-3">
        <label for="cover_language_id">Borító nyelve*</label>
        <select class="form-select input-dark" name="cover_language_id" id="cover_language_id" required>
            {{-- <option selected disabled>Nyelv</option> --}}
            @foreach($languages as $language)
            <option value="{{ $language->id }}" {{ $game->getCoverLanguage->id == $language->id ? 'selected' : '' }}>{{ $language->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="game_language_id">Játék nyelve*</label>
        <select class="form-select input-dark" name="game_language_id" id="game_language_id" required>
            {{-- <option selected disabled>Nyelv</option> --}}
            @foreach($languages as $language)
            <option value="{{ $language->id }}" {{ $game->getGameLanguage->id == $language->id ? 'selected' : '' }}>{{ $language->title }}</option>
            @endforeach
        </select>
    </div>

    
    <div class="form-group mb-3">
        <label for="series_id">Sorozat</label>
        <select class=" form-select input-dark" name="series_id" id="series_id">
            {{-- <option selected disabled>Sorozat</option> --}}
            @foreach($series as $s)
            @if($game->series_id)
            <option value="{{ $s->id }}" {{ $game->getSeries->id == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
            @else
            <option value="{{ $s->id }}">{{ $s->title }}</option>
            @endif
            @endforeach
        </select>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="manual" name="manual" {{ $game->manual ? 'checked' : '' }}>
        <label class="form-check-label" for="manual">Manual</label>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="special_edition" name="special_edition" {{ $game->special_edition ? 'checked' : '' }}>
        <label class="form-check-label" for="special_edition">Special edition</label>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="sealed" name="sealed" {{ $game->sealed ? 'checked' : '' }}>
        <label class="form-check-label" for="sealed">Bontatlan</label>
    </div>

    @if( $game->has_photo )
        <img src="{{ $game->getPhoto() }}" class="d-block my-2" style="max-width: 25%;">
        <a href="{{ route('game-delete-photo', $game->id) }}" class="btn btn-danger" onclick="confirmDelete()">Fotó törlése</a>
    @else
        <div class="form-group">
            <label for="image" class="form-label">Fotó</label>
            <input class=" form-control input-dark" type="file" id="image" name="image">
        </div>
    @endif
    <br>

    <button type="submit" type="button" class="btn btn-red my-2">Frissítés</button>
</form>
@stop
