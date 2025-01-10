@extends('layouts.default')
@section('content')
    <h2 class="entity-title text-center">Kiemelt hirdetések</h2>

    <div class="row">
        <div class="col-12 col-lg-3">
            <h2 class="entity-title">Játékok</h2>

            <div class="highlight-edit">
                <div class="current p-2 mb-2">
                    @foreach($highlightsSales as $sale)
                        <a href="/sales/{{$sale->item_type}}/{{$sale->item_id}}" class="badge bg-warning text-dark">
                            {{$sale->getItem($sale->item_id)->title}}
                        </a>
                        
                        <form action="/admin/{{$sale->id}}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="delete" type="submit" onclick="confirmDelete()">
                                X
                            </button>
                        </form>
                    @endforeach
                </div>

                <div class="form">
                    <form action="{{route('admin.store')}}" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <select class="form-select input-dark" name="added_sales[]" style="height: 15rem;" multiple>
                                @foreach($sales as $sale)
                                <option value="{{ $sale->id }}">{{ $sale->title }} ({{ $sale->id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" type="button" class="btn btn-brand">Frissítés</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3">
            <h2 class="entity-title">Konzolok</h2>
            
            <div class="highlight-edit">
                <div class="current p-2 mb-2">
                    @foreach($highlightsConsoles as $console)
                        <a href="/sales/{{$console->item_type}}/{{$console->item_id}}" class="badge bg-warning text-dark">
                            {{$console->getItem($console->item_id)->title}}
                        </a>
                        
                        <form action="/admin/{{$sale->id}}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="delete" type="submit" onclick="confirmDelete()">
                                X
                            </button>
                        </form>
                    @endforeach
                </div>

                <div class="form">
                    <form action="{{route('admin.store')}}" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <select class="form-select input-dark" name="added_consoles[]" style="height: 15rem;" multiple>
                                @foreach($consoles as $console)
                                <option value="{{ $console->id }}">{{ $console->title }} ({{ $console->id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" type="button" class="btn btn-brand">Frissítés</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3">
            <h2 class="entity-title">Kiegészítők</h2>
            
            <div class="highlight-edit">
                <div class="current p-2 mb-2">
                    @foreach($highlightsAccessories as $accessory)
                        <a href="/sales/{{$accessory->item_type}}/{{$accessory->item_id}}" class="badge bg-warning text-dark">
                            {{$accessory->getItem($accessory->item_id)->title}}
                        </a>
                        
                        <form action="/admin/{{$sale->id}}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="delete" type="submit" onclick="confirmDelete()">
                                X
                            </button>
                        </form>
                    @endforeach
                </div>

                <div class="form">
                    <form action="{{route('admin.store')}}" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <select class="form-select input-dark" name="added_accessories[]" style="height: 15rem;" multiple>
                                @foreach($accessories as $accessory)
                                <option value="{{ $accessory->id }}">{{ $accessory->title }} ({{ $accessory->id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" type="button" class="btn btn-brand">Frissítés</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-3">
            <h2 class="entity-title">Csomagok</h2>
            
            <div class="highlight-edit">
                <div class="current p-2 mb-2">
                    @foreach($highlightsPacks as $pack)
                        <a href="/sales/{{$pack->item_type}}/{{$pack->item_id}}" class="badge bg-warning text-dark">
                            {{$pack->getItem($pack->item_id)->title}}
                        </a>
                        
                        <form action="/admin/{{$pack->id}}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="delete" type="submit" onclick="confirmDelete()">
                                X
                            </button>
                        </form>
                    @endforeach
                </div>

                <div class="form">
                    <form action="{{route('admin.store')}}" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <select class="form-select input-dark" name="added_packs[]" style="height: 15rem;" multiple>
                                @foreach($packs as $pack)
                                <option value="{{ $pack->id }}">{{ $pack->title }} ({{ $pack->id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" type="button" class="btn btn-brand">Frissítés</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>
@stop
