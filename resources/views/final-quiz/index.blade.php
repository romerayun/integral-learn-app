@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0">Итоговое тестирование</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">

                <div class="card-body">
                    <form action="{{route('final-quiz.getFinalQuizPost')}}" method="POST">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-md-12 col-lg-12">
                                <div>
                                    <label for="key" class="form-label">Введите код доступа для прохождения итогового тестирования <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" required
                                           name="key" id="key" placeholder="...">
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-success">Подтвердить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

