@extends('layouts.app-manager')
@push('styles')
<style>
    .ul-widget2__username {
       font-size: 0.8rem;
    }
</style>
@endpush
@section('content')

<div class="breadcrumb">
    <h1 class="mr-2">Messages</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<section class="widgets-content">
    <!-- begin::users-->
    <div class="row mt-2">
        <div class="col-xl-12">
            @foreach($messages as $key => $message)
            <div class="card mb-4">
                <div class="card-body">
                    <div class="ul-widget__body">
                        <div class="tab-content pt-0 pb-0">
                            <div class="tab-pane active show">
                                <div class="ul-widget1">
                                    <div class="ul-widget4__item ul-widget4__users p-0">
                                        <div class="ul-widget4__img">
                                            @if($message->user->image == null)
                                            <img src="{{ asset('newglobal/images/no-user-img.jpg') }}" alt="{{ $message->user->name }}" />
                                            @else
                                            <img src="{{ asset($message->user->image) }}" alt="{{ $message->user->name }}" />
                                            @endif
                                        </div>
                                        <div class="ul-widget2__info ul-widget4__users-info">
                                            <a class="ul-widget2__title" href="#">{{ $message->user->name }} {{ $message->user->last_name }}</a>
                                            <span class="ul-widget2__username" href="#">{!! strip_tags($message->user->lastmessage->message) !!}</span>
                                        </div>
                                        <div class="ul-widget4__actions text-center">
                                            <a href="{{ route('manager.message.show', ['id' => $message->user->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $message->user->name . '-' . $message->user->last_name))) ]) }}" class="btn btn-outline-success m-1">Message Details</a>
                                            <a href="{{ route('manager.client.details', ['id' => $message->user->id, 'name' => preg_replace('/[^A-Za-z0-9\-]/', '', strtolower(str_replace(' ', '-', $message->user->name . '-' . $message->user->last_name))) ]) }}" class="btn btn-primary">Client Details</a>
                                            <br>
                                            <span class="badge badge-info">{{ $message->user->client->brand->name }}</span>
                                        </div>
                                    </div>
                                    <div class="view-task-list-button">
                                        @if(count($message->user->projects) != 0)
                                        <div class="ul-widget4__actions">
                                        @foreach($message->user->projects as $project)
                                        @if(count($project->tasks) != 0)
                                        @foreach($project->tasks as $task)
                                        <a href="{{ route('manager.task.show', $task->id) }}" class="btn btn-outline-success m-1">View Details - {{ $task->category->name }}</a>
                                        @endforeach
                                        @endif
                                        @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            {{ $messages->links("pagination::bootstrap-4") }}
        </div>
    </div>
    <!-- end::users-->
</section>
@endsection

@push('scripts')
@endpush