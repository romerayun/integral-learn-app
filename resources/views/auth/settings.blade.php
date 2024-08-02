@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0">Редактирование профиля</h4>

    <div class="row">
        <div class="col-md-12">



            <div class="card mb-4">
                <h5 class="card-header pb-2">Добавление аватара профиля</h5>
                <div class="card-body">
                    <form action="{{route('user.store-avatar')}}" method="POST" id="form-editor" enctype="multipart/form-data">
                        @csrf

                        <div class="row mt-3">
                            <div class="col-md-12 col-lg-10">
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
                            </div>
                            <div class="col-md-12 col-lg-2 text-center">
                                @if(!auth()->user()->avatar)
                                    <img class="img-fluid w-75" src="{{ Vite::asset('resources/assets/img/no-image.jpeg') }}" alt="Avatar profile">
                                @else
                                    <div class="position-relative">
                                        <img class="img-fluid w-75" src="{{ asset('/storage/' . auth()->user()->avatar)}}" alt="Avatar profile">
                                    </div>
                                @endif
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

