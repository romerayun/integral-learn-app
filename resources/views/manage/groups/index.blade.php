@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление /</span> Группы</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('groups.create')}}" class="btn btn-success">
                    <span class="tf-icons bx bx-plus"></span>&nbsp;Добавить
                </a>
            </div>


            <div class="card mb-4">
                <h5 class="card-header">Список групп</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        @if($groups->isEmpty())
                            <p class="fw-bold">Групп не найдено 😭</p>
                        @else
                            <table class="table table-hover table-sm" id="dataTable">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Учебные программы</th>
                                    <th>Наименование группы</th>
                                    <th>Начало обучения</th>
                                    <th>Конец обучения</th>
                                    <th class="text-center">Обучающихся в группе</th>
                                    <th>Взаимодействие</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                @foreach($groups as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td >

                                            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                @if(count($item->learningPrograms))
                                                    @foreach($item->learningPrograms as $lp)
                                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up bg-dark rounded-circle text-center shadow text-white text-uppercase" aria-label="{{$lp->name}}" data-bs-original-title="{{$lp->name}}" style="border: 2px solid #fff">
                                                            {{mb_substr($lp->name, 0 , 1, 'UTF-8')}}
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <span class="text-danger">Учебных программ не найдено</span>
                                                @endif


                                            </ul>

                                        </td>
                                        <td>
                                            {{$item->name}}
                                        </td>
                                        <td>{{\Carbon\Carbon::parse($item->start_date)->format('d.m.Y')}} г.</td>
                                        <td>{{\Carbon\Carbon::parse($item->end_date)->format('d.m.Y')}} г.</td>

                                        <td class="text-center">
                                            <span class="badge badge-center bg-primary">{{$item->users->count()}}</span>
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
                                                            <a href="{{route('groups.add-user', ['group' => $item->id])}}" class="dropdown-item"><span class="tf-icons bx bx-user-plus"></span> Добавить обучающихся</a>
                                                        </li>
                                                        <li>
                                                            <form action="{{route('groups.destroy', ['group' => $item->id])}}" method="POST">
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

