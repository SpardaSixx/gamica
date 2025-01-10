@extends('layouts.default')

@section('content')

    <h2 class="entity-title text-center">Üzenet ajánlattételről</h2>

    <div class="row">
        <div class="col-12">
            <h2 class="entity-title d-inline-block">{{ $wanted->title }}</h2>
            <br>
            <h2 class="entity-title d-inline-block">{{ $wanted->getPrice() }} Ft</h2>
        </div>

        @if($wanted->is_found == 1)
        <div class="col-12 text-center">
            <h1 class="badge bg-danger text-light my-3 mx-auto" style="width: fit-content; dispaly: table; font-size: 1.5rem;">MEGTALÁLVA</h1><br>
        </div>
        @endif

        <div class="col-12 col-md-4 col-lg-3">
            @if($wanted->has_photo == 1)
            <a data-fancybox="gallery" href="{{ $wanted->getPhoto() }}">
                <img src="{{ $wanted->getPhoto() }}" class="mb-3" style="max-width: 100%;">
            </a>
            @endif
        </div>

        @if($wanted->gallery_amount > 0)
        <div class="col-12 col-md-4 col-lg-3">
            <div class="row">
                @for($i = 0; $i < $wanted->gallery_amount; $i++)
                <div class="col-6">
                    <a data-fancybox="gallery" href="/img/wanteds/{{ $wanted->id.'_'.strtolower(str_replace(" ", "_", $wanted->title)).'_'.$i }}.jpg">
                        <div class="gallery_image" style="background-image:url(/img/wanteds/{{ $wanted->id.'_'.strtolower(str_replace(" ", "_", $wanted->title)).'_'.$i }}.jpg); background-size: cover; background-position: center; height: 10rem; margin-bottom: 1rem;"></div>
                    </a>
                </div>
                @endfor
            </div>
        </div>
        @endif

        <div class="col-12 col-md-4 col-lg-3">
            <p class="entity-attribute">Konzol: {{ $wanted->getPlatform->title }}</p>

            <p class="entity-attribute">Kiadás éve: {{ $wanted->release_year }}</p>

            @if($wanted->serial_number)
            <p class="entity-attribute">Sorszám: {{ $wanted->serial_number }}</p>
            @else
            <p class="entity-attribute">Sorszám:</p>
            @endif

            <p class="entity-attribute">Régió: {{ $wanted->getRegion->title }}</p>
            <p class="entity-attribute">Kiadás: {{ $wanted->getRelease->title }}</p>
            <p class="entity-attribute">Borító nyelve: {{ $wanted->getCoverLanguage->title }}</p>
            <p class="entity-attribute">Játék nyelve: {{ $wanted->getGameLanguage->title }}</p>

            @if($wanted->manual)
            <p class="entity-attribute">Van manual</p>
            @else
            <p class="entity-attribute">Nincs manual</p>
            @endif

            @if($wanted->sealed)
            <p class="entity-attribute">Bontatlan</p>
            @endif
            
            @if($wanted->special_edition)
            <p class="entity-attribute">Special edition</p>
            @endif

            <p class="entity-attribute">{{ $wanted->delivery ? 'Van szállítás' : 'Nincs szállítás' }}</p>
        </div>

        @if($wanted->is_found == 0)
        <div class="col-12 text-center">
            @if(Auth::check() && Auth::id() != $wanted->getUser->id)
                <form action="{{ route('messages.store') }}" method="post">
                    @csrf
                    <div class="form-group mt-5">
                        <label for="newMessage" class="mb-2">Üzenet írása</label>
                        {{-- <textarea class="ckeditor form-control input-dark mb-3" name="message" id="newMessage"></textarea> --}}
                        <textarea class="form-control input-dark mb-3" id="newMessage" name="message" rows="6"></textarea>
                        <input type="hidden" name="to" value="{{ $wanted->getUser->id }}">
                        <input type="hidden" name="subject_type" value="5">
                        <input type="hidden" name="item_id" value="{{ $wanted->id }}">

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
