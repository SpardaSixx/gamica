@extends('layouts.default')
@section('content')
<form action="{{route('accessories.index')}}" method="post" enctype="multipart/form-data" class="submit-form">
    @csrf
    
    <div class="form-group mb-3">
        <label for="title">Cím*</label>
        <input type="text" class=" form-control input-dark" id="title" name="title" placeholder="Cím" required>
    </div>

    <div class="form-group mb-3">
        <label for="platform_id">Gyártó*</label>
        <select class="form-select input-dark" name="company_id" id="company_id" required>
            {{-- <option selected disabled>Gyártó</option> --}}
            @foreach($companies as $company)
            <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="serial_number">Sorszám</label>
        <input type="text" class=" form-control input-dark" id="serial_number" name="serial_number" placeholder="Sorszám">
        <small>A játék sorszáma, ami általában a tok gerincén és a lemezen található (pl. SCES-01489)</small>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="box" name="box">
        <label class="form-check-label" for="box">Doboz</label>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="papers" name="papers">
        <label class="form-check-label" for="papers">Papírok</label>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="sealed" name="sealed">
        <label class="form-check-label" for="sealed">Bontatlan</label>
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