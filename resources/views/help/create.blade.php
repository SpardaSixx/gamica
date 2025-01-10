@extends('layouts.default')
@section('content')
<form action="{{route('help.index')}}" method="post" class="submit-form">
    @csrf
    
    <div class="form-group mb-3">
        <label for="title">Kérdés*</label>
        <textarea class="ckeditor form-control input-dark mb-3" id="question" name="question" rows="6" required></textarea>
    </div>

    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="anonymous" name="anonymous">
        <label class="form-check-label" for="anonymous">Névtelenül</label>
    </div>
    <br>

    <button type="submit" type="button" class="btn btn-brand my-2 submit-btn">Létrehozás</button>
</form>

<span class="fst-italic">A *-al jelölt mezők kitöltése kötelező!</span>
<br><br>
@stop