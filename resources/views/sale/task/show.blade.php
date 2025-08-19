@extends('layouts.app-sale')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css" integrity="sha512-6qkvBbDyl5TDJtNJiC8foyEVuB6gxMBkrKy67XpqnIDxyvLLPJzmTjAj1dRJfNdmXWqD10VbJoeN4pOQqDwvRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.2/css/all.min.css" integrity="sha512-NicFTMUg/LwBeG8C7VG+gC4YiiRtQACl98QdkmfsLy37RzXdkaUAuPyVMND0olPP4Jn8M/ctesGSB2pgUBDRIw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="{{ asset('global/css/fileinput.css') }}">
<style>
    .cke_top {
        display: none !important;
    }
    ul.task_main_list {
        padding: 0px;
        margin-bottom: 0px;
        list-style: none;
    }
    .task_main_list-wrapper p {
        margin-bottom: 0px;
    }
    .fade:not(.show){
        display: none;
    }
    div#h_ItemAttachments {
        margin-top: 10px;
    }
    input#h_btnAddFileUploadControl {
        margin-top: 10px;
        margin-bottom: 15px;
    }
    div#mCSB_1_container {
        padding: 15px 15px;
        margin-right: 15px;
    }
    .card.mb-3.left-card span.ul-widget3-status.text-success.t-font-bolder {
        text-align: right;
        color: black !important;
    }
    .cke_top {
        display: none !important;
    }
    ul.task_main_list {
        padding: 0px;
        margin-bottom: 0px;
        list-style: none;
    }
    .task_main_list-wrapper p {
        margin-bottom: 0px;
    }
    input#h_btnAddFileUploadControl {
        margin-top: 0px;
        margin-bottom: 15px;
    }
    div#h_ItemAttachments {
        margin-bottom: 0px;
    }
    span.ul-widget3-status{
        display: block;
    }
    .ul-widget3-body p {
        font-size: 15px;
        line-height: inherit;
        margin-bottom: 0;
    }
    .card.left-card {
        text-align: left;
        max-width: 70%;
        margin-left: auto;
        color: black;
        background-color: #dbefdc;
        border-radius: 15px;
        border-color: #cde9ce;
        border-top-right-radius: 0;
        position: relative;
        margin-bottom:30px !important;
    }
    .mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
        background-color: #0076c2 !important;
    }
    .card.left-card:before {
        content: "";
        width: 0;
        height: 0;
        position: absolute;
        right: -15px;
        border-top: 0 solid transparent;
        border-bottom: 18px solid transparent;
        border-left: 15px solid #dbefdc;
    }
    .card.mb-3.left-card .ul-widget3-header {
        flex-direction: inherit;
        display:none;
    }
    .ul-widget3-header {
        padding-bottom: 8px;
        font-size: 15px;
    }
    .card.mb-3.left-card a.__g-widget-username {
        color: black;
    }
    .bottom-chat {
        position: fixed;
        bottom: 0;
        width: calc(100% - 150px);
    }
    .message-box-wrapper .card-body {
        padding: 10px 10px;
    }
</style>
@endpush
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">{{$task->projects->name}} (ID: {{$task->id}})</h1>
    <ul>
        <li>Tasks</li>
        <li>Show Task</li>
    </ul>
    <div class="task-page ml-auto">
        {!!$task->project_status()!!}
    </div>
</div>
<div class="separator-breadcrumb border-top"></div>

