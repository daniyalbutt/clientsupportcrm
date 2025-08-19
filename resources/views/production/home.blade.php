@extends('layouts.app-production')
@section('title', 'Home')
@section('content')

<div class="breadcrumb">
    <h1 class="mr-2">Dashboard</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <!-- CARD ICON-->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Suitcase"></i>
                        <p class="text-muted mt-2 mb-2">Total Task</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $total_task }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Data-Upload"></i>
                        <p class="text-muted mt-2 mb-2">Open</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $open_task }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Data-Backup"></i>
                        <p class="text-muted mt-2 mb-2">Revision</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $reopen_task }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Data-Upload"></i>
                        <p class="text-muted mt-2 mb-2">In Progress</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $in_progress_task }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Data-Yes"></i>
                        <p class="text-muted mt-2 mb-2">Completed</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $completed_task }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Data-Block"></i>
                        <p class="text-muted mt-2 mb-2">Hold</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ $hold_task }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Recent Sub Task</div>
                @foreach($subtasks as $subtask)
                <div class="d-flex align-items-center border-bottom-dotted-dim pb-3 mb-3">
                    @if($subtask->user->image == null)
                    <img class="avatar-md rounded mr-3" src="{{ asset('newglobal/images/no-user-img.jpg') }}" alt="{{ $subtask->user->name }} {{ $subtask->user->last_name }}" />
                    @else
                    @endif
                    <div class="flex-grow-1">
                        <h6 class="m-0">{{ $subtask->user->name }} {{ $subtask->user->last_name }}</h6>
                        <p class="m-0 text-small text-muted">
                            <a href="{{ route('production.task.show', $subtask->task->id) }}">{!! \Illuminate\Support\Str::limit(strip_tags($subtask->description), 150, $end='...') !!}</a>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <hr>
    </div>
    @foreach($member as $key => $value)
    <div class="col-lg-3 col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between">{{ $value->name }} {{ $value->last_name }} <span class="btn btn-primary btn-sm">{{ $value->totalAssignTask() }}</span></div>
                <div class="ul-widget-app__poll-list mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-14">Open</span>
                        <h3 class="heading me-2">{{ $value->memberOpen() }}</h3>
                    </div>
                    @php
                    $total = 0
                    @endphp
                    @if($value->totalAssignTask() != 0)
                    @php
                    $total = ((int)$value->memberOpen() * 100) / (int)$value->totalAssignTask();
                    @endphp
                    @endif
                    <div class="progress progress--height-2 mb-3">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{$total}}%" aria-valuenow="{{ $total }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="ul-widget-app__poll-list mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-14">Re Open</span>
                        <h3 class="heading me-2">{{ $value->memberReOpen() }}</h3>
                    </div>
                    @php
                    $total = 0
                    @endphp
                    @if($value->totalAssignTask() != 0)
                    @php
                    $total = ((int)$value->memberReOpen() * 100) / (int)$value->totalAssignTask();
                    @endphp
                    @endif
                    <div class="progress progress--height-2 mb-3">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{$total}}%" aria-valuenow="{{$total}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="ul-widget-app__poll-list mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-14">In Progress</span>
                        <h3 class="heading me-2">{{ $value->memberInProgress() }}</h3>
                    </div>
                    @php
                    $total = 0
                    @endphp
                    @if($value->totalAssignTask() != 0)
                    @php
                    $total = ((int)$value->memberInProgress() * 100) / (int)$value->totalAssignTask();
                    @endphp
                    @endif
                    <div class="progress progress--height-2 mb-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$total}}%" aria-valuenow="{{$total}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="ul-widget-app__poll-list mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-14">Sent for Approval</span>
                        <h3 class="heading me-2">{{ $value->memberSentforApproval() }}</h3>
                    </div>
                    @php
                    $total = 0
                    @endphp
                    @if($value->totalAssignTask() != 0)
                    @php
                    $total = ((int)$value->memberSentforApproval() * 100) / (int)$value->totalAssignTask();
                    @endphp
                    @endif
                    <div class="progress progress--height-2 mb-3">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{$total}}%" aria-valuenow="{{$total}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="ul-widget-app__poll-list mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-14">Incomplete Brief</span>
                        <h3 class="heading me-2">{{ $value->memberIncompleteBrief() }}</h3>
                    </div>
                    @php
                    $total = 0
                    @endphp
                    @if($value->totalAssignTask() != 0)
                    @php
                    $total = ((int)$value->memberIncompleteBrief() * 100) / (int)$value->totalAssignTask();
                    @endphp
                    @endif
                    <div class="progress progress--height-2 mb-3">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$total}}%" aria-valuenow="{{$total}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="ul-widget-app__poll-list mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-14">Completed</span>
                        <h3 class="heading me-2">{{ $value->memberCompleted() }}</h3>
                    </div>
                    @php
                    $total = 0
                    @endphp
                    @if($value->totalAssignTask() != 0)
                    @php
                    $total = ((int)$value->memberCompleted() * 100) / (int)$value->totalAssignTask();
                    @endphp
                    @endif
                    <div class="progress progress--height-2 mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$total}}%" aria-valuenow="{{$total}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="ul-widget-app__poll-list mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-14">On Hold</span>
                        <h3 class="heading me-2">{{ $value->memberOnHold() }}</h3>
                    </div>
                    @php
                    $total = 0
                    @endphp
                    @if($value->totalAssignTask() != 0)
                    @php
                    $total = ((int)$value->memberOnHold() * 100) / (int)$value->totalAssignTask();
                    @endphp
                    @endif
                    <div class="progress progress--height-2 mb-3">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{$total}}%" aria-valuenow="{{$total}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection