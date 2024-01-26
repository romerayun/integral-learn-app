@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление /</span> Пользователи</h4>

    <div class="row">
        <div class="col-md-12">
            @if(auth()->user()->can('add users'))
                <div class="d-flex mb-4 gap-2">
                    <a href="{{route('users.create')}}" class="btn btn-success">
                        <span class="tf-icons bx bx-plus"></span>&nbsp; Добавить
                    </a>
                    <a href="{{route('users.import')}}" class="btn btn-secondary">
                        <span class="tf-icons bx bx-upload"></span>&nbsp; Импорт данных
                    </a>
                </div>
            @endif

            @if(auth()->user()->can('all users'))
            <div class="card mb-4">
                <h5 class="card-header">Список пользователей</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        @if($users->isEmpty())
                            <p class="fw-bold">Пользователей не найдено 😭</p>
                        @else
                            <table class="table table-sm table-hover" id="dataTable">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th class="w-auto">Тип</th>
                                    <th>ФИО</th>
                                    <th>Паспорт</th>
                                    <th>Номер телефона</th>
                                    <th>Учебные группы</th>
                                    @if(auth()->user()->can('show users') || auth()->user()->can('edit users') || auth()->user()->can('delete users'))
                                        <th class="text-end">Взаимодействие</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                @foreach($users as $key => $item)
                                    <tr >
                                        <td>{{$key+1}}</td>
                                        <td class="w-px-100">
                                            @foreach($item->roles as $role)
                                            <span class="badge bg-{{$role->color}} fs-tiny">
                                                {{$role->nameRU}}
                                            </span>
                                            @endforeach

                                            <span class="badge fs-tiny @if($item->is_email_verified) bg-success @else bg-danger @endif">
                                                @if($item->is_email_verified) Подтвержден @else Не подтвержден @endif
                                            </span>
                                        </td>
                                        <td>
                                            {{$item->getFullName()}}
                                        </td>
                                        <td>{!! $item->getPassport() !!}</td>
                                        <td>
                                            @if(empty($item->phone))
                                                <span class="text-danger">Не заполнено</span>
                                            @else
                                                <a href="tel:{{$item->phone}}">{{ $item->phone }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                @if(count($item->groups))
                                                    @foreach($item->groups as $group)
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up bg-dark rounded-circle text-center shadow text-white text-uppercase" aria-label="{{$group->name}}" data-bs-original-title="{{$group->name}}" style="border: 2px solid #fff">
                                                            {{mb_substr($group->name, 0 , 1, 'UTF-8')}}
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <span class="text-danger">Не прикреплен</span>
                                                @endif


                                            </ul>

                                        </td>
                                        @if(auth()->user()->can('show users') || auth()->user()->can('edit users') || auth()->user()->can('delete users'))

                                        <td class="text-end">
                                            <div class="text-end">
                                                <a href="{{route('users.edit', ['user' => $item->id])}}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>
                                                <div class="d-inline-block">
                                                    <a  class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0">
                                                        <li>
                                                            <a href="{{route('users.show', ['user' => $item->id])}}" class="dropdown-item"><span class="tf-icons bx bx-show"></span> Открыть</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{route('users.repeatPE', ['user' => $item->id])}}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item">
                                                                    <span class="tf-icons bx bx-refresh"></span> Повторная отправка<br>письма подтверждения
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <form action="{{route('users.destroy', ['user' => $item->id])}}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger delete-record delete" data-bs-toggle="modal"
                                                                        data-bs-target="#modalCenter">
                                                                    <span class="tf-icons bx bx-trash"></span> Удалить
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
                @endif
        </div>
    </div>


@endsection

