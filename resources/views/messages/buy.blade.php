@extends('layouts.default')

@section('content')

    <h2 class="entity-title text-center">Üzenet vételi szándékról</h2>

    <div class="row">
        <div class="col-12">
            <h2 class="entity-title d-inline-block">{{ $item->title }}</h2>
            <br>
            <h2 class="entity-title d-inline-block">{{ $item->getPrice() }} Ft</h2>
        </div>

        @if($item->is_sold == 1)
        <div class="col-12 text-center">
            <h1 class="badge bg-danger text-light my-3 mx-auto" style="width: fit-content; dispaly: table; font-size: 1.5rem;">ELADVA</h1><br>
        </div>
        @endif

        <div class="col-12 col-md-4 col-lg-3">
            @if($item->has_photo == 1)
            <a data-fancybox="gallery" href="{{ $item->getPhoto() }}">
                <img src="{{ $item->getPhoto() }}" class="mb-3" style="max-width: 100%;">
            </a>
            @endif
        </div>

        @if($item->gallery_amount > 0)
        <div class="col-12 col-md-4 col-lg-3">
            <div class="row">
                @for($i = 0; $i < $item->gallery_amount; $i++)
                <div class="col-6">
                    <a data-fancybox="gallery" href="/img/{{$url}}/{{ $item->id.'_'.strtolower(str_replace(" ", "_", $item->title)).'_'.$i }}.jpg">
                        <div class="gallery_image" style="background-image:url(/img/{{$url}}/{{ $item->id.'_'.strtolower(str_replace(" ", "_", $item->title)).'_'.$i }}.jpg); background-size: cover; background-position: center; height: 10rem; margin-bottom: 1rem;"></div>
                    </a>
                </div>
                @endfor
            </div>
        </div>
        @endif

        <div class="col-12 col-md-4 col-lg-3">
            @if($type == 1)
            <p class="entity-attribute">Konzol: {{ $item->getPlatform->title }}</p>
            @endif

            @if($type == 2 || $type == 3)
            <p class="entity-attribute">Gyártó: {{ $item->getCompany->name }}</p>
            @endif

            @if($type == 1 || $type == 2)
            <p class="entity-attribute">Kiadás éve: {{ $item->release_year }}</p>
            @endif

            @if($type == 1 || $type == 2 || $type == 3)
                @if($item->serial_number)
                <p class="entity-attribute">Sorszám: {{ $item->serial_number }}</p>
                @endif
            @endif

            @if($type == 1 || $type == 2)
            <p class="entity-attribute">Régió: {{ $item->getRegion->title }}</p>
            @endif

            @if($type == 1)
            <p class="entity-attribute">Kiadás: {{ $item->getRelease->title }}</p>
            <p class="entity-attribute">Borító nyelve: {{ $item->getCoverLanguage->title }}</p>
            <p class="entity-attribute">Játék nyelve: {{ $item->getGameLanguage->title }}</p>
            @endif

            @if($type == 1)
                @if($item->manual)
                <p class="entity-attribute">Van manual</p>
                @else
                <p class="entity-attribute">Nincs manual</p>
                @endif
            @endif

            @if($type == 1 || $type == 2 || $type == 3)
                @if($item->sealed)
                <p class="entity-attribute">Bontatlan</p>
                @endif
            @endif
            
            @if($type == 1 || $type == 2)
                @if($item->special_edition)
                <p class="entity-attribute">Special edition</p>
                @endif
            @endif

            <p class="entity-attribute">{{ $item->delivery ? 'Van szállítás' : 'Nincs szállítás' }}</p>
        </div>

        @if($item->is_sold == 0)
        <div class="col-12 text-center">
            @if(Auth::check() && Auth::id() != $item->getUser->id)
                <form action="{{ route('messages.store') }}" method="post">
                    @csrf
                    <div class="form-group mt-5">
                        <label for="newMessage" class="mb-2">Üzenet írása</label>
                        <textarea class="form-control input-dark mb-3" id="newMessage" name="message" rows="6" autofocus></textarea>
                        <input type="hidden" name="to" value="{{ $item->getUser->id }}">
                        <input type="hidden" name="subject_type" value="{{ $type }}">
                        <input type="hidden" name="item_id" value="{{ $item->id }}">

                        <div class="text-center">
                            <button class="btn btn-red m-auto mb-3">Mehet</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>        
        @endif
        
    </div>
@stop
