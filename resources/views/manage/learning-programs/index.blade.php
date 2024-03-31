@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление /</span> Учебные программы</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('learning-programs.create')}}" class="btn btn-success">
                    <span class="tf-icons bx bx-plus"></span>&nbsp; Добавить
                </a>
            </div>


            <div class="card mb-4">
                <h5 class="card-header">Перечень учебных программ</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        @if($learningPrograms->isEmpty())
                            <p class="fw-bold">Учебных программ не найдено 😭</p>
                        @else
                            <table class="table table-hover table-sm" id="dataTable">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Наименование учебной программы</th>
                                    <th>Аннотация</th>
                                    <th>Рабочая программа</th>
                                    <th>Взаимодействие</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                @foreach($learningPrograms as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            {{$item->name}}
                                        </td>
                                        <td>
                                            Аннотация учебной программы доступна в просмотре
                                        </td>
                                        <td>
                                            @if($item->working_program)
                                                <a href="/storage/{{($item->working_program)}}" download="Рабочая программа учебной программы - {{$item->name}}">Скачать</a>
                                            @else
                                                <span class="text-danger">Рабочая программа не добавлена</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-end">

                                                <a href="{{route('learning-programs.edit', ['learning_program' => $item->id])}}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>

                                                <div class="d-inline-block">
                                                    <a  class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0">
                                                        <li>
                                                            <a href="{{route('learning-programs.show', ['learning_program' => $item->id])}}" class="dropdown-item"><span class="tf-icons bx bx-show"></span> Открыть</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{route('learning-programs.destroy', ['learning_program' => $item->id])}}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item delete" data-bs-toggle="modal"
                                                                        data-bs-target="#modalCenter">
                                                                    <span class="tf-icons bx bx-trash"></span> Удалить
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>





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

