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
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{route('main')}}" class="app-brand-link">
                    <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">Интеграл</span>
                </a>

                <a class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">


                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Мое обучение</span>
                </li>

                <li class="menu-item">
                    <a href="{{route('learning-program.my')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-graduation"></i>
                        <div data-i18n="Студенты">Мои учебные программы</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{route('final-quiz.getFinalQuiz')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-customize"></i>
                        <div data-i18n="Студенты">Итоговое тестирование</div>
                    </a>
                </li>



                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Администрирование</span>
                </li>

                <li class="menu-item">
                    <a href="{{route('users.index')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-user"></i>
                        <div>Пользователи</div>
                    </a>
                </li>

                @role('super-user')
                <li class="menu-item">
                    <a href="{{route('roles.index')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-low-vision"></i>
                        <div>Роли пользователей</div>
                    </a>
                </li>
                @endrole

                <li class="menu-item">
                    <a href="{{route('groups.index')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-group"></i>
                        <div data-i18n="Студенты">Группы</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{route('learning-programs.index')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-graduation"></i>
                        <div data-i18n="Студенты">Учебные программы</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{route('activity-types.index')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-extension"></i>
                        <div data-i18n="Студенты">Типы активностей</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{route('final-quiz.index')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-customize"></i>
                        <div data-i18n="Студенты">Итоговое тестирование</div>
                    </a>
                </li>


                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Настройки</span>
                </li>

                <li class="menu-item">
                    <a href="{{route('user.profile-settings')}}" class="menu-link">
                        <i class='menu-icon bx bxs-cog' ></i>
                        <div data-i18n="Студенты">Редактирование профиля</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{route('logout')}}" class="menu-link">
                        <i class="menu-icon bx bx-power-off me-2"></i>
                        <div data-i18n="Студенты">Выход</div>
                    </a>
                </li>

{{--                <li class="menu-item">--}}
{{--                    <a class="menu-link menu-toggle">--}}
{{--                        <i class="menu-icon tf-icons bx bx-layout"></i>--}}
{{--                        <div data-i18n="Приемная кампания">Приемная кампания</div>--}}
{{--                    </a>--}}

{{--                    <ul class="menu-sub">--}}
{{--                        <li class="menu-item">--}}
{{--                            <a href="{{route('speciality.index')}}" class="menu-link">--}}
{{--                                <div data-i18n="Специальности">Специальности</div>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="menu-item">--}}
{{--                            <a href="{{route('study-groups.index')}}" class="menu-link">--}}
{{--                                <div data-i18n="Учебные группы">Учебные группы</div>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

            </ul>
        </aside>

        <div class="layout-page">

            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <p class="mb-0">👋🏻 Здравствуйте, <span>{{auth()->user()->name}} {{auth()->user()->patron}}</span></p>
                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online w-px-40 h-px-40">
                                    @if(!auth()->user()->avatar)
                                        <img class="img-fluid object-fit-cover rounded-circle " src="{{ Vite::asset('resources/assets/img/no-image.jpeg') }}" alt="Avatar profile">
                                    @else
                                        <img class="img-fluid object-fit-cover rounded-circle " src="{{ asset('/storage/' . auth()->user()->avatar)}}" alt="Avatar profile">
                                    @endif
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online w-px-40 h-px-40 ">
                                                    @if(!auth()->user()->avatar)
                                                        <img class="img-fluid object-fit-cover rounded-circle " src="{{ Vite::asset('resources/assets/img/no-image.jpeg') }}" alt="Avatar profile">
                                                    @else
                                                        <img class="img-fluid object-fit-cover rounded-circle " src="{{ asset('/storage/' . auth()->user()->avatar)}}" alt="Avatar profile">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block">{{auth()->user()->surname}} {{auth()->user()->name}}</span>
                                                @foreach(auth()->user()->roles as $item)
                                                    <small class="text-muted">{{$item->nameRU}}</small>
                                                @endforeach
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{route('user.profile-settings')}}">
                                        <i class="bx bx-cog me-2"></i>
                                        <span class="align-middle">Настройки</span>
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{route('logout')}}">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Выйти</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>

            <div class="container-xxl mt-3">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible show fade mt-3">
                        {!! session('success') !!}
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

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y pt-0">
                    @yield('content')
                </div>
                <div class="content-backdrop fade"></div>
            </div>

        </div>

    </div>

    <div class="layout-overlay layout-menu-toggle"></div>


</div>

<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="modalCenterTitle">Подтверждение действия</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body text-center pb-0 pt-4">
                <h3>Удалить выбранные данные?</h3>
                <p class="text-muted">Удаление может привести к нарушению целостности данных</p>
            </div>
            <div class="modal-footer justify-content-center mt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Закрыть
                </button>
                <button type="button" class="btn btn-danger confirm-delete">Удалить</button>
            </div>
        </div>
    </div>
</div>

<div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 hide" id="liveToast" role="alert"
     aria-live="assertive" aria-atomic="true" data-delay="2000">
    <div class="toast-header">
        <i class="bx bx-error me-2"></i>
        <div class="me-auto fw-semibold toast-title"></div>

        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">Пожалуйста, заполните все поля</div>
</div>


<script src="{{asset('extensions/ckeditor/ckeditor.js')}}"></script>
<script>
    let fullUrl = window.location.origin;
    if (window.location.pathname !== '/')
        fullUrl += window.location.pathname;


    let links = document.getElementsByClassName('menu-link');
    for (let item of links) {
        if (item.getAttribute('href') == fullUrl) {
            item.closest('.menu-item').classList.add('active');
            if (item.closest('.menu-item').closest('.menu-sub')) {
                item.closest('.menu-item').closest('.menu-sub').closest('.menu-item').classList.add('active', 'open');
            }
        }
    }

    if (document.getElementById('ckeditor')) {
        CKEDITOR.replace('ckeditor', {
            customConfig: '{{asset('extensions/ckeditor/config.js')}}',

            filebrowserUploadUrl: "{{route('uploadEditorImage', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
        });
    }
</script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>--}}

</body>
</html>
