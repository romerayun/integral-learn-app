@extends('layout.layout')

@section('content')
    @parent

    <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light"><a class="text-muted" href="{{route('learning-program.my')}}">Мои учебные программы</a> /  <a class="text-muted" href="{{route('learning-program.showDetails', ['learning_program' => $lp->id])}}">{{$lp->name}}</a> /</span> {{$activity->name}}</h4>

    <div class="card g-3 mt-3">
        <div class="card-body row g-3">
            <p class="fw-bold mb-0 fs-5"><span class="fw-bold">Тема:</span> {{$activity->name}}</p>
            <div class="d-flex align-items-center">
                <span class="badge bg-label-{{$activity->type->color}} activity-type">{{$activity->type->name}}</span>
                <span class="activity-hours">{{$activity->count_hours}}</span>
            </div>

            <div class="divider text-start mt-4">
                <div class="divider-text">Содержание активности</div>
            </div>

            <div class="content">
                {!! $activity->content!!}
            </div>
        </div>
    </div>
@endsection

