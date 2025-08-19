@extends('layouts.app-production')
@section('title', 'Notification')
@section('content')

<div class="breadcrumb">
    <h1 class="mr-2">Notification</h1>
</div>
<div class="separator-breadcrumb border-top"></div>


<div class="row">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Notification Details</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(auth()->user()->notifications()->orderBy('created_at','desc')->paginate(20) as $notification)
                            <tr>
                                <td><a href="{{ route('production.task.show', ['id' => $notification->data['task_id'], 'notify' => $notification->id]) }}">{{ $notification->data['text'] }}</a></td>
                                <td>{{ $notification->data['details'] }}</td>
                                <td>{{ $notification->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Time</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{auth()->user()->notifications()->paginate(20)->links('pagination::bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
