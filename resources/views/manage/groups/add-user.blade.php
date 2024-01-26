@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a class="text-muted" href="{{route('groups.index')}}">Группы</a> / </span>  Добавление студентов</h4>

    <div class="d-flex mb-4">
        <a href="{{route('groups.index')}}" class="btn btn-primary">
            <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Добавление студентов</h5>
                <div class="card-body">
                    <form method="POST" action="{{route('groups.add-user-store', ['group' => $id])}}">
                        @csrf
                        <label for="learning_program" class="form-label">Выберите студентов для добавления в группу</label>
                        <div class="select2-primary">
                            <div class="position-relative">
                                <select id="users" required name="users[]"
                                        class="select2 form-select select2-hidden-accessible"
                                        multiple
                                        data-minimum-selection-length="1"
                                        data-placeholder="Выберите студентов">
                                    @foreach($users as $item)
                                        <option value="{{$item->id}}">
                                            {{$item->getFullName()}} (Паспортные данные: {!! $item->getPassport() !!}) -
                                            @foreach($item->roles as $role)
                                                {{$role->nameRU}}
                                            @endforeach
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-success">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <h5 class="card-header">Обучающиеся в группе - {{$group->name}}</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        @if($group->users->isEmpty())
                            <p class="fw-bold">Студентов не найдено 😭</p>
                        @else
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>ФИО</th>
                                    <th>Паспортные данные</th>
                                    <th>Номер телефона</th>
                                    <th>Взаимодействие</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                @foreach($group->users as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                           {{$item->getFullName()}}
                                        </td>
                                        <td>
                                            {{$item->getPassport()}}
                                        </td>
                                        <td>
                                            <a href="tel:{{$item->phone}}">{{$item->phone}}</a>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <form action="{{route('groups.destroy-group-user', ['group' => $item->id, 'id' => $item->pivot->id])}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn rounded-pill btn-icon btn-danger text-white delete" data-bs-toggle="modal"
                                                            data-bs-target="#modalCenter">
                                                        <span class="tf-icons bx bx-trash"></span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

