@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a class="text-muted" href="{{route('final-quiz.index')}}"> Итоговое тестирование</a> / </span> Результаты тестирования</h4>



    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('final-quiz.index')}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>

            <div class="card mb-4">
                @if($finalQuiz->isActive)
                    <span class="badge bg-success">Активный</span>
                @else
                    <span class="badge bg-danger">Закрыт</span>
                @endif

                <h5 class="card-header pb-2">Результаты итогового тестирования, код доступа - {{$key}}</h5>

                <div class="card-body">

                    <p class="mb-0"><span class="text-primary fw-bold ">Дата и время создания -</span> {{\Carbon\Carbon::parse($finalQuiz->created_at)->format('d.m.Y г. / H:i')}}</p>
                    <p><span class="text-primary fw-bold ">Учебная программа -</span> {{$finalQuiz->learningProgram->name}}</p>

                    <div class="table-responsive text-nowrap">
                        @if($finalQuiz->finalQuizResult->isEmpty())
                            <p class="fw-bold mb-0">Результатов тестирования не найдено 😭</p>
                        @else
                            <table class="table table-hover table-sm" id="dataTable">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Результат</th>
                                    <th>Пользователь</th>
                                    <th>Кол-во правильных ответов</th>
                                    <th>Дата/Время окончания</th>
                                    <th>
                                        <div class="text-end pe-3">Взаимодействие</div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach($finalQuiz->finalQuizResult as $key => $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                @if (checkPassedQuiz(count(json_decode($item->answers, true)), $item->countRightAnswers))
                                                    <span class="badge bg-success">Сдан</span>
                                                @else
                                                    <span class="badge bg-danger">Не сдан</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('users.show', ['user'=>$item->user_id])}}">{{$item->user->getFullName()}}</a>
                                            </td>
                                            <td>
                                                {{$item->countRightAnswers}} / {{ count(json_decode($item->answers, true))}}
                                            </td>
                                            <td>
                                                {{\Carbon\Carbon::parse($item->created_at)->format('d.m.Y г. / H:i')}}
                                            </td>
                                            <td>
                                                <div class="text-end">

                                                    <div class="d-inline-block">
                                                        <a href="{{route('final-quiz.show-answers', ['key' => $finalQuiz->key, 'id' => $item->id])}}" class="btn btn-sm btn-icon item-edit" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Посмотреть ответы"><i class="bx bx-show"></i></a>
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


@endsection

