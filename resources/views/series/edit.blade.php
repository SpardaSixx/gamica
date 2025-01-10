@extends('layouts.default')
@section('content')
<form action="{{ route('series.update', $series->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="title">Név*</label>
        <input type="text" class="form-control input-dark" id="title" name="title" value="{{ $series->title }}" required>
    </div>

    @if( $series->has_photo )
        <img src="{{ $series->getPhoto() }}" class="d-block my-2" style="max-width: 25%;">
        <a href="{{ route('series-delete-photo', $series->id) }}" class="btn btn-danger" onclick="confirmDelete()">Fotó törlése</a>
    @else
        <div class="form-group mb-3">
            <label for="image" class="form-label">Fotó</label>
            <input class="form-control input-dark" type="file" id="image" name="image">
        </div>
    @endif
    <br><br>

    <div class="form-group mb-3">
        <label for="title">Játék hozzáadása a gyűjteményhez</label>
        <select class="form-select input-dark" name="added_games[]" style="height: 15rem;" multiple>
            @foreach($games as $game)
            <option value="{{ $game->id }}">{{ $game->title }} ({{ $game->getPlatform->title_short }})</option>
            @endforeach
        </select>
    </div>

    <button type="submit" type="button" class="btn btn-red my-2">Frissítés</button>
</form>
@stop
