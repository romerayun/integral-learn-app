@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление /</span> Типы активностей</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('activity-types.create')}}" class="btn btn-success">
                    <span class="tf-icons bx bx-plus"></span>&nbsp;Добавить
                </a>
            </div>


            <div class="card mb-4">
                <h5 class="card-header">Типы активностей</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        @if($activityTypes->isEmpty())
                            <p class="fw-bold">Типов активностей не найдено 😭</p>
                        @else
                            <table class="table table-hover table-sm" id="dataTable">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Цвет отображения</th>
                                    <th>Наименование</th>
                                    <th>
                                        <div class="text-end pe-3">Взаимодействие</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                @foreach($activityTypes as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <div class="square-color-{{$item->color}}"></div>
                                        </td>
                                        <td>
                                            {{$item->name}}
                                        </td>
                                        <td>
                                            <div class="text-end">
                                                <a href="{{route('activity-types.edit', ['activity_type' => $item->id])}}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>
                                                <div class="d-inline-block">
                                                    <a  class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0">
                                                        <li>
                                                            <form action="{{route('activity-types.destroy', ['activity_type' => $item->id])}}" method="POST">
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

