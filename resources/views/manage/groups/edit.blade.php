@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a href="{{route('groups.index')}}" class="text-muted">Группы</a> / </span> Редактирование</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('groups.index')}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-2">Редактирование группы &laquo;{{$group->name}}&raquo;</h5>
                <p class="text-primary ms-4 me-4 mb-0">Группу можно подписать на несколько учебных программ</p>
                <div class="card-body">
                    <form action="{{route('groups.update', ['group' => $group->id])}}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div>
                                    <label for="name" class="form-label">Наименование учебной группы <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" required
                                           name="name" id="name" placeholder="Б-23-1" value="{{$group->name}}">
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


                        <div class="row mt-2">
                            <div class="col-lg-6 col-md-12">
                                <div>
                                    <label for="start_date" class="form-label">Начало обучения <sup class="text-danger">*</sup></label>
                                    <input type="text" required placeholder="ГГГГ-ММ-ДД"
                                           class="form-control bs-datepicker-format @if($errors->has('start_date')) is-invalid @endif"
                                           name="start_date" value="{{$group->start_date, date("Y-m-d")}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('start_date'))
                                            @foreach($errors->get('start_date') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div>
                                    <label for="end_date" class="form-label">Конец обучения <sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" required placeholder="ГГГГ-ММ-ДД"
                                           class="form-control bs-datepicker-format @if($errors->has('end_date')) is-invalid @endif"
                                           name="end_date" value="{{$group->end_date, date("Y-m-d")}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('end_date'))
                                            @foreach($errors->get('end_date') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label for="learning_program" class="form-label">Учебные программа(-ы) <sup
                                    class="text-danger">*</sup></label>
                            <div class="select2-primary">
                                <div class="position-relative">
                                    <select id="learning_program" required name="learning_program[]"
                                            class="select2 form-select select2-hidden-accessible"
                                            multiple
                                            data-minimum-selection-length="1"
                                            data-placeholder="Выберите учебные программы">
                                        @foreach($learningPrograms as $item)
                                            <option value="{{$item->id}}" @if(array_key_exists($item->id, $idsLP)) selected @endif>
                                                {{$item->name}}
                                            </option>
                                        @endforeach
                                    </select>
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

