@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light"><a class="text-muted" href="{{route('learning-program.my')}}">Мои учебные программы</a> / </span> {{$lp->name}}</h4>

    <div class="card g-3 mt-3">
        <div class="card-body row g-3">
            <div class="col-lg-4 order-1">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-2 gap-1">
                    <div class="me-1">
                        <h5 class="mb-1">{{$lp->name}}</h5>
{{--                        <p class="mb-1">Prof. <span class="fw-medium"> Devonne Wallbridge </span></p>--}}
                    </div>
{{--                    <div class="d-flex align-items-center">--}}
{{--                        --}}
{{--                    </div>--}}
                </div>

                <div class="card academy-content shadow-none border mt-3">

                    <div class="card-body">

                        <h5>Информация о курсе: </h5>
                        <div class="d-flex flex-wrap">
                            <div class="me-5">
                                <p class="text-nowrap"><i class="bx bxs-flag-alt bx-sm me-2"></i>Язык обучения: Русский</p>
                                <p class="text-nowrap"><i class="bx bx-pencil bx-sm me-2"></i>Тем в курсе: {{$lp->themes->count()}}</p>
                                <p class="text-nowrap"><i class="bx bx-file bx-sm me-2"></i>Рабочая программа:
                                    <a href="{{asset($lp->working_program)}}" class="card-link" download="{{str()->slug($lp->name)}}">
                                         Скачать
                                    </a>
                                </p>
                            </div>
                        </div>
                        <hr class="mb-4 mt-2">
                        <h5 class="mb-2">Аннотация</h5>
                        <div class="mb-0 pt-1">
                             @if(strlen(strip_tags($lp->annotation)) == 0)
                                 <p class="text-danger">Аннотация курса не заполнена</p>
                            @else
                                 {!! $lp->annotation !!}
                            @endif
                        </div>
                        <hr class="my-4">
                        <h5>Преподаватель курса: </h5>
                        <div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-2">
                                    <img src="{{Vite::asset('resources/assets/img/avatars/7.png')}}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-medium">Иванов Иван</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 order-0">
                @if($lp->themes->count() == 0)
                    <p>Тем для выбранной программы не найдено</p>
                @else
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-2 gap-1">
                        <div class="me-1">
                            <h5 class="mb-1">Тематическое планирование</h5>
                        </div>
                    </div>

                    <div class="accordion stick-top accordion-bordered course-content-fixed mt-3" id="courseContent">

                        @foreach($lp->themes as $theme)
                            <div class="accordion-item shadow-none border @if(!$loop->last) border-bottom-0 @endif active mb-0">
                                <div class="accordion-header">
                                    <button type="button" class="accordion-button bg-lighter rounded-0" data-bs-toggle="collapse" data-bs-target="#theme{{$theme->id}}" aria-expanded="true" aria-controls="theme{{$theme->id}}">
                                  <span class="d-flex flex-column">
                                    <span class="h5 mb-1">{{$theme->name}}</span>
                                      @if($theme->activities->count() == 0)
                                          <span class="fw-normal text-danger">В данной теме нет активностей</span>
                                      @else
                                          <span class="fw-normal">0 / {{$theme->activities->count()}} </span>
                                      @endif

                                  </span>
                                    </button>
                                </div>
                                <div id="theme{{$theme->id}}" class="accordion-collapse collapse @if($loop->first) show @endif" data-bs-parent="#courseContent">
                                    <div class="accordion-body py-3 border-top">
                                        @if($theme->activities->count() != 0)
                                            @foreach($theme->activities as $activity)
                                                <div class="form-check d-flex align-items-center mb-3">
                                                    <input class="form-check-input" type="checkbox" id="defaultCheck1" checked="">
                                                    <label for="defaultCheck1" class="form-check-label ms-3">
                                                        <span class="mb-0 h6">{{$activity->name}}</span>
                                                        <span class="text-muted d-block">Кол-во часов: {{$activity->count_hours}}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif


                                    </div>
                                </div>
                            </div>
                        @endforeach

                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

