@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a class="text-muted" href="{{route('learning-programs.index')}}">Учебные программы</a> / </span> Редактирование</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('learning-programs.index')}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>


            <div class="card mb-4">
                <h5 class="card-header pb-2">Редактирование учебной программы &laquo;{{$lp->name}}&raquo;</h5>
                <div class="card-body">
                    <form action="{{route('learning-programs.update', ['learning_program' => $lp->id])}}" method="POST" id="form-lp" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mt-3">
                            <div class="col-md-12 col-lg-6">
                                <div>
                                    <label for="name" class="form-label">Наименование учебной программы <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" id="name" placeholder="Машинист экскаватора" value="{{$lp->name}}">
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
                                    <label for="plan" class="form-label">
                                        Рабочая программа
                                        @if(empty($lp->working_program))
                                            <span class="text-danger">(не загружена)</span>
                                        @else
                                            <span class="text-success">(загружена - <a href="{{'/storage/' . ($lp->working_program)}}" download="{{str()->slug($lp->name)}}" class="text-success"><i class="bx bx-download"></i></a>)</span>
                                        @endif
                                    </label>
                                    <input type="file" class="form-control @if($errors->has('plan')) is-invalid @endif" name="plan" id="plan">
                                    <div class="form-text text-danger" >
                                        @if($errors->has('plan'))
                                            @foreach($errors->get('plan') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <label for="ckeditor" class="form-label">Аннотация учебной программы</label>
                                <textarea name="annotation" id="ckeditor" rows="10" cols="80" required></textarea>
{{--                                <textarea id="editor" name="annotation"></textarea>--}}
{{--                                <textarea name="annotation" id="annotation" class="d-none">{!! $lp->annotation !!}</textarea>--}}
{{--                                <div id="editor"></div>--}}
{{--                                <div class="code-html tui-doc-contents">--}}
{{--                                    <div id="editor">{!! $lp->annotation !!}</div>--}}
{{--                                </div>--}}
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col">
                                <button type="submit" class="btn btn-success" id="save-lp">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

