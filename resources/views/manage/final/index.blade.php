@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление /</span> Итоговое тестирование</h4>

    <div class="row">
        <div class="col-md-12">
            @can('add final quiz')
            <div class="d-flex mb-4">
                <a href="{{route('final-quiz.create')}}" class="btn btn-success">
                    <span class="tf-icons bx bx-plus"></span>&nbsp;Создать тестирование
                </a>
            </div>
            @endcan


            <div class="card mb-4">
                <h5 class="card-header">Активные тесты</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        @if($quizzes->isEmpty())
                            <p class="fw-bold">Активных тестов не найдено 😭</p>
                        @else
                            <table class="table table-hover table-sm" id="dataTable">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Статус</th>
                                    <th>Учебная программа</th>
                                    <th>Кол-во вопросов</th>
                                    <th>Ключ доступа</th>
                                    <th>Дата/Время создания</th>
                                    <th>Прохождение тестирования</th>
                                    @canany([
                                        'delete final quiz',
                                        'show results final quiz',
                                        'close final quiz',
                                     ])
                                    <th>
                                        <div class="text-end pe-3">Взаимодействие</div>
                                    </th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                @foreach($quizzes as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            @if($item->isActive)
                                                <span class="badge bg-success">Активный</span>
                                            @else
                                                <span class="badge bg-danger">Закрыт</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{$item->learningProgram->name}}
                                        </td>
                                        <td>
                                            {{$item->countQuestions}}
                                        </td>
                                        <td>
                                            {{$item->key}}
                                        </td>
                                        <td>{{\Carbon\Carbon::parse($item->created_at)->format('d.m.Y г. / H:i')}}</td>
                                        <td>
                                            Попыток: {{$item->finalQuizResult->count()}}  {!! getSuccessAndFailFinalQuiz($item->finalQuizResult) !!}
                                        </td>
                                        @canany([
                                            'delete final quiz',
                                            'show results final quiz',
                                            'close final quiz',
                                         ])
                                        <td>
                                            <div class="text-end">

                                                <div class="d-inline-block">
                                                    @can('show results final quiz')
                                                    <a href="{{route('final-quiz.show-results', ['key' => $item->key])}}" class="btn btn-sm btn-icon item-edit" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Посмотреть результаты"><i class="bx bx-show"></i></a>
                                                    @endcan

                                                    @canany([
                                                        'delete final quiz',
                                                        'close final quiz',
                                                    ])

                                                    <a class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0">
                                                        @can('close final quiz')
                                                        <li>
                                                            <form action="{{route('final-quiz.disable', ['final_quiz' => $item->id])}}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="dropdown-item">
                                                                    <span class="tf-icons bx bx-power-off"></span> Закрыть тестирование
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endcan
                                                        @can('delete final quiz')
                                                        <li>
                                                            <form action="{{route('final-quiz.destroy', ['final_quiz' => $item->id])}}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger delete-record delete" data-bs-toggle="modal"
                                                                        data-bs-target="#modalCenter">
                                                                    <span class="tf-icons bx bx-trash"></span> Удалить
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endcan
                                                    </ul>
                                                    @endcanany
                                                </div>
                                            </div>
                                        </td>
                                        @endcanany
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

