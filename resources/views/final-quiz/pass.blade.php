@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0">Итоговое тестирование - код доступа: {{$key}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                @if($finalQuiz == null)
                    <h5 class="card-header ">К сожалению, по данному коду доступа итогового тестирования не найдено 😢</h5>
                    <div class="card-body mb-0">
                        <div class="d-flex">
                            <a href="{{route('final-quiz.getFinalQuiz')}}" class="btn btn-primary ">
                                <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Вернуться обратно
                            </a>
                        </div>
                    </div>
                @else


                        @if($result && checkPassedQuiz(count(json_decode($result->answers, true)), $result->countRightAnswers))
                            <h5 class="card-header ">Итоговое тестирование успешно завершено 🥳</h5>
                            <div class="card-body mb-0">
                                <div class="d-flex">
                                    <a href="{{route('final-quiz.getFinalQuiz')}}" class="btn btn-primary ">
                                        <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Вернуться обратно
                                    </a>
                                </div>
                            </div>
                        @else
                        <div class="card-body">

                            @php $finalQuizF = getFinalQuizByLearningProgram($finalQuiz->learning_program_id, $finalQuiz->countQuestions); @endphp

                            @if(!is_array($finalQuizF['keys']))
                                @php $finalQuizF['keys'] = array($finalQuizF['keys']); @endphp
                            @endif


                            <form method="POST" id="quizForm" action="{{route('final-quiz.storeFinalQuiz', ['key' => $key])}}" class="mt-3">
                                @csrf

                                <input type="hidden" name="final_quiz_id" value="{{$finalQuiz->id}}">
                                <input type="hidden" name="learning_program_id" value="{{$finalQuiz->learning_program_id}}">

                                <ol class="question-item">
                                    @foreach($finalQuizF['keys'] as $key)
                                        <li class="question" attr-number="{{$finalQuizF['questions'][$key]->id}}">{{$finalQuizF['questions'][$key]->text_question}}
                                            @if ($finalQuizF['questions'][$key]->image)
                                                <a href="{{asset('storage/'.$finalQuizF['questions'][$key]->image)}}" data-lightbox="gallery{{$finalQuizF['questions'][$key]->id}}">
                                                    <img src='{{asset('storage/'.$finalQuizF['questions'][$key]->image)}}' alt='{{$finalQuizF['questions'][$key]->name}}' class="d-block mt-2 mb-3 w-px-75" >
                                                </a>
                                            @endif

                                            <ul class="answer">
                                                <input type="hidden" name="answers[{{$finalQuizF['questions'][$key]->id}}][question_id]" value="{{$finalQuizF['questions'][$key]->id}}">
                                                @foreach ($finalQuizF['questions'][$key]->answers as $answer)

                                                    @if($finalQuizF['questions'][$key]->type = 'c')
                                                        <li>
                                                            <div class="input_el d-flex align-items-center gap-2">
                                                                <label>
                                                                    <input class="form-check-input" type="checkbox" name="answers[{{$finalQuizF['questions'][$key]->id}}][answers][]" id="c{{$finalQuizF['questions'][$key]->id}}" value="{{$answer->id}}">
                                                                    <span>{{$answer->answer}}</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <div class="input_el d-flex align-items-center gap-2">
                                                                <label>
                                                                    <input class="form-check-input" type="radio" name="answers[{{$finalQuizF['questions'][$key]->id}}][answers][]"  id="r{{$finalQuizF['questions'][$key]->id}}" value="{{$answer->id}}">
                                                                    <span>{{$answer->answer}}</span>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ol>
                                <input type="submit" class="btn btn-success mt-3" id="finishQuiz" value="Сохранить результаты">
                            </form>


                        </div>
                        @endif
                   @endif


            </div>
        </div>
    </div>


@endsection

