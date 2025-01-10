@extends('layouts.default')
@section('content')
<form action="{{ route('series.store') }}" method="post" enctype="multipart/form-data" class="submit-form">
    @csrf
    
    <div class="form-group mb-3">
        <label for="title">Név*</label>
        <input type="text" class="form-control input-dark" id="title" name="title" placeholder="Név" required>
    </div>

    <div class="form-group mb-3">
        <label for="image" class="form-label">Fotó</label>
        <input class="form-control input-dark" type="file" id="image" name="image">
    </div>

    <button type="submit" type="button" class="btn btn-red my-2 submit-btn">Létrehozás</button>
</form>

<span class="fst-italic">A *-al jelölt mezők kitöltése kötelező!</span>
<br><br>

@stop
