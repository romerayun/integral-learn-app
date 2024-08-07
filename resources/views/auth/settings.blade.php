@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0">Редактирование профиля</h4>

    <div class="row">
        <div class="col-md-12">



            <div class="card mb-4">
                <h5 class="card-header pb-2">Добавление аватара профиля</h5>
                <div class="card-body">


                        <div class="row mt-3">
                            <div class="col-md-12 col-lg-10">
                                <form action="{{route('user.store-avatar')}}" method="POST" id="form-editor" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <label for="avatar" class="form-label">Выберите изображение <span class="text-info">(рекомендуемые пропорции 1:1)</span></label>
                                        <input type="file" accept="image/*" class="form-control @if($errors->has('avatar')) is-invalid @endif" name="avatar" id="avatar" value="{{old('avatar')}}">
                                        <div class="form-text text-danger" >
                                            @if($errors->has('avatar'))
                                                @foreach($errors->get('avatar') as $message)
                                                    {{$message}}<br>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success" id="save">Сохранить</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 col-lg-2 text-center">
                                @if(!auth()->user()->avatar)
                                    <img class="img-fluid w-75" src="{{ Vite::asset('resources/assets/img/no-image.jpeg') }}" alt="Avatar profile">
                                @else
                                    <div class="position-relative w-100 m-auto">
                                        <img class="img-fluid w-100" src="{{ asset('/storage/' . auth()->user()->avatar)}}" alt="Avatar profile">

                                        <form action="{{route('user.destroy-avatar')}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="del-absolute-link">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </form>
                </div>
            </div>


            <div class="card mb-4">
                <h5 class="card-header pb-2">Добавление обложки профиля</h5>
                <div class="card-body">


                        <div class="row mt-3">

                            <div class="col-md-12 col-lg-10">
                                <form action="{{route('user.store-banner')}}" method="POST" id="form-editor" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <label for="banner" class="form-label">Выберите изображение <span class="text-info">(рекомендуемые пропорции 16:9)</span></label>
                                        <input type="file" accept="image/*" class="form-control @if($errors->has('banner')) is-invalid @endif" name="banner" id="banner" value="{{old('banner')}}">
                                        <div class="form-text text-danger" >
                                            @if($errors->has('banner'))
                                                @foreach($errors->get('banner') as $message)
                                                    {{$message}}<br>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col">
                                            <button type="submit" class="btn btn-success" id="save">Сохранить</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 col-lg-2 text-center">
                                @if(!auth()->user()->banner)
                                    <img class="img-fluid w-75" src="{{ Vite::asset('resources/assets/img/no-image.jpeg') }}" alt="Banner profile">
                                @else
                                    <div class="position-relative w-100">
                                        <img class="img-fluid w-100" src="{{ asset('/storage/' . auth()->user()->banner)}}" alt="Banner profile">
                                        <form action="{{route('user.destroy-banner')}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="del-absolute-link">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>


@endsection

