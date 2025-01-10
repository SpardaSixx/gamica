@extends('layouts.default')
@section('content')
<form action="{{ route('platforms.update', $platform->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="title">Cím</label>
        <input type="text" class=" form-control input-dark" id="title" name="title" value="{{ $platform->title }}">
    </div>

    <div class="form-group mb-3">
        <label for="title_short">Rövid név</label>
        <input type="text" class=" form-control input-dark" id="title_short" name="title_short" value="{{ $platform->title_short }}">
    </div>

    <div class="form-group mb-3">
        <label for="release_year">Megjelenés éve</label>
        <input type="number" class=" form-control input-dark" id="release_year" name="release_year" value="{{ $platform->release_year }}">
    </div>

    <div class="form-group mb-3">
        <label for="company_id">Cég</label>
        <select class="form-select input-dark" name="company_id" id="company_id">
            @foreach($companies as $company)
            <option value="{{ $company->id }}" {{ $platform->getCompany->id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="description">Leírás</label>
        <textarea class="ckeditor  form-control input-dark" name="description" id="description">
            {{ $platform->description }}
        </textarea>
    </div>

    @if( $platform->has_photo )
        <img src="{{ $platform->getPhoto() }}" class="d-block my-2" style="max-width: 25%;">
        <a href="{{ route('platform-delete-photo', $platform->id) }}" class="btn btn-danger" onclick="confirmDelete()">Fotó törlése</a>
    @else
        <div class="form-group mb-3">
            <label for="image" class="form-label">Fotó</label>
            <input class=" form-control input-dark" type="file" id="image" name="image">
        </div>
    @endif
    <br>

    <button type="submit" type="button" class="btn btn-red my-2">Frissítés</button>
</form>
@stop

