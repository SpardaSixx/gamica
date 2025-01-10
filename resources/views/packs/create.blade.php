@extends('layouts.default')
@section('content')
<form action="{{route('packs.index')}}" method="post" enctype="multipart/form-data" class="submit-form">
    @csrf
    
    <div class="form-group mb-3">
        <label for="title">Cím*</label>
        <input type="text" class=" form-control input-dark" id="title" name="title" placeholder="Cím" required>
    </div>

    <div class="form-group mb-3">
        <label for="description">Leírás*</label>
        <textarea class="form-control input-dark mb-3" id="description" name="description" rows="6" required></textarea>
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