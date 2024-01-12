<!DOCTYPE html>
<html
    lang="ru"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>Учебный центр - Интеграл</title>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="overflow-x: hidden">
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">

            <div class="card">
                <div class="card-body">
                    <div class="app-brand justify-content-center mt-3 mb-1">
                        <a href="{{route('login')}}" class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-body fw-bold text-uppercase">Интеграл</span>
                        </a>
                    </div>

                    <div class="">

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


                    <div class="text-center mt-3">
                        <h4 class="mb-2">Сброс пароля 🔒</h4>
                        <p class="mb-1">Электронная почта: <span class="fw-bold">{{ $email->email }}</span></p>
                        <p class="mb-4 fs-tiny fw-light">{{ $token }}</p>
                    </div>
                    <form class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('reset.password.post')}}" method="POST">
                        @csrf
                        <div class="mb-3 form-password-toggle fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                            <label class="form-label" for="password">Новый пароль</label>
                            <div class="input-group input-group-merge has-validation">
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
                        <div class="mb-3 form-password-toggle fv-plugins-icon-container fv-plugins-bootstrap5-row-valid">
                            <label class="form-label" for="password_confirmation">Повторите пароль</label>
                            <div class="input-group input-group-merge has-validation">
                                <input type="password" id="password_confirmation" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation" placeholder="············" aria-describedby="password">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                @if($errors->has('password_confirmation'))
                                    @foreach($errors->get('password_confirmation') as $message)
                                        {{$message}}<br>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="token" value="{{$token}}">
                        <input type="hidden" name="email" value="{{$email->email}}">
                        <button type="submit" class="btn btn-primary d-grid w-100">Сбросить пароль</button>
                    </form>
                    <div class="text-center">
                        <a href="{{route('login')}}" class="d-flex align-items-center justify-content-center">
                            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                            Вернуться к авторизации
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
