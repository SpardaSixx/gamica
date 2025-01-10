@extends('layouts.default')

@section('content')
    <h2 class="text-center">OnlinePénztárca születésnapok</h2>

    <table class="w-100">
        <tr style="border-bottom: 1px solid #eee;">
            <td>Név</td>
            <td>Születésnap</td>
            <td>Hónap</td>
            <td>Kor</td>
        </tr>

        @foreach($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->birthday}}</td>
            <td>{{$user->month}}</td>
            @php
                $birthDate = $user->birthday;
                $today = date("Y-m-d");
                $diff = date_diff(date_create($birthDate), date_create($today));
                $age = $diff->format('%y');
            @endphp
            <td>{{$age}}</td>
        </tr>
        @endforeach
    </table>

    <br>
@stop

