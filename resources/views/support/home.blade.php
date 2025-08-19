
@extends('layouts.app-support')
@section('content')

<div class="breadcrumb">
    <h1 class="mr-2">Dashboard</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-2 col-md-6 col-sm-6">
        <div class="card card-icon mb-4">
            <a href="{{ route('support.project') }}">
                <div class="card-body text-center"><i class="i-Suitcase"></i>
                    <p class="text-muted mt-2 mb-2">Projects</p>
                    <p class="text-primary text-24 line-height-1 m-0">{{ $project_count }}</p>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-2 col-md-6 col-sm-6">
        <div class="card card-icon mb-4">
            <a href="{{ route('support.task') }}">
                <div class="card-body text-center"><i class="i-Receipt-4"></i>
                    <p class="text-muted mt-2 mb-2">Tasks</p>
                    <p class="text-primary text-24 line-height-1 m-0">{{ $task_count }}</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
