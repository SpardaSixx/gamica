@extends('layouts.default')
@section('content')
<form action="{{ route('wanteds.store') }}" method="post" enctype="multipart/form-data" class="submit-form">
    @csrf
    
    <div class="form-group mb-3">
        <label for="title">Cím*</label>
        <input type="text" class=" form-control input-dark" id="title" name="title" placeholder="Cím" required>
    </div>

    <div class="form-group mb-3">
        <label for="release_year">Kiadás éve</label>
        <input type="text" class=" form-control input-dark" id="release_year" name="release_year" placeholder="Kiadás éve">
    </div>

    <div class="form-group mb-3">
        <label for="platform_id">Konzol*</label>
        <select class="form-select input-dark" name="platform_id" id="platform_id" required>
            {{-- <option selected disabled>Konzol</option> --}}
            @foreach($platforms as $platform)
            <option value="{{ $platform->id }}">{{ $platform->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="serial_number">Sorszám</label>
        <input type="text" class=" form-control input-dark" id="serial_number" name="serial_number" placeholder="Sorszám">
        <small>A játék sorszáma, ami általában a tok gerincén és a lemezen található (pl. SCES-01489)</small>
    </div>

    <div class="form-group mb-3">
        <label for="region_id">Régió*</label>
        <select class="form-select input-dark" name="region_id" id="region_id" required>
            {{-- <option selected disabled>Régió</option> --}}
            @foreach($regions as $region)
            <option value="{{ $region->id }}">{{ $region->title }}</option>
            @endforeach
        </select>
        <small>PAL - Európa, Ázsia, Afrika, Dél-Amerika<br>NTSC-U - Észak-Amerika<br>NTSC-J - Japán</small>
    </div>

    <div class="form-group mb-3">
        <label for="release_id">Kiadás*</label>
        <select class="form-select input-dark" name="release_id" id="release_id" required>
            {{-- <option selected disabled>Kiadás</option> --}}
            @foreach($releases as $release)
            <option value="{{ $release->id }}">{{ $release->title }}</option>
            @endforeach
        </select>
        <small>Egyéb: Az eredeti (pl. Black Label) kiadáshoz képest későbbi újrakiadás (pl.: Platinum, Essentials, Hits, stb.)</small>
    </div>

    <div class="form-group mb-3">
        <label for="cover_language_id">Borító nyelve*</label>
        <select class="form-select input-dark" name="cover_language_id" id="cover_language_id" required>
            {{-- <option selected disabled>Nyelv</option> --}}
            @foreach($languages as $language)
            <option value="{{ $language->id }}">{{ $language->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="game_language_id">Játék nyelve*</label>
        <select class="form-select input-dark" name="game_language_id" id="game_language_id" required>
            {{-- <option selected disabled>Nyelv</option> --}}
            @foreach($languages as $language)
            <option value="{{ $language->id }}">{{ $language->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="manual" name="manual">
        <label class="form-check-label" for="manual">Manual</label>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="special_edition" name="special_edition">
        <label class="form-check-label" for="special_edition">Special edition</label>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="sealed" name="sealed">
        <label class="form-check-label" for="sealed">Bontatlan</label>
    </div>

    <div class="form-group mb-3">
        <label for="preferred_area">Preferált terület</label>
        <select class="form-select input-dark" name="preferred_area" id="preferred_area">
            <option selected disabled>Preferált terület</option>
            <option value="Országos">Országos</option>
            @foreach($counties as $county)
            <option value="{{ $county->name }}">{{ $county->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="image" class="form-label">Fotó</label>
        <input class=" form-control input-dark" type="file" id="image" name="image">
    </div>
    <br>

    <div class="form-group">
        <label for="images" class="form-label">Galéria (Több kép)</label>
        <input class=" form-control input-dark" type="file" id="images" name="images[]" multiple>
    </div>
    <br>

    <div class="form-group mb-3">
        <label for="price">Ár*</label>
        <input type="number" class=" form-control input-dark" id="price" name="price" placeholder="Ár" required>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="delivery" name="delivery">
        <label class="form-check-label" for="delivery">Szállítás</label>
    </div>
    <br>

    <button type="submit" type="button" class="btn btn-red my-2 submit-btn">Létrehozás</button>
</form>

<span class="fst-italic">A *-al jelölt mezők kitöltése kötelező!</span>
<br><br>
@stop