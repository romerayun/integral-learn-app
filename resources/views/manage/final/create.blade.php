@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a class="text-muted" href="{{route('final-quiz.index')}}"> Итоговое тестирование</a> / </span> Создание</h4>



    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('final-quiz.index')}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-2">Создание итогового тестирования</h5>
                <div class="card-body">
                    <form action="{{route('final-quiz.store')}}" method="POST">
                        @csrf

                        <div class="row mt-2">
                            <label for="learning_program_id" class="form-label">Выберите учебную программу <sup
                                    class="text-danger">*</sup></label>
                            <div class="select2-primary">
                                <div class="position-relative">
                                    <select id="learning_program_final_quiz" required name="learning_program_id"
                                            class="select2 form-select select2-hidden-accessible"
                                            data-minimum-selection-length="1"
                                            data-placeholder="Выберите учебную программу">
                                        <option value="0">Не выбрано</option>
                                        @foreach($learningPrograms as $item)
                                            <option value="{{$item->id}}">
                                                {{$item->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 d-none count-questions-block">
                            <div>
                                <p class="info-count-questions mt-3 mb-2">Вопросов в учебной программе - <span class="fw-bold">0</span></p>

                                <label for="count-questions" class="form-label">Введите кол-во вопросов для итогового тестирования <sup
                                    class="text-danger">*</sup></label>
                                <input type="number" class="form-control @if($errors->has('count-questions')) is-invalid @endif" required
                                   name="countQuestions" id="count-questions" placeholder="Количество вопросов (максимум - 0)" value="{{old('name')}}">
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


@endsection

