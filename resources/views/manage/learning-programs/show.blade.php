@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Управление / <a class="text-muted" href="{{route('learning-programs.index')}}">Учебные программы</a> / </span>
        {{$lp->name}}</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex mb-4">
                <a href="{{route('learning-programs.index')}}" class="btn btn-primary">
                    <span class="tf-icons bx bx-arrow-back"></span>&nbsp; Назад
                </a>
            </div>

            <input type="hidden" id="learning_program_id" value="{{$lp->id}}">
            @csrf

            <div class="row">
                <div class="@can('edit teacher lp') col-lg-8 @endcan @cannot('edit teacher lp') col-lg-12 @endcannot col-md-12">
                    <div class="card card-action mb-4">
                        <div class="card-header">
                            <div class="card-action-title">Управление учебной программой</div>
                            <div class="card-action-element">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="javascript:void(0);" class="card-expand"><i class="tf-icons bx bx-fullscreen"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex mb-4 align-items-center gap-2 buttons-container">
                                <span>Добавить</span>
                                <a class="btn btn-label-secondary create-new">
                                    Тему
                                </a>
                                @if(count($lp->themes) != 0)
                                    <a href="{{route('activity.createActivity', ['learning_program' => $lp->id])}}" class="btn btn-label-secondary create-activity">
                                        Активность
                                    </a>
                                @endif
                            </div>

                            <div class="themes-container">


                                @if(count($lp->themes) == 0)
                                    <input type="hidden" id="count-rows" value="0">
                                    <p class="fw-bold">Добавьте первую тему ☺️</p>
                                @endif
                                @foreach($lp->themes as $item)

                                <div class="card card-action mb-3 theme" id="theme{{$item->id}}">
                                    <div class="card-header">
                                        <div class="card-action-title">
                                            <div class="card-action-hours d-block fw-light">{{getCountHoursTheme($item->id)}}</div>
                                            <div class="card-action-name fw-bold" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="{{$item->name}}">{{$item->name}}</div>
                                        </div>
                                        <div class="card-action-element">
                                            <ul class="list-inline mb-0">

                                                <li class="list-inline-item">
                                                    <a href="{{route('activity.createWithTheme', ['learning_program' => $lp->id, 'theme' => $item->id])}}" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Добавить активность"><i class="tf-icons bx bx-plus-circle"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a class="edit-theme" attr-theme="{{$item->id}}" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Редактировать тему"><i class="tf-icons bx bx-pencil"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a attr-theme="{{$item->id}}" class="delete-theme" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить тему"><i class="tf-icons bx bx-trash"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <div class="theme-handle">
                                                        <i class="tf-icons bx bx-move"></i>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="collapse show" style="">
                                        <div class="card-body pt-0">

                                            <div class="activities-container">
                                                <div class="empty-activity">+</div>
                                                @if (count($item->activities) != 0)
                                                    @foreach($item->activities as $activity)

                                                    <div class="card card-action activity" id="activity{{$activity->id}}">
                                                        <div class="card-header">
                                                            <div class="card-action-title fw-bold">{{$activity->name}}</div>
                                                            <div class="card-action-element">
                                                                <ul class="list-inline mb-0">

                                                                    @if(getIdTypeQuiz() == $activity->type_id)
                                                                        <li class="list-inline-item">
                                                                            <a href="{{route('quiz.construct', ['activity' => $activity->id])}}" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Редактор теста"><i class="tf-icons bx bx-customize"></i></a>
                                                                        </li>
                                                                    @endif
                                                                    <li class="list-inline-item">
                                                                        <a href="{{route('activity.edit', ['activity' => $activity->id])}}" data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Редактировать активность"><i class="tf-icons bx bx-pencil"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a attr-activity="{{$activity->id}}" class="delete-activity"  data-bs-toggle="tooltip"  data-bs-placement="top" data-bs-title="Удалить активность" ><i class="tf-icons bx bx-trash"></i></a>

                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <a href="javascript:void(0);" class="card-collapsible"><i class="tf-icons bx bx-chevron-up"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <div class="activity-handle">
                                                                            <i class="tf-icons bx bx-move"></i>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="collapse show" style="">
                                                            <div class="card-body pt-0 pb-3">
                                                                <div class="d-flex fs-tiny align-items-center">
                                                                    <span class="badge bg-label-{{$activity->type->color}} activity-type">{{$activity->type->name}}</span>
                                                                    <span class="activity-hours">{{$activity->count_hours}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif



                                            </div>

                                        </div>
                                    </div>
                                </div>
                                    @endforeach
                            </div>

                        </div>
                </div>
                </div>

                @can('edit teacher lp')
                <div class="col-lg-4 col-md-12">
                    <div class="card card-action mb-4">
                        <div class="card-body">
                            <form action="{{route('learning-program.storeTeacher', ['learning_program' => $lp->id])}}" method="POST">
                                @csrf
                                <div>
                                    <label for="user_id" class="form-label">Назначьте преподавателей для учебной программы<sup class="text-danger">*</sup></label>

                                    <select id="user_id" name="user_id" class="select2 form-select @if($errors->has('user_id')) is-invalid @endif" multiple>
                                        @foreach($users as $user)
                                            @if(\App\Models\LearningProgramTeacher::where('learning_program_id', $lp->id)->where('user_id', $user->id)->count())
                                                <option value="{{$user->id}}" selected>{{$user->getFullName()}}</option>
                                            @else
                                                <option value="{{$user->id}}">{{$user->getFullName()}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="form-text text-danger">
                                        @if($errors->has('theme_id'))
                                            @foreach($errors->get('theme_id') as $message)
                                                {{$message}}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success" id="save">Сохранить</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                @endcan
            </div>





        </div>
    </div>

    @include('manage.learning-programs.alerts')

@endsection
