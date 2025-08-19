@extends('layouts.app-member')
@section('title', $subtask->task->projects->name)
@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('global/css/fileinput.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.1/css/all.min.css" integrity="sha512-ioRJH7yXnyX+7fXTQEKPULWkMn3CqMcapK0NNtCN8q//sW7ZeVFcbMJ9RvX99TwDg6P8rAH2IqUSt2TLab4Xmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .cke_top{
        display:none !important;
    }
    .assign-wrapper .select2-container .select2-selection--single {
        height: 34px;
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
    }
    .assign-wrapper .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 34px;
        padding-left: 15px;
    }
    .assign-wrapper .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 34px;
        top: 1px;
        right: 4px;
    }
    .assign-wrapper .input-group{
        flex-wrap: nowrap;
    }
    button.btn.btn-default.btn-secondary.fileinput-remove.fileinput-remove-button {
        background-color: #f44336 !important;
        color: white !important;
        border-right: 2px solid white;
    }

    a.btn.btn-default.btn-secondary.fileinput-upload.fileinput-upload-button {
        background-color: #003473 !important;
        color: white !important;
        border-right: 2px solid white;
    }
</style>
@endpush
@section('content')
<div class="breadcrumb row">
    <div class="col-md-9 pl-0">
        <h1 class="mr-2">{{$subtask->task->projects->name}} (ID: {{$subtask->task->id}})</h1>
        <ul>
            <li>Tasks</li>
            <li>Show Task</li>
        </ul>
    </div>
    <div class="content-header-right col-md-3 col-12 pr-0">
        <div class="btn-group float-md-right w-100">
            <div class="task-page w-100">
                <fieldset>
                    <div class="input-group">
                        <select name="update-task-value" id="update-task-value" class="form-control w-200">
                            <option value="0" {{($subtask->status == 0) ? 'selected' : ''}} disabled>Open</option>
                                <option value="1" {{($subtask->status == 1) ? 'selected' : ''}} disabled>Re Open</option>
                                <option value="4" {{($subtask->status == 4) ? 'selected' : ''}}>In Progress</option>
                                <option value="2" {{($subtask->status == 2) ? 'selected' : ''}}>On Hold</option>
                                <option value="5" {{($subtask->status == 5) ? 'selected' : ''}}>Sent for Approval</option>
                                <option value="6" {{($subtask->status == 6) ? 'selected' : ''}}>Incomplete Brief</option>
                                <option value="3" {{($subtask->status == 3) ? 'selected' : ''}}>Completed</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="update-task">Update</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
<div class="separator-breadcrumb border-top"></div>

