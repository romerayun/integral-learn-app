@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a class="text-muted" href="{{route('users.index')}}">Пользователи</a> / </span>
        {{$user->getFullName()}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('users.index')}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>

{{--            @if(auth()->user()->id == $user->id)--}}
{{--                123--}}
{{--            @else--}}
{{--                456--}}
{{--            @endif--}}

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="user-profile-header-banner">
                            @if(!auth()->user()->banner)
                                <img class="rounded-top" src="{{ Vite::asset('resources/assets/img/no-image.jpeg') }}" alt="Banner profile">
                            @else
                                <img class="rounded-top" src="{{ asset('/storage/' . auth()->user()->banner)}}" alt="Banner profile">
                            @endif
{{--                            <img src="{{ Vite::asset('resources/assets/img/backgrounds/18.jpg') }}" alt="Banner image" class="rounded-top">--}}
                        </div>
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                @if(!auth()->user()->avatar)
                                    <img class=" object-fit-cover user-profile-img d-block h-100 ms-0 ms-sm-4" src="{{ Vite::asset('resources/assets/img/no-image.jpeg') }}" alt="Avatar profile">
                                @else
                                    <img class=" object-fit-cover user-profile-img d-block h-100 ms-0 ms-sm-4" src="{{ asset('/storage/' . auth()->user()->avatar)}}" alt="Avatar profile">
                                @endif
{{--                                <img src="{{ Vite::asset('resources/assets/img/avatars/1.png')}}" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img">--}}
                            </div>
                            <div class="flex-grow-1 mt-3 mt-sm-5">
                                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4>{{$user->getFullName()}}</h4>
                                        <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            @if($user->roles->first())
                                            <li class="list-inline-item fw-medium">
                                                <i class="bx bx-pen"></i> {{$user->roles->first()->nameRU}}
                                            </li>
                                            @endif
                                            @if($user->date_of_birth)
                                            <li class="list-inline-item fw-medium">
                                                <i class="bx bx-calendar-event"></i> {{\Illuminate\Support\Carbon::make($user->date_of_birth)->format('d.m.Y')}} г.
                                            </li>
                                            @endif
                                            <li class="list-inline-item fw-medium">
                                                <i class="bx bx-chat"></i> Присоединился: {{\Illuminate\Support\Carbon::make($user->created_at)->format('m.Y')}} г.
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="pb-2 border-bottom mb-2 mt-2">Персональные данные</h5>
                            <div class="info-container">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <span class="fw-bold me-2">Паспортные данные:</span>
                                        <span>{!! $user->getPassport() !!}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="fw-bold me-2">Дата рождения:</span>
                                        <span>{{\Carbon\Carbon::parse($user->date_of_birth)->format('d.m.Y')}} г.</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="fw-bold me-2">Пол:</span>
                                        <span>
                                            @if($user->sex == 'M')
                                                Мужской
                                            @else
                                                Женский
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="fw-bold me-2">СНИЛС:</span>
                                        <span>
                                            @if($user->snils)
                                                {{$user->snils}}
                                            @else
                                                <span class="text-danger">Информация не заполнена</span>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-0">
                                        <span class="fw-bold me-2">Гражданство по коду ОКСМ:</span>
                                        <span>
                                            @if($user->nationality)
                                                {{$user->nationality}}
                                            @else
                                                <span class="text-danger">Информация не заполнена</span>
                                            @endif
                                        </span>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-8 col-md-12">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header align-items-center">
                                    <h5 class="card-action-title mb-0"><i class="bx bxs-graduation me-2"></i>Активные учебные программы</h5>
                                </div>
                                <div class="card-body">
                                    @if(count($user->groups)==0)
                                        <p class="text-danger">Пользователь не прикреплен ни к одной учебной группе</p>
                                    @else


                                            @foreach($user->groups as $group)
                                            @php $i = 1; @endphp
                                            <h5>Группа - {{$group->name}}</h5>
                                            <table class="table table-hover mb-3">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Программа</th>
                                                    <th class="w-75">Прогресс обучения</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($group->learningPrograms as $lp)

                                                    <tr>
                                                        <td>{{$i}}</td>
                                                        <td>{{$lp->name}}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-between align-items-center gap-3">
                                                                <div class="progress w-100" style="height:10px;">
                                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{getCompleteActivity($lp->id)}}%" aria-valuenow="{{getCompleteActivity($lp->id)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                                <small class="fw-medium">{{getCompleteActivity($lp->id)}}%</small>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    @php $i++; @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                            @endforeach

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
{{--                <div class="col-lg-4 col-md-12">--}}
{{--                    <div id="chart"></div>--}}
{{--                </div>--}}
                <div class="col-lg-4 col-md-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-action mb-4">
                                <div class="card-header align-items-center">
                                    <h5 class="card-action-title mb-0"><i class="bx bx-list-ul me-2"></i>История работы</h5>
                                    <div class="card-action-element">
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Экспортировать в Excel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(!$activities->count())
                                        <p class="text-danger mb-4 fw-bold">Истории последних действий пользователя не найдено</p>
                                    @else
                                        <p class="text-primary mb-4 fw-bold">Отображается 5 последних действий пользователя</p>

                                        <ul class="timeline ms-2">
                                            @foreach($activities as $activity)
                                                <li class="timeline-item timeline-item-transparent">
                                                    <span class="timeline-point-wrapper"><span class="timeline-point timeline-point-{{getTypeActivityLog($activity->event)['color']}}"></span></span>
                                                    <div class="timeline-event">
                                                        <div class="timeline-header mb-1">
                                                            <h6 class="mb-0">{{getNameActivity($activity->log_name)}}</h6>
                                                            <small class="text-muted">{{\Illuminate\Support\Carbon::make($activity->created_at)->diffForHumans()}}</small>
                                                        </div>
                                                        <p class="mb-0">
                                                            @if($activity->event == 'default')
                                                                {{$activity->description}}
                                                            @else
                                                                {{getTypeActivityLog($activity->event)['name']}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


@endsection