<section id="basic-form-layouts">
    <div class="row mb-4">
        <div class="col-md-12">                        
            <div class="card text-left mb-4">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="task-overview-tab" data-toggle="tab" href="#task-overview" role="tab" aria-controls="task-overview" aria-selected="true">Task Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="message-show-tab" data-toggle="tab" href="#message-show" role="tab" aria-controls="message-show" aria-selected="false">Message</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes-show" role="tab" aria-controls="notes-show" aria-selected="false">Notes</a>
                        </li>
                    </ul>
                </div>    
            </div>
            <div class="" id="myTabContent">
                <div class="tab-pane fade show active" id="task-overview" role="tabpanel" aria-labelledby="task-overview-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Task Details</h4>
                                    <div class="separator-breadcrumb border-top mb-3"></div>
                                    <ul class="task_main_list">
                                        <li>
                                            {!! $task->description !!}
                                        </li>
                                        <li>
                                            <div class="task_main_list-wrapper">
                                                <p>Due Date: {{ date('d M, y', strtotime($task->duedate)) }} | Created At: {{ $task->created_at->format('d M, y h:i a') }}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Update Files</h4>
                                    <div class="separator-breadcrumb border-top mb-3"></div>
                                    <input id="image-file" type="file" name="images[]" multiple data-browse-on-zone-click="true">
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body pl-0 pr-0">
                                    <h4 class="card-title mb-3" style="margin: 0 1.25em;">Files</h4>
                                    <div class="separator-breadcrumb border-top mb-3"></div>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                            <thead>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Uploaded</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                            @foreach($task->client_files_support as $client_files)
                                                <tr>
                                                    <td>{{$client_files->id}}</td>
                                                    <td>
                                                        @php
                                                            $temp= explode('.',$client_files->path);
                                                            $extension = end($temp);
                                                        @endphp
                                                        @if(($extension == 'jpg') || ($extension == 'png') || (($extension == 'jpeg')))
                                                        <a href="{{asset('files/'.$client_files->path)}}" target="_blank">
                                                            <img src="{{asset('files/'.$client_files->path)}}" alt="{{$client_files->name}}" width="100">
                                                        </a>
                                                        @else
                                                        <a href="{{asset('files/'.$client_files->path)}}" target="_blank">
                                                            {{$client_files->name}}.{{$extension}}
                                                        </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-dark btn-sm">{{$client_files->name}}</button>
                                                    </td>
                                                    <td><button class="btn btn-secondary btn-sm">{{$client_files->user->name}} {{$client_files->user->last_name}}</button></td>
                                                    <td><button class="btn btn-primary btn-sm">{{$client_files->created_at->format('d M, y') }}</span></td>
                                                    <td>
                                                        <div class="btn-group float-md-right ml-1">
                                                            <button class="btn btn-info dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="i-Edit"></i></button>
                                                            <div class="dropdown-menu arrow">
                                                                <a class="dropdown-item" href="{{asset('files/'.$client_files->path)}}" target="_blank"> View</a>
                                                                <a class="dropdown-item" href="{{asset('files/'.$client_files->path)}}" download> Download</a>
                                                                <a class="dropdown-item" href="#" onclick="deleteFile({{$client_files->id}})"> Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Create Sub Task</h4>
                                    <div class="separator-breadcrumb border-top mb-3"></div>
                                    <form class="form" action="{{route('support.subtask.store')}}" method="POST" id="subtask" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <textarea id="description" rows="5" class="form-control border-primary" name="description" placeholder="Sub Task Details" required>{{old('description')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="">Due Date</label>
                                                <input type="date" class="form-control" name="duedate" id="duedate">
                                            </div>
                                        </div>
                                        <div class="form-actions pb-0">
                                            <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Sub Task</h4>
                                    <div class="separator-breadcrumb border-top mb-3"></div>
                                    <div class="card-content collapse show">
                                        <div class="ul-widget__body">
                                            <div class="ul-widget3" id="subtask_show">
                                                @foreach($task->sub_tasks as $sub_tasks)
                                                <div class="ul-widget3-item">
                                                    <div class="ul-widget3-header">
                                                        <div class="ul-widget3-img">
                                                        @if($sub_tasks->user->image != '')
                                                            <img id="userDropdown" src="{{ asset($sub_tasks->user->image) }}" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        @else
                                                            <img id="userDropdown" src="{{ asset('global/img/user.png') }}" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        @endif
                                                        </div>
                                                        <div class="ul-widget3-info">
                                                            <a class="__g-widget-username" href="#">
                                                                <span class="t-font-bolder">{{ $sub_tasks->user->name }} {{ $sub_tasks->user->last_name }}</span>
                                                            </a>
                                                            <br>
                                                            <span class="ul-widget-notification-item-time">{{ $sub_tasks->created_at->diffForHumans() }}</span>
                                                        </div>
                                                        <span class="ul-widget3-status text-success t-font-bolder">
                                                            @if($sub_tasks->duedate != null)
                                                            Due Date <br>
                                                            {{ date('d M, y', strtotime($sub_tasks->duedate)) }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="ul-widget3-body">
                                                        {!! $sub_tasks->description !!}
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="message-show" role="tabpanel" aria-labelledby="message-show-tab">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-primary ml-auto" id="write-message">Write A Message</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 message-box-wrapper">
                            @foreach($messages as $message)
                            <div class="card mb-3 {{ $message->role_id == Auth()->user()->is_employee ? 'left-card' : 'right-card' }}">
                                <div class="card-body">
                                    <div class="card-content collapse show">
                                        <div class="ul-widget__body mt-0">
                                            <div class="ul-widget3 message_show">
                                                <div class="ul-widget3-item mt-0 mb-0">
                                                    <div class="ul-widget3-header">
                                                        <div class="ul-widget3-info">
                                                            <a class="__g-widget-username" href="#">
                                                                <span class="t-font-bolder">{{ $message->user->name }} {{ $message->user->last_name }}</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ul-widget3-body">
                                                        <p>{!! nl2br($message->message) !!}</p>
                                                        <span class="ul-widget3-status text-success t-font-bolder">
                                                            {{ date('d M, y', strtotime($message->created_at)) }}
                                                        </span>
                                                    </div>
                                                    <div class="file-wrapper">
                                                        @if(count($message->sended_client_files) != 0)
                                                        @foreach($message->sended_client_files as $key => $client_file)
                                                        <ul>
                                                            <li>
                                                                <button class="btn btn-dark btn-sm">{{++$key}}</button>
                                                            </li>
                                                            <li>
                                                                @if(($client_file->get_extension() == 'jpg') || ($client_file->get_extension() == 'png') || (($client_file->get_extension() == 'jpeg')))
                                                                <a href="{{asset('files/'.$client_file->path)}}" target="_blank">
                                                                    <img src="{{asset('files/'.$client_file->path)}}" alt="{{$client_file->name}}" width="40">
                                                                </a>
                                                                @else
                                                                <a href="{{asset('files/'.$client_file->path)}}" target="_blank">
                                                                    {{$client_file->name}}.{{$client_file->get_extension()}}
                                                                </a>
                                                                @endif
                                                            </li>
                                                            <li>
                                                                <a href="{{asset('files/'.$client_file->path)}}" target="_blank">{{$client_file->name}}</a>
                                                            </li>
                                                            <li>
                                                                <a href="{{asset('files/'.$client_file->path)}}" download>Download</a>
                                                            </li>
                                                        </ul>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Message to Client ( {{$task->projects->client->name}} {{$task->projects->client->last_name}} )</h4>
                                    <div class="separator-breadcrumb border-top mb-3"></div>
                                    <form class="form" method="post" id="sendmessage" action="{{ route('support.message.send') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <textarea id="message" rows="5" class="form-control border-primary" name="message" required>{{old('message')}}</textarea>
                                                <table>
                                                    <tr>
                                                        <td colspan="3" style="vertical-align:middle; text-align:left;">
                                                            <div id="h_ItemAttachments"></div>
                                                            <input type="button" id="h_btnAddFileUploadControl" value="Add Attachment" onclick="Clicked_h_btnAddFileUploadControl()" class="btn btn-primary btn_Standard" />
                                                            <div id="h_ItemAttachmentControls"></div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-actions pb-0 text-right">
                                            <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> Send Message
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="tab-pane fade" id="notes-show" role="tabpanel" aria-labelledby="notes-show-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Additional Notes</h4>
                                    <div class="separator-breadcrumb border-top mb-3"></div>
                                    <form action="{{ route('store.notes.by.support') }}" id="additional-notes">
                                        @csrf
                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                        <div class="form-group">
                                            <textarea name="notes" id="notes" cols="30" rows="5" class="form-control" required>{{ $task->notes }}</textarea>
                                        </div>
                                        <div class="form-actions pb-0 text-right">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                <div>
                            <div>            
                        <div>
                    </div>        
                </div>
            </div>
        </div>
    </div>
    
</section>


<div class="left-message-box-wrapper">
    <div class="left-message-box">
        <form class="form" action="{{ route('support.message.send') }}" enctype="multipart/form-data" method="post">
            @csrf
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <div class="form-body">
                <div class="form-group mb-0">
                    <h1>Write A Message <span id="close-message-left"><i class="nav-icon i-Close-Window"></i></span></h1>
                    <textarea id="message" rows="8" class="form-control border-primary" name="message" required placeholder="Write a Message">{{old('message')}}</textarea>
                    <table>
                        <tr>
                            <td colspan="3" style="vertical-align:middle; text-align:left;">
                                <div id="h_ItemAttachments"></div>
                                <input type="button" id="h_btnAddFileUploadControl" value="Add Attachment" onclick="Clicked_h_btnAddFileUploadControl()" class="btn btn-info btn_Standard" />
                                <div id="h_ItemAttachmentControls"></div>
                            </td>
                        </tr>
                    </table>
                    <div class="form-actions pb-0">
                        <button type="submit" class="btn btn-primary w-100">
                        <i class="la la-check-square-o"></i> Send Message
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>        
</div>

@endsection

@push('scripts')
<script src="{{ asset('global/js/fileinput.js') }}"></script>
<script src="{{ asset('global/js/fileinput-theme.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js" integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js" integrity="sha512-Yk47FuYNtuINE1w+t/KT4BQ7JaycTCcrvlSvdK/jry6Kcxqg5vN7/svVWCxZykVzzJHaxXk5T9jnFemZHSYgnw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        $('#write-message').click(function(){
            $('.left-message-box-wrapper').addClass('fixed-option');
        });
        $('#close-message-left').click(function(){
            $('.left-message-box-wrapper').removeClass('fixed-option');
        })
        @if (\Session::has('data'))
            @if(\Session::get('data') == 'message')
            $('.nav-tabs a[href="#message-show"]').tab('show');
            @endif
        @endif
        CKEDITOR.replace('message');
        CKEDITOR.replace('description');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#additional-notes').on('submit', function(e){
            e.preventDefault();
            var action = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: action,
                data: $(this).serialize(),
                success: function(response) {
                    toastr.success(response.data, '', {timeOut: 5000})
                }
            });
            console.log($(this).serialize());
        });
        $('#subtask' ).on('submit', function(e) {
            e.preventDefault();
            var description = CKEDITOR.instances.description.getData();
            var duedate = $(this).find('[name=duedate]').val();
            var action = $(this).attr('action');
            var task_id = $(this).find('[name=task_id]').val();
            if(description != ''){
                $.ajax({
                    type: "POST",
                    url: action,
                    data: { description:description, task_id:task_id, duedate:duedate}, 
                    success: function(response) {
                        var duedate = '';
                        if(response.duedate != null){
                            duedate = 'Due Date <br>' +  response.duedate
                        }
                        $('#subtask_show').prepend('<div class="ul-widget3-item">\
                                    <div class="ul-widget3-header">\
                                        <div class="ul-widget3-img">\
                                            <img id="userDropdown" src="http://127.0.0.1:8000/global/img/user.png" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
                                        </div>\
                                        <div class="ul-widget3-info">\
                                            <a class="__g-widget-username" href="#">\
                                                <span class="t-font-bolder">'+response.user_name+' </span>\
                                            </a>\
                                            <br>\
                                            <span class="ul-widget-notification-item-time">'+response.created_at+'</span>\
                                        </div>\
                                        <span class="ul-widget3-status text-success t-font-bolder">\
                                        '+duedate+'\
                                        </span>\
                                    </div>\
                                    <div class="ul-widget3-body">\
                                        <p>'+response.data.description+'</p>\
                                    </div>\
                                </div>');
                        CKEDITOR.instances.description.setData('');
                        $('#duedate').val('');
                        toastr.success(response.success, '', {timeOut: 5000})
                    }
                });
            }else{
                toastr.error("Please Fill the form", '', {timeOut: 5000})
            }
        });
        $("#image-file").fileinput({
            showUpload: true,
            theme: 'fa',
            dropZoneEnabled : true,
            uploadUrl: "{{ url('support/files') }}/{{$task->id}}",
            overwriteInitial: false,
            maxFileSize:20000000,
            maxFilesNum: 20,
        });
        $("#image-file").on('fileuploaded', function(event, data, previewId, index, fileId) {
            var month_names_short = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var response = data.response;
            console.log(response);
            $('.files').DataTable().destroy();
            for(var i = 0; i < response.files.length; i++){
                var formattedDate = new Date(response.files[i].created_at);
                var d = formattedDate.getDate();
                var m =  month_names_short[formattedDate.getMonth()];
                var y = formattedDate.getFullYear().toString().substr(-2);
                var hours = formattedDate.getHours();
                var minutes = formattedDate.getMinutes();
                var ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0'+minutes : minutes;
                var strTime = hours + ':' + minutes + ' ' + ampm;
                var newDateTime = d + " " + m + ", " + y + ' ' + strTime;
                $('#files tbody').prepend('<tr>\
                                        <td>'+response.files[i].id+'</td>\
                                        <td>\
                                            <a href="/files/'+response.files[i].path+'" target="_blank">\
                                                <img src="/files/'+response.files[i].path+'" alt="'+response.files[i].name+'" width="100">\
                                            </a>\
                                        </td>\
                                        <td>'+response.files[i].name+'</td>\
                                        <td><span class="badge badge-secondary badge-sm">'+response.uploaded_by+'</span></td>\
                                        <td><span class="badge badge-primary">'+newDateTime+'</span></td>\
                                        <td>\
                                            <div class="btn-group float-md-right ml-1">\
                                                <button class="btn btn-info dropdown-toggle btn-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="la la-eye"></i></button>\
                                                <div class="dropdown-menu arrow">\
                                                    <a class="dropdown-item" href="/files/'+response.files[i].path+'" target="_blank"> View</a>\
                                                    <a class="dropdown-item" href="/files/'+response.files[i].path+'" download> Download</a>\
                                                    <a class="dropdown-item" href="#" onclick="deleteFile('+response.files[i].id+')"> Delete</a>\
                                                </div>\
                                            </div>\
                                        </td>\
                                    </tr>');
            }
            toastr.success('Image Updated Successfully', '', {timeOut: 5000})
            $('.files').DataTable({
                order:[[0,"desc"]],
                responsive: true,
            })
        });
    });
    $(function(){
        var dtToday = new Date();
        
        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate() + 1;
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
        
        var maxDate = year + '-' + month + '-' + day;
        $('#duedate').attr('min', maxDate);
    });
    var start = new Date;
    setInterval(function() {
        var d = new Date();
        var date = ( '0' + (d.getDate()) ).slice( -2 );
        var month = ( '0' + (d.getMonth()+1) ).slice( -2 );
        var year = d.getFullYear();
        var seconds = ( '0' + (d.getSeconds()) ).slice( -2 );
        var minutes = ( '0' + (d.getMinutes()) ).slice( -2 );
        var hour = ( '0' + (d.getHours()) ).slice( -2 );
        var dateStr = year + "-" + month + "-" + date + ' ' + hour + ':' + minutes + ':' + seconds;
        $('.created_at').val(dateStr);
    }, 1000);

    // $('#sendmessage').submit(function(e){
    //     e.preventDefault();
    //     var form_obj = $(this);
    //     var formData = new FormData();

    //     $('input[name="h_Item_Attachments_FileInput[]"]').each(function(e){
    //         formData.append("file[]", $(this));
    //     })
    //     formData.append('task_id', $(this).find('input[name="task_id"]').val());
    //     formData.append('message', $(this).find('textarea[name="message"]').val());
    //     console.log(formData);
    //     swal({
    //         title: 'Are you sure?',
    //         text: "You want to Send this Message to Customer!",
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#0CC27E',
    //         cancelButtonColor: '#FF586B',
    //         confirmButtonText: 'Yes',
    //         cancelButtonText: 'No',
    //         confirmButtonClass: 'btn btn-lg btn-success mr-5',
    //         cancelButtonClass: 'btn btn-lg btn-danger',
    //         buttonsStyling: false
    //     }).then(function () {
    //         $.ajax({
    //             type:'POST',
    //             url: "{{ route('support.message.send') }}",
    //             data: formData,
    //             dataType: 'json',
    //             processData: false,
    //             contentType: false,
    //             success:function(data) {
    //                 if(data.success == true){
    //                     swal('Success!', 'Message Sent to Customer', 'success');
    //                     var timerInterval;
    //                     swal({
    //                         type: 'success',
    //                         title: 'Success!',
    //                         text: 'Message Sent to Customer! Page Will Redirect',
    //                         timer: 2000,
    //                         showCancelButton: false,
    //                         showConfirmButton: false
    //                     });
    //                 }else{
    //                     return swal({
    //                         title:"Error",
    //                         text: "There is an Error, Plase Contact Administrator",
    //                         type:"danger"
    //                     })
    //                 }
    //             }
    //         });
            
    //     }, function (dismiss) {
    //         if (dismiss === 'cancel') {
                
    //         }
    //     });
    // })

    $('.show-to-client').click(function(){
        var button_obj = $(this);
        var file_id = $(this).data('id');
        swal({
            title: 'Are you sure?',
            text: "You want to show this file to Customer!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0CC27E',
            cancelButtonColor: '#FF586B',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonClass: 'btn btn-lg btn-success mr-5',
            cancelButtonClass: 'btn btn-lg btn-danger',
            buttonsStyling: false
        }).then(function () {
            $.ajax({
                type:'POST',
                url: "{{ route('support.client.file.show') }}",
                data: {id: file_id},
                success:function(data) {
                    if(data.success == true){
                        $(button_obj).removeClass('show-to-client btn-dark');
                        $(button_obj).addClass('btn-info');
                        $(button_obj).text('Shown');
                        swal('Success!', 'File has Shown to Customer', 'success');
                    }else{
                        return swal({
                            title:"Error",
                            text: "There is an Error, Plase Contact Administrator",
                            type:"danger"
                        })
                    }
                }
            });
            
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                
            }
        });
    });
