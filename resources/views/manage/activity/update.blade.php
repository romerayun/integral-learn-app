@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a class="text-muted" href="{{route('learning-programs.index')}}">Учебные программы</a> / <a class="text-muted" href="{{route('learning-programs.show', ['learning_program' => $activity->themes[0]->learningPrograms[0]->id])}}">{{$activity->themes[0]->learningPrograms[0]->name}}</a> / </span>Активность</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{$url ?? old('url') ?? url()->previous()}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>


            <div class="card mb-4">
                <h5 class="card-header pb-2">Редактирование активности</h5>
                <div class="card-body">
                    <form action="{{route('activity.update', ['activity' => $activity->id])}}" method="POST" class="quill-form" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="url" value="{{$url ?? old('url') ?? url()->previous()}}">
                        <input type="hidden" name="theme_id" value="0">
                        <div class="row mt-2">

                            <div class="col-lg-12 col-md-12">
                                <div>
                                    <label for="type_id" class="form-label">Выберите тип активности<sup class="text-danger">*</sup></label>
                                    <select id="type_id" name="type_id" class="select2 form-select @if($errors->has('type_id')) is-invalid @endif">
                                        @foreach($activityTypes as $item)
                                            @if ($activity->type_id == $item->id)
                                                <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                            @else
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="form-text text-danger">
                                        @if($errors->has('type_id'))
                                            @foreach($errors->get('type_id') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col-md-12 col-lg-6">
                                <div>
                                    <label for="name" class="form-label">Наименование активности <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" id="name" placeholder="Введение" value="{{$activity->name}}" required>
                                    <div class="form-text text-danger" >
                                        @if($errors->has('name'))
                                            @foreach($errors->get('name') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div>
                                    <label for="count_hours" class="form-label">Введите количество часов<sup class="text-danger">*</sup> <span class="text-info"> (1 ак. час = 45 минут)</span></label>
                                    <input type="number" class="form-control @if($errors->has('count_hours')) is-invalid @endif" name="count_hours" id="count_hours" placeholder="2" value="{{$activity->count_hours}}" step="1" min="1" required>
                                    <div class="form-text text-danger" >
                                        @if($errors->has('count_hours'))
                                            @foreach($errors->get('count_hours') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="content" class="form-label">Контент активности</label>
                                <div class="quill">{!! $activity->content !!}</div>
                                <input type="hidden" name="content" id="quill-html" value="{!! $activity->content !!}">
                            </div>
                        </div>

                        <div class="row mt-2">
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

