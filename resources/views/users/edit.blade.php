@extends('layouts.default')
@section('content')
<form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label for="username">Felhasználónév</label>
        <input type="text" class="form-control input-dark" id="username" name="username" value="{{ $user->username }}">
    </div>

    <div class="form-group mb-3">
      <label for="email">E-mail cím</label>
      <input type="email" class="form-control input-dark" id="email" name="email" value="{{ $user->email }}">
    </div>

    <div class="form-group mb-3">
        <label for="password">Jelszó</label><br>
        <small>Csak akkor töltsd ki, ha meg akarod változtatni!</small>
        <input type="password" class="form-control input-dark" id="password" name="password" placeholder="Új jelszó">
    </div>

    <div class="form-group mb-3">
        <label for="repassword">Jelszó újra</label><br>
        <small>Csak akkor töltsd ki, ha meg akarod változtatni!</small>
        <input type="password" class="form-control input-dark" id="repassword" name="repassword" placeholder="Új jelszó újra">
    </div>

    <div class="form-group mb-3">
        <label for="fb_profile">Facebook profil</label>
        <input type="text" class="form-control input-dark" id="fb_profile" name="fb_profile" value="{{ $user->fb_profile }}">
    </div>

    <div class="form-group mb-3">
        <label for="ig_profile">Instagram profil</label>
        <input type="text" class="form-control input-dark" id="ig_profile" name="ig_profile" value="{{ $user->ig_profile }}">
    </div>

    <div class="form-group mb-3">
        <label for="city">Város</label>
        <select class="form-control input-dark" id="city_id" name="city_id">
            @foreach( $cities as $city )
            <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
            @endforeach
        </select>
    </div>

    @if( $user->has_photo )
        <img src="{{ $user->getPhoto() }}" class="d-block my-2" style="max-width: 25%;">
        <a href="{{ route('user-delete-photo', $user->id) }}" class="btn btn-danger" onclick="confirmDelete()">Fotó törlése</a>
    @else
        <div class="form-group mb-3">
            <label for="image" class="form-label">Profilkép</label>
            <input class="form-control input-dark" type="file" id="image" name="image">
        </div>
    @endif

    <hr>

    <button type="submit" type="button" class="btn btn-red my-2">Frissítés</button>
</form>

<form action="{{ route('users.destroy', Auth::id()) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger mb-1" href="{{ route('users.destroy', Auth::id()) }}" onclick="confirmDelete()">Profilom törlése</button>
    <br><br>
</form>
@stop
