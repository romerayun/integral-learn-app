@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление /</span> Редактор теста</h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4 mt-4">

                <div id="sticky-wrapper" class="sticky-wrapper">
                    <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                        <h5 class="card-title mb-sm-0 me-2">Редактор теста</h5>
                        <div class="action-btns">


                            <a href="{{$url ?? old('url') ?? url()->previous()}}" class="btn btn-label-primary me-2">
                                <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                            </a>


                            <a class="new-question btn btn-primary text-white me-2">
                                <i class="tf-icons bx bx-plus me-1"></i> Добавить вопрос
                            </a>

                            <a class="btn btn-success text-white" id="store-quiz">
                                <i class="tf-icons bx bx-save me-1"></i> Сохранить изменения
                            </a>

                        </div>
                    </div>
                </div>

                <div class="card-body">

                        <input type="hidden" name="url" value="{{$url ?? old('url') ?? url()->previous()}}">
                        <input type="hidden" id="activity" value="{{$id}}">



                        <ol class="list-group list-group-numbered questions-content">

                            @if(count($questions) != 0)
                                @foreach($questions as $question)


                                    <li class="list-group-item border-none question" attr-number="{{$question->id}}" attr-time="old" attr-type="{{$question->type}}">
                                        <div class="d-flex align-items-center gap-3 ms-4">
                                            <input class="form-control" type="text"  placeholder="Введите вопрос..." value="{{$question->text_question}}" attr-val="{{$question->text_question}}">
                                            <div class="controls d-flex align-items-center gap-3 flex-shrink-0">
                                                @if (!$question->image)
                                                    <form id="form-file{{$numberQuestion}}">
                                                        <input type="file" name="file{{$numberQuestion}}" id="file{{$numberQuestion}}" class="file-upload" accept="image/*" data-multiple-caption="{count} files selected">
                                                        <label for="file{{$numberQuestion}}" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Загрузить файл"><i class="tf-icons bx bx-upload"></i><span></span></label>
                                                    </form>
                                                @else
                                                    <a class="delFile d-flex flex-shrink-0 align-items-center gap-1 text-danger" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить файл" ><i class="tf-icons bx bx-x-circle"></i> <span>Файл загружен </span></a>
                                                @endif
                                                <a class="del-question" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить вопрос">
                                                    <i class="tf-icons bx bx-trash"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <ul class="answers">
                                            <div class="answers-content">
                                            @foreach($question->answers as $answer)
                                                @if ($answer->isCorrect == 1)
                                                    @php $checked = 'checked'; @endphp
                                                @else
                                                    @php $checked = ''; @endphp
                                                @endif

                                                @php $type = 'checkbox' @endphp
                                                @if($question->type === 'r') @php $type = 'radio' @endphp @endif

                                                <li attr-id="{{$answer->id}}">
                                                    <div class="input_el d-flex align-items-center gap-2">
                                                        <input class="form-check-input" type="{{$type}}" name="el{{$question->id}}" {{$checked}} attr-check="{{$checked}}" >
                                                        <input type="text" class="form-control form-control-sm" placeholder="Введите ответ..." value="{{$answer->answer}}" attr-val="{{$answer->answer}}">
                                                        <div class="controls">
                                                            <a class="del-answer" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить ответ">
                                                                <i class="tf-icons bx bx-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            </div>
                                                <div class="d-flex mt-3 mb-2">
                                                    <a class="new-answer btn btn-sm btn-primary text-white me-2"><i class="tf-icons bx bx-plus me-1"></i> Добавить ответ</a>
                                                    <a class="change-type btn btn-sm btn-primary text-white" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Изменение типа на множественный или одиночный выбор ответа"><i class="tf-icons bx bx-refresh me-1"></i> Изменить тип вопроса</a>
                                                </div>
                                        </ul>
                                    </li>



                                @endforeach

                            @else


                                <li class="list-group-item border-none question" attr-number="{{$numberQuestion}}">
                                    <div class="d-flex align-items-center gap-3 ms-4">
                                        <input class="form-control" type="text"  placeholder="Введите вопрос...">
                                        <div class="controls d-flex align-items-center gap-3">
                                            <form id="form-file{{$numberQuestion}}">
                                                <input type="file" name="file{{$numberQuestion}}" id="file{{$numberQuestion}}" class="file-upload" accept="image/*" data-multiple-caption="{count} files selected">
                                                <label for="file{{$numberQuestion}}" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Загрузить файл"><i class="tf-icons bx bx-upload"></i><span></span></label>
                                            </form>
                                            <a class="del-question" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить вопрос">
                                                <i class="tf-icons bx bx-trash"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <ul class="answers">
                                        <div class="answers-content">
                                            <li>
                                                <div class="input_el d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="checkbox" name="el{{$numberQuestion}}">
                                                    <input type="text" class="form-control form-control-sm" placeholder="Введите ответ...">
                                                    <div class="controls">
                                                        <a class="del-answer" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить ответ">
                                                            <i class="tf-icons bx bx-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="input_el d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="checkbox" name="el{{$numberQuestion}}">
                                                    <input type="text" class="form-control form-control-sm" placeholder="Введите ответ...">
                                                    <div class="controls">
                                                        <a class="del-answer" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить ответ">
                                                            <i class="tf-icons bx bx-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                        </div>
                                        <div class="d-flex mt-3 mb-2">
                                            <a class="new-answer btn btn-sm btn-primary text-white me-2"><i class="tf-icons bx bx-plus me-1"></i> Добавить ответ</a>
                                            <a class="change-type btn btn-sm btn-primary text-white" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Изменение типа на множественный или одиночный выбор ответа"><i class="tf-icons bx bx-refresh me-1"></i> Изменить тип вопроса</a>
                                        </div>
                                    </ul>
                                </li>

                            @endif

                        </ol>



                </div>
            </div>
        </div>
    </div>


@endsection

