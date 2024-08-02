@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light"><a class="text-muted" href="{{route('learning-program.my')}}">Мои учебные программы</a> /  <a class="text-muted" href="{{route('learning-program.showDetails', ['learning_program' => $lp->id])}}">{{$lp->name}}</a> /</span> {{$activity->name}}</h4>

    <div class="card g-3 mt-3">
        <div class="card-body row g-3">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="fw-bold mb-0 fs-5"><span class="fw-bold">Активность:</span> {{$activity->name}}</p>
                    <div class="d-flex align-items-center mt-2">
                        <span class="badge bg-label-{{$activity->type->color}} activity-type">{{$activity->type->name}}</span>
                        <span class="activity-hours">{{$activity->count_hours}}</span>
                    </div>
                </div>
                @php $completeActivity = checkCompleteActivity($lp->id, $theme->id, $activity->id) @endphp
                @if($completeActivity)
                    <span class="text-primary fw-bold">Активность завершена 🥳</span>
                @else
                    @if($activity->type->id != getIdTypeQuiz())
                        <form action="{{route('learning_program.complete', [
                            'learning_program' => $lp->id,
                            'theme_id' => $theme->id,
                            'activity_id' => $activity->id,
                        ])}}" method="POST" class="mt-0">
                            @csrf
                            <button type="submit" class="btn btn-success" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Завершить активность">
                                <span class="tf-icons bx bx-check-double me-1"></span> Завершить активность
                            </button>
                        </form>
                    @endif
                @endif
            </div>

            <div class="divider text-start mt-4">
                <div class="divider-text">Содержание активности</div>
            </div>

            <div class="content">
                {!! $activity->content!!}
            </div>

            @if($activity->type->id == getIdTypeQuiz())


                @if ($activity->results->count() != 0)

                    <a class="btn btn-primary mt-0 collapsed w-auto ms-2 mt-2" data-bs-toggle="collapse" href="#resultQuiz" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Открыть результаты тестирования
                    </a>

                    <div class="collapse pb-3" id="resultQuiz">

                        <p><b>Количество попыток: </b> {{$activity->results->count()}}</p>
                        <div class="table-responsive text-nowrap mt-0 mb-3">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Результативность</th>
                                        <th>Дата прохождения</th>
                                    </tr>
                                </thead>
                                @php $i = 1; @endphp
                            @foreach($activity->results as $result)
                                @php $resultPercent = round($result->countRightAnswers / $activity->questions->count() * 100) @endphp
                                <tr class="table-{{getColorQuiz($resultPercent)}}">
                                    <td>{{$i++}}</td>
                                    <td><span class="text-primary">Результат: <b>{{$resultPercent}}%</b></span> ({{$result->countRightAnswers}} / {{$activity->questions->count()}}) </td>
                                    <td>{{\Carbon\Carbon::make($result->created_at)->format('d.m.Y H:i:s')}}</td>
                                </tr>
                            @endforeach
                            </table>
                        </div>
                    </div>
                @endif

                @if($activity->questions->count() != 0 && !$completeActivity)
                    <form method="POST" id="quizForm" action="{{route('learning-program.storeQuiz', ['learning_program' => $lp->id, 'theme' => $theme->id, 'activity' => $activity->id])}}">
                        @csrf
                        <ol class="question-item">
                        @foreach($activity->questions->shuffle() as $question)
                            <li class="question" attr-number="{{$question->id}}">{{$question->text_question}}
                            @if ($question->image)
                                    <a href="{{asset('storage/'.$question->image)}}" data-lightbox="gallery{{$question->id}}">
                                        <img src='{{asset('storage/'.$question->image)}}' alt='{{$question->name}}' class="d-block mt-2 mb-3 w-px-75" >
                                    </a>
    {{--                        printf("<a data-lightbox='image-%s' data-title='%s' href='/uploadFiles/olympiads/%s'>--}}
    {{--                            <img src='/uploadFiles/olympiads/%s' alt='%s'>--}}
    {{--                        </a>", $question['idQuestion'], $question['question'], $question['filePath'],  $question['filePath'], $question['question']);--}}
                                @endif

                            <ul class="answer">
                                <input type="hidden" name="answers[{{$question->id}}][question_id]" value="{{$question->id}}">
                                @foreach ($question->answers as $answer)

                                    @if($question->type = 'c')
                                        <li>
                                            <div class="input_el d-flex align-items-center gap-2">
                                                <label>
                                                    <input class="form-check-input" type="checkbox" name="answers[{{$question->id}}][answers][]" id="c{{$question->id}}" value="{{$answer->id}}">
                                                    <span>{{$answer->answer}}</span>
                                                </label>
                                            </div>
                                        </li>
                                    @else
                                        <li>
                                            <div class="input_el d-flex align-items-center gap-2">
                                                <label>
                                                    <input class="form-check-input" type="radio" name="answers[{{$question->id}}][answers][]"  id="r{{$question->id}}" value="{{$answer->id}}">
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

                @endif
            @endif



            <div class="d-flex justify-content-between align-items-center mt-4">

                <div>
                    @php $prevAct = prevActivity($lp->id, $theme->id, $activity->id); @endphp
                    @if($prevAct)
                        @if(prevActivity($lp->id, $theme->id, $activity->id))
                            <a href="{{route('learning-program.showActivity', ['learning_program' => $lp->id, 'theme' => $prevAct->themes->first()->id, 'activity' => $prevAct->id])}}" class="btn btn-sm btn-outline-primary">
                                <span class="tf-icons bx bx-chevron-left me-1"></span> Предыдущая активность
                            </a>
                        @endif
                    @endif
                </div>

                <div>
                    @php
                        $nextAct = nextActivity($lp->id, $theme->id, $activity->id);
                        $checkActivity = checkCompleteActivity($lp->id, $theme->id, $activity->id);
                    @endphp
                    @if($nextAct)
                        <a href="@if(!$checkActivity)#@else{{route('learning-program.showActivity', ['learning_program' => $lp->id, 'theme' => $nextAct->themes->first()->id, 'activity' => $nextAct->id])}}@endif" class="btn btn-sm @if(!$checkActivity) isDisabled btn-outline-secondary @else btn-outline-primary @endif" @if(!$checkActivity) data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Для перехода к следующей активности, завершите текущую" @endif>
                            Следующая активность <span class="tf-icons bx bx-chevron-right"></span>
                        </a>
                    @endif
                </div>

            </div>


        </div>
    </div>
@endsection

