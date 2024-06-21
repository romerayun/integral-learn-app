@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a href="{{route('users.index')}}" class="text-muted">Пользователи</a> / </span> Добавление</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('users.index')}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>

            <div class="card mb-4">
                <h5 class="card-header pb-2">Добавление нового пользователя</h5>
                <p class="text-primary ms-4 me-4 mb-0">Для всех новых пользователей будет сгенерирован пароль и отправлен на электронную почту, данный пароль можно будет поменять в личном кабинете</p>
                <div class="card-body">
                    <form action="{{route('users.store')}}" method="POST">
                        @csrf


{{--                        <div class="row">--}}
{{--                            <div class="col-12">--}}
{{--                                <div class="d-flex gap-3">--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input name="role_id" class="form-check-input" value="1" type="radio" checked>--}}
{{--                                        <label class="form-check-label" for="role">--}}
{{--                                            Администратор--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input name="role_id" class="form-check-input" value="2" type="radio">--}}
{{--                                        <label class="form-check-label" for="role">--}}
{{--                                            Преподаватель--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input name="role_id" class="form-check-input" value="3" type="radio">--}}
{{--                                        <label class="form-check-label" for="role">--}}
{{--                                            Студент--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <label for="learning_program" class="form-label">Выберите роль пользователя</label>
                                <div class="select2-primary">
                                    <div class="position-relative">
                                        <select id="role_id" required name="role_id"
                                                class="select2 form-select select2-hidden-accessible @if($errors->has('role_id')) is-invalid @endif"
                                                data-minimum-selection-length="1"
                                                data-placeholder="Выберите роль пользователя">
                                            @foreach($roles as $item)
                                                <option value="{{$item->id}}">
                                                    {{$item->nameRU}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-text text-danger">
                                    @if($errors->has('role_id'))
                                        @foreach($errors->get('role_id') as $message)
                                            {{$message}}<br>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div>
                                    <label for="email" class="form-label">Электронная почта <sup class="text-danger">*</sup></label>
                                    <input type="email" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" id="email" placeholder="info@test.ru" value="{{old('email')}}">
                                    <div class="form-text text-danger" >
                                        @if($errors->has('email'))
                                            @foreach($errors->get('email') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-md-12 col-lg-4">
                                <div>
                                    <label for="surname" class="form-label">Фамилия <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('surname')) is-invalid @endif" name="surname" id="surname" placeholder="Иванов" value="{{old('surname')}}">
                                    <div class="form-text text-danger" >
                                        @if($errors->has('surname'))
                                            @foreach($errors->get('surname') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <div>
                                    <label for="name" class="form-label">Имя <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" id="name" placeholder="Иван" value="{{old('name')}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('name'))
                                            @foreach($errors->get('name') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <div>
                                    <label for="patron" class="form-label">Отчество <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('patron')) is-invalid @endif" name="patron" id="patron" placeholder="Иванович" value="{{old('patron')}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('patron'))
                                            @foreach($errors->get('patron') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-lg-4 col-md-12">
                                <div>
                                    <label for="series_passport" class="form-label">Серия паспорта <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('series_passport')) is-invalid @endif" name="series_passport" id="series_passport" placeholder="XXXX" value="{{old('series_passport')}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('series_passport'))
                                            @foreach($errors->get('series_passport') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div>
                                    <label for="number_passport" class="form-label">Номер паспорта <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('number_passport')) is-invalid @endif" name="number_passport" id="number_passport" placeholder="XXXXXX" value="{{old('number_passport')}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('number_passport'))
                                            @foreach($errors->get('number_passport') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div>
                                    <label for="date_of_birth" class="form-label">Дата рождения <sup class="text-danger">*</sup></label>
                                    <input type="text" placeholder="ГГГГ-ММ-ДД" class="form-control bs-datepicker-format @if($errors->has('date_of_birth')) is-invalid @endif" name="date_of_birth" value="{{old('date_of_birth', date("Y-m-d"))}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('date_of_birth'))
                                            @foreach($errors->get('date_of_birth') as $message)
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
                                    <label for="snils" class="form-label">СНИЛС</label>
                                    <input type="text" class="form-control @if($errors->has('snils')) is-invalid @endif" name="snils" id="snils" placeholder="XXX-XXX-XXX XX" value="{{old('snils')}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('snils'))
                                            @foreach($errors->get('snils') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div>
                                    <label for="phone" class="form-label">Номер телефона <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control @if($errors->has('phone')) is-invalid @endif" name="phone" id="phone" placeholder="+7(XXX)XXX-XX-XX" value="{{old('phone')}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('phone'))
                                            @foreach($errors->get('phone') as $message)
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
                                    <label for="sex" class="form-label">Пол</label>
                                    <select id="sex" name="sex" class="select2 form-select @if($errors->has('sex')) is-invalid @endif">
                                        <option value="M" @if(old('sex') == "M") selected @endif>Мужской</option>
                                        <option value="F" @if(old('sex') == "F") selected @endif>Женский</option>
                                    </select>
                                    <div class="form-text text-danger">
                                        @if($errors->has('sex'))
                                            @foreach($errors->get('sex') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div>
                                    <label for="country" class="form-label">Гражданство</label>
                                    <input type="text" class="form-control @if($errors->has('country')) is-invalid @endif" name="country" id="country" placeholder="Россия" value="{{old('country')}}">
                                    <input type="hidden" name="nationality" id="nationality" value="{{old('nationality')}}">
                                    <div class="form-text text-danger">
                                        @if($errors->has('country'))
                                            @foreach($errors->get('country') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
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

