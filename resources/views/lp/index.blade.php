@extends('layout.layout')

@section('content')
    @parent

{{--    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Мои учебные программы</h4>--}}


    <div class="card p-0 mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0">

            <div class="app-academy-md-75 card-body d-flex align-items-md-center flex-column text-md-center">
                <h3 class="card-title mb-0 lh-sm px-md-5 text-start fw-bold">
                    Ваши
                    <span class="text-primary  text-nowrap"> курсы</span>
                </h3>
{{--                <p class="mb-4">--}}
{{--                    Все ваши курсы находтся в данном разделе--}}
{{--                </p>--}}
            </div>
            <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
                <img src="{{Vite::asset('resources/assets/img/illustrations/pencil-rocket.png')}}" alt="pencil rocket" height="80" class="scaleX-n1-rtl">
            </div>
        </div>
    </div>

    <div class="d-flex mb-4 gap-2">
        <a href="http://127.0.0.1:8000/manage/users/create" class="btn btn-success">
            <span class="tf-icons bx bx-edit"></span>&nbsp; Записаться на новый курс
        </a>
        <a href="#" class="btn btn-danger">
            <span class="tf-icons bx bx-archive"></span>&nbsp; Архив
        </a>
    </div>

    @if(count(auth()->user()->groups)==0)
        <p class="text-danger">Пользователь не прикреплен ни к одной учебной группе</p>
    @else
        <div class="row lp">

        @foreach(auth()->user()->groups as $group)
                @foreach($group->learningPrograms as $lp)
                    <div class="col-lg-4 col-md-12">
                        <a href="{{route('learning-program.showDetails', ['learning_program' => $lp->id])}}">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">{{$lp->name}}</h5>
                                    <div class="card-subtitle text-muted mb-3">Прогресс прохождения</div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="card-text text-gray mt-3">
                                        <b>Количество тем - {{$lp->themes->count()}}</b>
                                        @if($lp->themes->count() != 0)
                                            <ul class="list-group">
                                                @foreach($lp->themes as $theme)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{$theme->name}}
                                                        <span class="badge bg-gray rounded-pill">{{$theme->activities->count()}}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </p>
                                    @if($lp->working_program)
                                        <a href="{{$lp->working_program}}" class="card-link" download="{{str()->slug($lp->name)}}">Рабочая программа</a>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
        @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body row gy-4">
            <div class="col-sm-12 col-lg-4 text-center align-items-center pt-3 px-3">
                <span class="badge bg-label-primary rounded-3 mb-3"><i class="bx bxs-hot bx-md"></i></span>
                <h3 class="card-title mb-4">Самые популярные курсы</h3>
                <p class="card-text mb-4">
                   Мы предлагаем огромное количество курсов на сегодняшний день, здесь мы выбрали самые популярные курсы которые большего всего пользуются спросом
                </p>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card p-2 h-100 shadow-none border">

                    <div class="card-body p-3 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                                3.8 <span class="text-warning"><i class="bx bxs-star me-1"></i></span><span class="text-muted"> (634)</span>
                            </h6>
                        </div>
                        <a class="h5" href="app-academy-course-details.html">Basics to Advanced</a>
                        <p class="mt-2">20 more lessons like this about music production, writing, mixing, mastering</p>
                        <p class="d-flex align-items-center"><i class="bx bx-time-five me-2"></i>30 minutes</p>
                        <div class="progress mb-4" style="height: 8px">
                            <div class="progress-bar w-75" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2 text-nowrap pe-xl-3 pe-xxl-0">
                            <a class="app-academy-md-50 btn btn-label-secondary me-md-2 d-flex align-items-center" href="app-academy-course-details.html">
                                <i class="bx bx-sync align-middle me-2 "></i><span>Start Over</span>
                            </a>
                            <a class="app-academy-md-50 btn btn-label-primary d-flex align-items-center" href="app-academy-course-details.html">
                                <span class="me-2">Continue</span><i class="bx bx-chevron-right lh-1 scaleX-n1-rtl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card p-2 h-100 shadow-none border">

                    <div class="card-body p-3 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="d-flex align-items-center justify-content-center gap-1 mb-0">
                                3.8 <span class="text-warning"><i class="bx bxs-star me-1"></i></span><span class="text-muted"> (634)</span>
                            </h6>
                        </div>
                        <a class="h5" href="app-academy-course-details.html">Basics to Advanced</a>
                        <p class="mt-2">20 more lessons like this about music production, writing, mixing, mastering</p>
                        <p class="d-flex align-items-center"><i class="bx bx-time-five me-2"></i>30 minutes</p>
                        <div class="progress mb-4" style="height: 8px">
                            <div class="progress-bar w-75" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex flex-column flex-md-row gap-2 text-nowrap pe-xl-3 pe-xxl-0">
                            <a class="app-academy-md-50 btn btn-label-secondary me-md-2 d-flex align-items-center" href="app-academy-course-details.html">
                                <i class="bx bx-sync align-middle me-2 "></i><span>Start Over</span>
                            </a>
                            <a class="app-academy-md-50 btn btn-label-primary d-flex align-items-center" href="app-academy-course-details.html">
                                <span class="me-2">Continue</span><i class="bx bx-chevron-right lh-1 scaleX-n1-rtl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

