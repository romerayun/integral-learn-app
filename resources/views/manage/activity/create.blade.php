@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a class="text-muted" href="{{route('learning-programs.index')}}">Учебные программы</a> / <a class="text-muted" href="{{route('learning-programs.show', ['learning_program' => $lp->id])}}">{{$lp->name}}</a> / </span>Активность</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{$url ?? old('url') ?? url()->previous()}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>


            <div class="card mb-4">
                <h5 class="card-header pb-2">Добавление новой активности</h5>
                <div class="card-body">
                    <form action="{{route('activity.store')}}" method="POST" id="form-editor" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="url" value="{{$url ?? old('url') ?? url()->previous()}}">
                        @if(isset($idTheme))
                            <input type="hidden" name="theme_id" value="{{$idTheme}}">
                        @endif

                        <div class="row mt-2">
                            @if (!isset($idTheme))
                            <div class="col-lg-6 col-md-12">
                                <div>
                                    <label for="theme_id" class="form-label">Выберите тему, в которую хотите добавить активность<sup class="text-danger">*</sup></label>
                                    <select id="theme_id" name="theme_id" class="select2 form-select @if($errors->has('theme_id')) is-invalid @endif">
                                        @foreach($lp->themes as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text text-danger">
                                        @if($errors->has('theme_id'))
                                            @foreach($errors->get('theme_id') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="@if (isset($idTheme)) col-lg-12 @else col-lg-6 @endif col-md-12">
                                <div>
                                    <label for="type_id" class="form-label">Выберите тип активности<sup class="text-danger">*</sup></label>
                                    <select id="type_id" name="type_id" class="select2 form-select @if($errors->has('type_id')) is-invalid @endif">
                                        @foreach($activityTypes as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
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
                                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" id="name" placeholder="Введение" value="{{old('name')}}" required>
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
                                    <input type="number" class="form-control @if($errors->has('count_hours')) is-invalid @endif" name="count_hours" id="count_hours" placeholder="2" value="{{old('count_hours')}}" step="1" min="1" required>
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
                                <label for="ckeditor" class="form-label">Контент активности</label>
                                <textarea name="content" id="ckeditor" rows="10" cols="80" required></textarea>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-success" id="save">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

