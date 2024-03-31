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
                                 <div class="annotation">
                                    {!! $lp->annotation !!}
                                 </div>
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

                    <div class="accordion accordion-bordered mt-3">

                        @php $prevThemeComplete = false @endphp

                        @foreach($lp->themes as $theme)
                            @if($theme->activities->count() == 0) @php continue; @endphp @endif
                            @php
                                $completeActivitiesTheme = checkCompleteAllTheme($lp->id, $theme->id);
                            @endphp
                            <div class="accordion-item shadow-none border @if(!$loop->last) border-bottom-0 @endif active mb-0">

                                <div class="accordion-header">
                                    <button type="button" class="accordion-button bg-lighter rounded-0" data-bs-toggle="collapse" data-bs-target="#theme{{$theme->id}}" aria-expanded="true" aria-controls="theme{{$theme->id}}">
                                  <span class="d-flex flex-column">
                                    <span class="h5 mb-1">{{$theme->name}}</span>
                                      @if($theme->activities->count() == 0)
                                          <span class="fw-normal text-danger">В данной теме нет активностей</span>
                                      @else
                                          <span class="fw-light">Активности (выполнено/всего): {{$completeActivitiesTheme['count']}} / {{$theme->activities->count()}} </span>
                                      @endif

                                  </span>
                                    </button>
                                </div>
                                <div id="theme{{$theme->id}}" class="accordion-collapse collapse show" data-bs-parent="#courseContent">
                                    <div class="accordion-body py-3 border-top">
                                        @if (!$prevThemeComplete && !$loop->first)
                                            <div class="blur-overlay">
                                                <i class="bx bx-lock fs-2"></i>
                                                <p class="mt-2 mb-0">Тема заблокирована, заврешите предыдущие активности</p>
                                            </div>
                                        @endif
                                        @if($theme->activities->count() != 0)
                                            <ol class="ps-4 activities-list">
                                            @php $activityLock = false; @endphp
                                            @foreach($theme->activities as $activity)

                                                @if(!$prevThemeComplete && !$loop->parent->first) @php $activityLock = true; @endphp @endif

{{--                                                {{$activity->complete}}--}}
                                                <li class="@if($activityLock) text-muted disabled-activity @else text-dark @endif">

                                                    <div class="d-flex align-content-between align-items-center">
                                                        <a href="@if($activityLock) # @else {{route('learning-program.showActivity', ['learning_program' => $lp->id, 'theme' => $theme->id, 'activity' => $activity->id])}} @endif" class="flex-grow-1 @if($activityLock) text-muted disabled-activity @else text-dark @endif">
                                                            <div class="lp-body flex-grow-1">
                                                                <p class="lp-body__name mb-0 ">
                                                                    {{$activity->name}}
                                                                </p>
                                                                <div class="d-flex fs-tiny align-items-center mt-2">
                                                                    <span class="badge @if($activityLock)bg-label-secondary @else bg-label-{{$activity->type->color}} @endif  activity-type">{{$activity->type->name}}</span>
                                                                    <span class="activity-hours">{{$activity->count_hours}}</span>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="lp-actions d-flex gap-2">
                                                            @if($activityLock)
                                                                Активность закрыта
                                                            @else
                                                                <a href="{{route('learning-program.showActivity', ['learning_program' => $lp->id, 'theme' => $theme->id, 'activity' => $activity->id])}}" class="btn btn-sm rounded-pill btn-icon btn-label-primary" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Просмотреть активность">
                                                                    <span class="tf-icons bx bx-show"></span>
                                                                </a>
                                                                @php $completeActivity = checkCompleteActivity($lp->id, $theme->id, $activity->id) @endphp
                                                                @if($completeActivity)
                                                                    <span class="text-primary fw-bold">Активность завершена 🥳</span>
                                                                @else
                                                                    @php $activityLock = true; @endphp
                                                                    <form action="{{route('learning_program.complete', [
                                                                    'learning_program' => $lp->id,
                                                                    'theme_id' => $theme->id,
                                                                    'activity_id' => $activity->id,
                                                                    ])}}" method="POST">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm rounded-pill btn-icon btn-label-secondary" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Завершить активность">
                                                                            <span class="tf-icons bx bx-check-double"></span>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>

                                            @endforeach
                                            </ol>
                                        @else
                                            <span class="fw-normal">Активности еще не добавлены 😢</span>
                                        @endif


                                    </div>
                                </div>
                            </div>
                            @php $prevThemeComplete = $completeActivitiesTheme['result'] @endphp
                        @endforeach

                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

