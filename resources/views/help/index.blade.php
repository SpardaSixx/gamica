@extends('layouts.default')

@section('content')
    @if(Auth::check())
    <a href="{{route('help.create')}}" class="btn btn-brand">Létrehozás</a>
    <br><br>
    @endif

    <p class="mb-3">Összes segítségkérés: {{$helpQuestions->total()}} </p>

    @forelse($helpQuestions as $question)
    <div class="question-wrapper mb-3">
        <div class="user p-3">
            <div class="row">
                <div class="col-6">
                    @if($question->anonymous)
                        <p class="name text-start fst-italic m-0">Névtelen</p>
                    @else
                        <a href="{{route('users.show', $question->getUser->id)}}" style="color: #eee;">
                            <div class="img" style="background-image: url({{$question->getUser->getPhoto()}})"></div>
                            <p class="name text-start fst-italic m-0">
                                {{$question->getUser->username}}
                            </p>
                        </a>
                    @endif
                </div>

                <div class="col-6">
                    <p class="text-end fst-italic m-0">{{$question->created_at}}</p>
                </div>
            </div>

            <p>Válaszok: {{$question->getAnswers->count()}}<p>
        </div>

        <div class="question p-3">{!! $question->question !!}</div>

        <div class="accordion answers" id="accordionHelp{{$question->id}}">
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{$question->id}}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$question->id}}" aria-expanded="false" aria-controls="collapse{{$question->id}}">
                        Válaszok mutatása
                    </button>
                </h2>

                <div id="collapse{{$question->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$question->id}}" data-bs-parent="#accordionHelp{{$question->id}}">
                    <div class="accordion-body">
                        @if(Auth::check())
                            <div class="text-center pb-2 mb-2">
                                <a data-bs-toggle="collapse" href="#collapseAnswer{{$question->id}}" role="button" aria-expanded="false" aria-controls="collapseAnswer{{$question->id}}" class="btn btn-brand">Válaszolok</a>
                            </div>

                            <div class="collapse" id="collapseAnswer{{$question->id}}">
                                <form action="{{route('help-post-answer', $question->id)}}" method="post" class="submit-form">
                                    @csrf
                                    
                                    <div class="form-group mb-3">
                                        <label for="title">Válasz*</label>
                                        <textarea class="ckeditor form-control input-dark mb-3" id="answer" name="answer" rows="6" required></textarea>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="anonymous" name="anonymous">
                                        <label class="form-check-label" for="anonymous">Névtelenül</label>
                                    </div>
                                    <br>

                                    <button type="submit" type="button" class="btn btn-brand my-2 submit-btn">Mehet</button>
                                </form>
                            </div>
                        @endif

                        <div>
                        @forelse($question->getAnswers as $answer)
                            <div class="answer-wrapper mb-3 p-2">
                                <div class="row">
                                    <div class="col-6">
                                        @if($answer->getAnswer->anonymous)
                                            <span class="text-start fst-italic m-0 p-2">
                                                Névtelen
                                            </span>
                                        @else
                                            <a href="{{route('users.show', $answer->getAnswer->getUser->id)}}" style="color: #eee;">
                                                <img src="{{$answer->getAnswer->getUser->getPhoto()}}">
                                                <span class="text-start fst-italic m-0 p-2">
                                                    {{$answer->getAnswer->getUser->username}}
                                                    {{$answer->anonymous}}
                                                </span>
                                            </a>
                                        @endif
                                    </div>

                                    <div class="col-6">
                                        <p class="text-end fst-italic m-0 p-2">{{$answer->getAnswer->created_at}}</p>
                                    </div>
                                </div>
                                <p class="answer m-0 p-2">{!! $answer->getAnswer->answer !!}</p>
                            </div>
                        @empty
                            <p class="text-center my-3 fst-italic">Még nem érkezett válasz a kérdésre!</p>
                        @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <p class="text-center my-3 fst-italic">Még nem érkezett segítségkérés.</p>
    @endforelse

    <br>

    @if($helpQuestions->total() > 10)
    <div class="pagination text-center d-block mb-4">
        <a href="{{ $helpQuestions->withQueryString()->previousPageUrl() }}" class="d-inline-block {{ $helpQuestions->onFirstPage() ? 'disabled' : '' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_left
            </span>
        </a>
        @php
         $totalPages = ceil( $helpQuestions->total() / $helpQuestions->perPage() );
         if($totalPages == 0){
            $totalPages = 1;
         }
        @endphp
        <span>{{ $helpQuestions->currentPage().'/'.$totalPages }}</span>
        <a href="{{ $helpQuestions->withQueryString()->nextPageUrl() }}" class="d-inline-block {{ $helpQuestions->hasMorePages() ? '' : 'disabled' }}">
            <span class="material-symbols-outlined" style="font-size: 2rem; position: relative; top: 10px; color: #eee;">
            chevron_right
            </span>
        </a>
    </div>
    @endif
@stop