<section id="basic-form-layouts">
    <div class="row">
        <div class="col-12">
            @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">Task Details</h4>
                    <div class="separator-breadcrumb border-top mb-3"></div>
                    <ul class="task_main_list">
                        <li>
                            <p class="mb-0">{!! $subtask->subtask->description !!}</p>
                        </li>
                        <li>
                            <div class="task_main_list-wrapper">
                                <button class="btn btn-dark btn-sm">Created At: {{ $subtask->created_at->format('d M, y - h:i:s A') }}</button>
                                <button class="btn btn-dark btn-sm">Due Date: {{ date('d M, y', strtotime($subtask->duadate)) }}</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">Comments By {{ $subtask->assigned_by_user->name }} {{ $subtask->assigned_by_user->last_name }}</h4>
                    <div class="separator-breadcrumb border-top mb-3"></div>
                    <ul class="task_main_list">
                        <li>
                            <p class="mb-3">{!! $subtask->comments !!}</p>
                        </li>
                        <li>
                            <div class="task_main_list-wrapper">
                                <button class="btn btn-dark btn-sm">Created At: {{ $subtask->created_at->format('d M, y - h:i:s A') }}</button>
                                <button class="btn btn-dark btn-sm">Due Date: {{ date('d M, y', strtotime($subtask->duadate)) }}</button>
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
                    <div class="">
                        <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                            <thead>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Uploaded</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($subtask->task->client_files as $client_files)
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
                                        <p class="mb-1">{{$client_files->name}}</p>
                                        <button class="btn btn-primary btn-sm">{{$client_files->created_at->format('d M, y') }}</button>
                                    </td>
                                    <td><button class="btn btn-secondary btn-sm">{{$client_files->user->name}} {{$client_files->user->last_name}}</button></td>
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
                    <h4 class="card-title mb-3">Message</h4>
                    <div class="separator-breadcrumb border-top mb-3"></div>
                    <form class="form" action="{{route('member.subtask.store')}}" method="POST" id="subtask" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="production_member_assigns_id" value="{{ $subtask->id }}">
                        <input type="hidden" name="created_at" class="created_at" value="">
                        <div class="form-body">
                            <div class="form-group">
                                <textarea id="description" rows="5" class="form-control border-primary" name="description" required>{{old('description')}}</textarea>
                            </div>
                        </div>
                        <div class="form-actions text-right pb-0">
                            <button type="submit" class="btn btn-primary">
                            <i class="la la-check-square-o"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="subtask_show">
                @foreach($subtask->sub_tasks_message as $sub_tasks)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-content collapse show">
                            <div class="ul-widget__body">
                                <div class="ul-widget3">
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
                                                <span class="ul-widget-notification-item-time">
                                                    @if($sub_tasks->created_at != null)
                                                    {{ $sub_tasks->created_at->format('d M, y | h:i A') }}
                                                    @endif
                                                </span>
                                            </div>
                                            <span class="ul-widget3-status text-success t-font-bolder">
                                                @if($sub_tasks->duedate != null)
                                                Due Date <br>
                                                {{ date('d M, y', strtotime($sub_tasks->duedate)) }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="ul-widget3-body">
                                            {!! $sub_tasks->messages !!}
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
</section>
@endsection

@push('scripts')
<script src="{{ asset('global/js/fileinput.js') }}"></script>
<script src="{{ asset('global/js/fileinput-theme.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js" integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        if($('#zero_configuration_table').length != 0){
            $('#zero_configuration_table').DataTable({
                order: [[0, "desc"]],
                responsive: true,
            });
        }
        CKEDITOR.replace('description');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#assign-sub-task-form').on('submit', function(e){
            e.preventDefault();
            var action = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: action,
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success == true){
                        toastr.success(response.data, 'Success', {timeOut: 5000})   
                    }else{
                        toastr.error('Please Contact your Administrator', 'Error Occured', {timeOut: 5000})
                    }
                }
            });
        })
        $('#subtask' ).on('submit', function(e) {
            e.preventDefault();
            var description = CKEDITOR.instances.description.getData();
            var duedate = $(this).find('[name=duedate]').val();
            var action = $(this).attr('action');
            var production_member_assigns_id = $(this).find('[name=production_member_assigns_id]').val();
            if(description != ''){
                $.ajax({
                    type: "POST",
                    url: action,
                    data: { description:description, duedate:duedate, production_member_assigns_id:production_member_assigns_id}, 
                    success: function(response) {
                        console.log(response);
                        var duedate = '';
                        if(response.duedate != null){
                            duedate = 'Due Date <br>' +  response.duedate
                        }
                        $('#subtask_show').prepend('<div class="card mb-3"><div class="card-body"><div class="card-content collapse show"><div class="ul-widget3-item">\
                                    <div class="ul-widget3-header">\
                                        <div class="ul-widget3-img">\
                                            <img id="userDropdown" src="/global/img/user.png" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">\
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
                                        <p>'+response.data.messages+'</p>\
                                    </div>\
                                </div></div></div></div>');
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
            uploadUrl: "{{ route('member.insert.files', ['id' => $subtask->task->id, 'subtask_id' => $subtask->subtask_id]) }}",
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
</script>
<script>
    $('#update-task').click(function(){
        var value = $('#update-task-value').val();
        $.ajax({
            type: "POST",
            url: "{{ route('member.update.task', $subtask->id) }}",
            data: { value:value },
            success: function(response) {
                if(response.status){
                    toastr.success(response.message, '', {timeOut: 5000})
                }
            }
        });
    });
</script>
@endpush