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
                        <h4 class="mb-2">Подтверждение электронной почты ✅</h4>
                        <p class="mb-4">Введите адрес своей электронной почты и мы отправим Вам ссылку для подтверждения</p>
                    </div>
                    <form id="formAuthentication" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" action="{{route('registration.repeatEmailPost')}}" method="POST">
                        @csrf
                        <div class="mb-3 fv-plugins-icon-container">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" id="email" name="email" placeholder="Введите адрес электронной почты" autofocus="" value="{{old('email')}}">
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                @if($errors->has('email'))
                                    @foreach($errors->get('email') as $message)
                                        {{$message}}<br>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100">Отправить ссылку для подтверждения</button>
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
