@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление /</span> Типы активностей</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('activity-types.index')}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-2">Добавление нового типа активности</h5>
                <div class="card-body">
                    <form action="{{route('activity-types.store')}}" method="POST">
                        @csrf

                        <div class="row mt-3">
                            <label for="name" class="form-label">Выберите цвет отображения активности<sup
                                    class="text-danger">*</sup></label>
                            <div class="flex">
                                <div class="form-check form-check-primary">
                                    <input class="form-check-input" type="radio" name="color" id="color" checked="" value="primary">
                                </div>
                                <div class="form-check form-check-dark">
                                    <input class="form-check-input" type="radio" name="color" id="color" value="dark">
                                </div>
                                <div class="form-check form-check-info">
                                    <input class="form-check-input" type="radio" name="color" id="color" value="info">
                                </div>
                                <div class="form-check form-check-warning">
                                    <input class="form-check-input" type="radio" name="color" id="color" value="warning">
                                </div>
                                <div class="form-check form-check-danger">
                                    <input class="form-check-input" type="radio" name="color" id="color" value="danger">
                                </div>
                                <div class="form-check form-check-success">
                                    <input class="form-check-input" type="radio" name="color" id="color" value="success">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-12 col-lg-12">
                                <div>
                                    <label for="name" class="form-label">Наименование активности <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" required
                                           name="name" id="name" placeholder="Лекция / Практика" value="{{old('name')}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('name'))
                                            @foreach($errors->get('name') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
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

