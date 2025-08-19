@extends('layouts.app-admin')
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('global/css/fileinput.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('newglobal/css/image-uploader.min.css') }}">
<style>
    ul.task_main_list {
        padding: 0px;
        margin-bottom: 0px;
        list-style: none;
    }
    .task_main_list-wrapper p {
        margin-bottom: 0px;
    }
    .fade:not(.show) {
        display: none;
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
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Files</h4>
                                    <div class="separator-breadcrumb border-top mb-3"></div>
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                                            <thead>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Uploaded By</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                            @foreach($task->client_files as $client_files)
                                                <tr>
                                                    <td>{{$client_files->id}}</td>
                                                    <td>
                                                        <a href="{{asset('files/'.$client_files->path)}}" target="_blank">
                                                            <img src="{{asset('files/'.$client_files->path)}}" alt="{{$client_files->name}}" width="100">
                                                        </a>
                                                    </td>
                                                    <td>{{$client_files->name}}</td>
                                                    <td><button class="btn btn-secondary btn-sm">{{$client_files->user->name}}</button></td>
                                                    <td><button class="btn btn-primary btn-sm">{{$client_files->created_at->format('d M, y h:m a') }}</span></td>
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
                                    <form class="form" action="{{route('admin.subtask.store')}}" method="POST" id="subtask" enctype="multipart/form-data">
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
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h4 class="card-title mb-0">Sub Task</h4>
                                </div>
                            </div>
                            @foreach($task->sub_tasks as $sub_tasks)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="card-content collapse show">
                                        <div class="ul-widget__body">
                                            <div class="ul-widget3" id="subtask_show">
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
                                                        <span class="ul-widget3-status text-success t-font-bolder" style="display: flex;justify-content: end;gap: 20px;">
                                                            @if($sub_tasks->duedate != null)
                                                            <div class="left">
                                                                Due Date <br>
                                                                {{ date('d M, y', strtotime($sub_tasks->duedate)) }}
                                                            </div>
                                                            @endif
                                                            @if($sub_tasks->duedateChange != null)
                                                            <div class="right" style="border-left: 1px solid #e5e5e5;padding-left: 15px;">
                                                            Changed By {{ $sub_tasks->duedateChange->user->name }} {{ $sub_tasks->duedateChange->user->last_name }}<br>
                                                            From {{ date('d M, y', strtotime($sub_tasks->duedateChange->duadate)) }} to {{ date('d M, y', strtotime($sub_tasks->duedate)) }}
                                                            </div>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="ul-widget3-body">
                                                        {!! $sub_tasks->description !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
                            <div class="card mb-3 {{ $message->role_id == 4 ? 'right-card' : 'left-card' }}">
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
                                                        <button class="btn-sm btn btn-primary" onclick="editMessage({{$message->id}})">Edit Message</button>
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
                                                                @if(($client_file->get_extension() == 'webp') || ($client_file->get_extension() == 'jpg') || ($client_file->get_extension() == 'png') || (($client_file->get_extension() == 'jpeg')))
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
                    </div>
                </div>
                <div class="tab-pane fade" id="notes-show" role="tabpanel" aria-labelledby="notes-show-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Additional Notes</h4>
                                    <div class="separator-breadcrumb border-top mb-3"></div>
                                    <form action="{{ route('store.notes.by.manager') }}" id="additional-notes">
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
        <form class="form" action="{{ route('manager.message.send') }}" enctype="multipart/form-data" method="post">
            @csrf
            <input type="hidden" name="client_id" value="{{ $task->projects->client->client_id }}">
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <div class="form-body">
                <div class="form-group mb-0">
                    <h1>Write A Message <span id="close-message-left"><i class="nav-icon i-Close-Window"></i></span></h1>
                    <textarea id="message" rows="8" class="form-control border-primary" name="message" required placeholder="Write a Message">{{old('message')}}</textarea>
                    <div class="input-field">
                        <div class="input-images" style="padding-top: .5rem;"></div>
                    </div>
                    <!-- <table>
                        <tr>
                            <td colspan="3" style="vertical-align:middle; text-align:left;">
                                <div id="h_ItemAttachments"></div>
                                <input type="button" id="h_btnAddFileUploadControl" value="Add Attachment" onclick="Clicked_h_btnAddFileUploadControl()" class="btn btn-info btn_Standard" />
                                <div id="h_ItemAttachmentControls"></div>
                            </td>
                        </tr>
                    </table> -->
                    <div class="form-actions pb-0 text-right">
                        <button type="submit" class="btn btn-primary">
                        <i class="la la-check-square-o"></i> Send Message
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>        
</div>

<!--  Modal -->
<div class="modal fade" id="exampleModalMessageEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-2">Edit Message</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('admin.message.update') }}" method="post">
                @csrf
                <input type="hidden" name="message_id" id="message_id">
                <div class="modal-body">
                    <textarea name="editmessage" id="editmessage" cols="30" rows="10" class="form-control"></textarea> 
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit">Update changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('global/js/fileinput.js') }}"></script>
<script src="{{ asset('global/js/fileinput-theme.js') }}"></script>
<script src="{{ asset('newglobal/js/image-uploader.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js" integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        $('.input-images').imageUploader();
        $('#write-message').click(function(){
            $('.left-message-box-wrapper').addClass('fixed-option');
        });
        $('#close-message-left').click(function(){
            $('.left-message-box-wrapper').removeClass('fixed-option');
        })
        CKEDITOR.replace('editmessage');
        CKEDITOR.replace('message');
        CKEDITOR.replace('description');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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
            uploadUrl: "{{ url('sale/files') }}/{{$task->id}}",
            overwriteInitial: false,
            maxFileSize:20000000,
            maxFilesNum: 20,
            uploadExtraData: function() {
                return {
                    created_at: $('.created_at').val()
                };
            }
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

    function editMessage(message_id){
        var url = "{{ route('admin.message.edit', ":message_id") }}";
        url = url.replace(':message_id', message_id);
        $.ajax({
            type:'GET',
            url: url,
            success:function(data) {
                if(data.success){
                    CKEDITOR.instances['editmessage'].setData(data.data.message);
                    console.log(data.data.message);
                    $('#exampleModalMessageEdit').find('#message_id').val(data.data.id);
                    $('#exampleModalMessageEdit').modal('toggle');
                }
            }
        });
    }
</script>
@endpush