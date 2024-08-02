@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a class="text-muted" href="{{route('final-quiz.index')}}"> Итоговое тестирование</a> /  <a class="text-muted" href="{{route('final-quiz.show-results', ['key' => $key])}}">Результаты тестирования</a> /</span> Ответы</h4>



    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('final-quiz.show-results', ['key' => $key])}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-2">Ответы пользователя - {{$finalQuizResult->user->getFullName()}}</h5>

                <div class="card-body">

                    <p class="mb-0"><span class="text-primary fw-bold ">Дата и время завершения тестирования -</span> {{\Carbon\Carbon::parse($finalQuizResult->created_at)->format('d.m.Y г. / H:i')}}</p>
                    <p><span class="text-primary fw-bold ">Учебная программа -</span> {{$finalQuiz->learningProgram->name}}</p>

                    <p class="text-primary fw-bold">Результаты тестирования: </p>

{{--                    @php dump(json_decode($finalQuizResult->answers, true)); dd() @endphp--}}
                    @foreach(json_decode($finalQuizResult->answers, true) as $answer)

                        @php $question = getQuestionById($answer['question_id']) @endphp
                        <ol>
                            <li>{{$question->text_question}}</li>
                            <ol class="answers">
                                @php $countRightAnswers = 0; @endphp
                                @php $countRightAnswersUser = 0; @endphp
                                @foreach($question->answers as $a)
                                    @if($a->isCorrect)
                                        @php $classLi = "correct"; $countRightAnswers++; @endphp
                                    @else
                                        @php $classLi = "incorrect"; @endphp
                                    @endif

                                    @php $res = ""; @endphp

                                    @foreach($answer['answers'] as $userAnswer)
                                        @if($userAnswer == $a->id)
                                            @php $res = "✅"; @endphp
                                            @if($a->isCorrect) @php $countRightAnswersUser++ @endphp @endif
                                        @endif
                                    @endforeach

                                    <li class="{{$classLi}}">{{$a->answer}} {{$res}}</li>
                                @endforeach
                            </ol>


                            @if(($countRightAnswers != $countRightAnswersUser) || ($countRightAnswers != count($answer['answers'])))
                                <p class="fw-bold text-danger">Ответ неверный</p>
                            @else
                                <p class="fw-bold text-success">Ответ верный</p>
                            @endif
                            @if(!$loop->last)
                                <hr>
                            @endif
                        </ol>

                    @endforeach

                    <p class="fs-5 mt-4 mb-0 ps-3">
                        <span class="text-primary fw-bold">Итоговый результат:</span> {{$finalQuizResult->countRightAnswers}}/{{count(json_decode($finalQuizResult->answers, true))}}
                    </p>

                </div>
            </div>
        </div>


@endsection

