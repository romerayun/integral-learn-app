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
                <img src="{{Vite::asset('resources/assets/img/illustrations/boy-with-rocket-light.png')}}" class="img-fluid" alt="Login image" width="700" data-app-dark-img="illustrations/boy-with-rocket-dark.png" data-app-light-img="illustrations/boy-with-rocket-light.png">
            </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
            <div class="w-px-400 mx-auto">
                <!-- Logo -->
                <div class="app-brand mb-5">
                    <a href="{{route('login')}}" class="app-brand-link gap-2">
                        <span class="app-brand-text text-uppercase fs-3 text-body fw-bold ">Интеграл</span>
                    </a>
                </div>
                <!-- /Logo -->
                <h4 class="mb-2">Добро пожаловать! 👋</h4>
                <p class="mb-4">Введите свои учетные данные и начинайте учиться</p>

                <form id="formAuthentication" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" action="#" method="POST" novalidate="novalidate">
                    <div class="mb-3 fv-plugins-icon-container">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email-username" placeholder="Введите свою электронную почту" autofocus="">
                        <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                    <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Пароль</label>
                            <a href="auth-forgot-password-cover.html">
                                <small>Забыли пароль?</small>
                            </a>
                        </div>
                        <div class="input-group input-group-merge has-validation">
                            <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div><div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                    </div>

                    <button class="btn btn-primary d-grid w-100">
                        Войти
                    </button>
                    <input type="hidden"></form>

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
