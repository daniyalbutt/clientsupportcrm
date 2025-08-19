@extends('layouts.app-manager')
@section('title', 'Notificaitons')
@push('styles')
<style>
    .ul-widget2__username {
       font-size: 0.8rem;
    }
</style>
@endpush
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
                                <th>Description</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(auth()->user()->notifications()->orderBy('created_at','desc')->paginate(30) as $notification)
                            <tr>
                                <td>
                                @if($notification->type == 'App\Notifications\LeadNotification')
                                    <a href="{{ route('admin.client.shownotification', ['client' => $notification->data['id'], 'id' => $notification->id] ) }}">{{ $notification->data['text'] }}</a></td>
                                @else
                                    <a href="">{{ $notification->data['text'] }}</a>
                                @endif
                                </td>
                                <td>{{ $notification->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Description</th>
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

@push('scripts')
@endpush