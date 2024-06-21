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

    <div class="d-flex mb-4 gap-2 justify-content-end">

{{--        <a href="#" class="btn btn-danger">--}}
{{--            <span class="tf-icons bx bx-archive"></span>&nbsp; Архив--}}
{{--        </a>--}}
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




@endsection

