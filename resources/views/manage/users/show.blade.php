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

            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="user-avatar-section mt-3">
                                <div class=" d-flex align-items-center flex-column">
                                    <div class="user-info text-center">
                                        <h4 class="mb-2">{{$user->getFullName()}}</h4>
                                        <span class="badge bg-label-{{$user->role->color}}">{{$user->role->name}}</span>
                                    </div>
                                </div>
                            </div>

                            <h5 class="pb-2 border-bottom mb-4 mt-4">Информация о пользователе</h5>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Паспортные данные:</span>
                                        <span>{{$user->getPassport()}}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Дата рождения:</span>
                                        <span>{{\Carbon\Carbon::parse($user->date_of_birth)->format('d.m.Y')}}</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Пол:</span>
                                        <span>
                                            @if($user->sex == 'M')
                                                Мужской
                                            @else
                                                Женский
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">СНИЛС:</span>
                                        <span>
                                            @if($user->snils)
                                                {{$user->snils}}
                                            @else
                                                <span class="text-danger">Информация не заполнена</span>
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fw-medium me-2">Гражданство по коду ОКСМ:</span>
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
        </div>
    </div>


@endsection

