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
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="{{Vite::asset('resources/assets/img/illustrations/boy-with-rocket-light.png')}}" class="img-fluid" alt="Login image" width="700" data-app-dark-img="illustrations/boy-with-rocket-dark.png" data-app-light-img="illustrations/boy-with-rocket-light.png">
            </div>
        </div>

        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
            <div class="w-px-400 mx-auto">

                <div class="app-brand mb-5">
                    <a href="{{route('login')}}" class="app-brand-link gap-2">
                        <span class="app-brand-text text-uppercase fs-3 text-body fw-bold ">Интеграл</span>
                    </a>
                </div>

                <h4 class="mb-2">Добро пожаловать! 👋</h4>
                <p class="mb-2">Введите свои учетные данные и начинайте учиться</p>

                <div class="mb-3">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible show fade mt-3">
                            {!!  session('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible show fade mt-3">
                            {!!  session('error') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                </div>


                <form id="formAuthentication" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('post-login')}}" method="POST" novalidate="novalidate">
                    @csrf
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
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Пароль</label>
                            <a href="{{route('forgot')}}">
                                <small>Забыли пароль?</small>
                            </a>
                        </div>
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


                    <button class="btn btn-primary d-grid w-100">
                        Войти
                    </button>
                </form>

                <p class="text-center">
                    <span>Впервые на нашем сайте?</span>
                    <a href="{{route('registration')}}">
                        <span>Создайте аккаунт</span>
                    </a>
                </p>

            </div>
        </div>
    </div>
</div>
</body>
</html>