</script>
<!-- Image Upload -->
<script>
g_FileUploadControlCounter = 0;

function Clicked_h_btnAddFileUploadControl() {
    var v_btnFileUploadControl = document.getElementById("h_btnAddFileUploadControl");  
        v_btnFileUploadControl.value = "Add Another Attachment";

    var n="h_Item_Attachments_FileInput[]";
    var z="h_Item_Attachment" + g_FileUploadControlCounter;
    var x = document.createElement("INPUT");

        x.setAttribute("type", "file");
        x.setAttribute("id", z);
        x.setAttribute("name", n);
        x.setAttribute("onchange", "UpdateAttachmentsDisplayList()");
        x.setAttribute("class", "Otr_Std_pad");
        document.getElementById("h_ItemAttachmentControls").appendChild(x);
        g_FileUploadControlCounter++;
    }

    function Clicked_h_hrefRemoveFileUploadControl(v_Item_Attachment) {

        document.getElementById(v_Item_Attachment.id).value = null;
        UpdateAttachmentsDisplayList();
    }

    function UpdateAttachmentsDisplayList() {

    var inputs = document.getElementsByTagName('input');
    var txt='';

    for(var i = 0; i < inputs.length; i++) {
        if(inputs[i].type.toLowerCase() == 'file') {
            if(inputs[i].value.length > 0)
            {
                var x = inputs[i];
                txt += "<div class='item-attachments-wrapper'><strong>" + inputs[i].value + "</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:Clicked_h_hrefRemoveFileUploadControl(" + x.id + ");'>Delete</a></div>";
                document.getElementById(inputs[i].id).style.visibility = "hidden";
                document.getElementById(inputs[i].id).style.height = "0";
                document.getElementById(inputs[i].id).style.width = "0";
            }else{
                document.getElementById(inputs[i].id).style.visibility = "visible";
            }
        }
        document.getElementById("h_ItemAttachments").innerHTML = txt;
        }
    }
    $(".message-box-wrapper").mCustomScrollbar({
        setHeight:500,
    });
    $(".message-box-wrapper").mCustomScrollbar("scrollTo", "bottom");
</script>
@endpush