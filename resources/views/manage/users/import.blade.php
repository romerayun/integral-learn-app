@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a href="{{route('users.index')}}" class="text-muted">Пользователи</a> / </span> Импорт</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('users.index')}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-2">Импорт пользователей</h5>
                <p class="text-primary ms-4 me-4 mb-0">Для импорта данных необходимо <a href="#" class="fw-bold text-decoration-underline">скачать шаблон</a>, заполнить файл необходимыми данными и загрузить на сайт</p>
                <div class="card-body">
                    <form action="{{route('users.importPost')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="file" class="form-label">Прикрепите файл в формате (*.xlsx)</label>
                            <input class="form-control @if($errors->has('file')) is-invalid @endif" type="file" id="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            <div class="form-text text-danger">
                                @if($errors->has('file'))
                                    @foreach($errors->get('file') as $message)
                                        {{$message}}<br>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <button type="submit" class="btn btn-success">Импортировать данные</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection

