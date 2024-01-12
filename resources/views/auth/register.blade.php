<!DOCTYPE html>
<html
    lang="ru"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Учебный центр - Интеграл</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="overflow-x: hidden">
<div class="authentication-wrapper authentication-cover">
    <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="{{Vite::asset('resources/assets/img/illustrations/girl-with-laptop-light.png')}}" class="img-fluid" alt="Login image" width="700" data-app-dark-img="illustrations/boy-with-rocket-dark.png" data-app-light-img="illustrations/boy-with-rocket-light.png">
            </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
            <div class="w-px-400 mx-auto">
                <!-- Logo -->
                <div class="app-brand mb-3">
                    <a href="{{route('login')}}" class="app-brand-link gap-2">
                        <span class="app-brand-text text-uppercase fs-3 text-body fw-bold ">Интеграл</span>
                    </a>
                </div>

                <div class="mb-3">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible show fade mt-3">
                            {!!  session('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible show fade mt-3">
                            {{session('error')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                </div>

                <!-- /Logo -->
                <h4 class="mb-2">Обучение начинается здесь 🚀</h4>
                <p class="mb-4">Введите свои учетные данные и начинайте учиться</p>

                <form action="{{route('store-user')}}" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST">
                    @csrf
                    <div class="mb-3 fv-plugins-icon-container">
                        <label for="surname" class="form-label">Фамилия</label>
                        <input type="text" class="form-control @if($errors->has('surname')) is-invalid @endif" id="surname" name="surname" placeholder="Введите свою фамилию" autofocus="" value="{{old('surname')}}">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            @if($errors->has('surname'))
                                @foreach($errors->get('surname') as $message)
                                    {{$message}}<br>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 fv-plugins-icon-container">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" placeholder="Введите свое имя" autofocus="" value="{{old('name')}}">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            @if($errors->has('name'))
                                @foreach($errors->get('name') as $message)
                                    {{$message}}<br>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 fv-plugins-icon-container">
                        <label for="patron" class="form-label">Отчетство</label>
                        <input type="text" class="form-control @if($errors->has('patron')) is-invalid @endif" id="patron" name="patron" placeholder="Введите свое отчество" autofocus="" value="{{old('patron')}}">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            @if($errors->has('patron'))
                                @foreach($errors->get('patron') as $message)
                                    {{$message}}<br>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 fv-plugins-icon-container">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" id="email" name="email" placeholder="Введите действующую электронную почту" autofocus="" value="{{old('email')}}">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            @if($errors->has('email'))
                                @foreach($errors->get('email') as $message)
                                    {{$message}}<br>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 form-password-toggle fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
{{--                        <div class="d-flex justify-content-between">--}}
                            <label class="form-label" for="password">Пароль</label>
{{--                        </div>--}}
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" placeholder="············" aria-describedby="password">
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                            @if($errors->has('password'))
                                @foreach($errors->get('password') as $message)
                                    {{$message}}<br>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 fv-plugins-icon-container">
                        <div class="form-check">
                            <input class="form-check-input @if($errors->has('terms-conditions')) is-invalid @endif" type="checkbox" id="terms-conditions" name="terms-conditions">
                            <label class="form-check-label" for="terms-conditions">
                               Я согласен с
                                <a href="#" class="@if($errors->has('terms-conditions')) text-danger @endif">политикой конфиденциальности</a>
                            </label>
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                @if($errors->has('terms-conditions'))
                                    @foreach($errors->get('terms-conditions') as $message)
                                        {{$message}}<br>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary d-grid w-100">
                        Зарегистрироваться
                    </button>
                    <input type="hidden"></form>

                <p class="text-center">
                    <span>Уже есть аккаунт?</span>
                    <a href="{{route('login')}}">
                        <span>Войти на сайт</span>
                    </a>
                </p>

            </div>
        </div>
    </div>
</div>
</body>
</html>
