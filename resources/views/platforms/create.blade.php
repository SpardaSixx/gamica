@extends('layouts.default')
@section('content')
<form action="{{ route('platforms.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group mb-3">
        <label for="title">Név</label>
        <input type="text" class=" form-control input-dark" id="title" name="title" placeholder="Név">
    </div>

    <div class="form-group mb-3">
        <label for="title_short">Rövid név</label>
        <input type="text" class=" form-control input-dark" id="title_short" name="title_short" placeholder="Rövid név">
    </div>

    <div class="form-group mb-3">
        <label for="release_year">Megjelenés éve</label>
        <input type="number" class=" form-control input-dark" id="release_year" name="release_year" placeholder="Megjelenés éve">
    </div>

    <div class="form-group mb-3">
        <label for="company_id">Cég</label>
        <select class="form-select input-dark" name="company_id" id="company_id">
            @foreach($companies as $company)
            <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="description">Leírás</label>
        <textarea class="ckeditor form-control input-dark" name="description" id="description">Leírás</textarea>
    </div>

    <div class="form-group mb-3">
        <label for="image" class="form-label">Fotó</label>
        <input class=" form-control input-dark" type="file" id="image" name="image">
    </div>

    <button type="submit" type="button" class="btn btn-red my-2">Létrehozás</button>
</form>
@stop

