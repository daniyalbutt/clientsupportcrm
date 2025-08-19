@extends('layouts.app-manager')

@push('styles')
    <style>
        .card.left-card {
            width: 100%;
            max-width: 100%;
        }
        .card.right-card {
            width: 100%;
            max-width: 100%;
        }
        .col-md-6.message-box-wrapper {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px 1px rgb(0 0 0 / 6%), 0 1px 4px rgb(0 0 0 / 8%);
            border: 0;
            height: 531px;
            overflow-y: scroll;
        }
    </style>
@endpush

@section('content')

<div class="breadcrumb row">
    <div class="col-md-6">
        <h1>{{ $user->name }} {{ $user->last_name }}</h1>
        <ul>
            <li><a href="#">{{ $user->email }}</a></li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        
    </div>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-6">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped" style="width:100%">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    @if($user->image != null)
                                    <img src="{{ asset($user->image) }}" alt="">
                                    @else
                                    <img src="{{ asset('newglobal/images/no-user-img.jpg') }}" alt="{{ $user->name }} {{ $user->last_name }}">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>First Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $user->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $user->contact }}</td>
                            </tr>
                            <tr>
                                <th>Brand</th>
                                <td><button class="btn btn-primary btn-sm">{{ $user->client->brand->name }}</button></td>
                            </tr>
                            <tr>
                                <th>Total Projects</th>
                                <td><button class="btn btn-info btn-sm">{{ count($user->projects) }}</button></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($user->status == 1)
                                    <button class="btn btn-success btn-sm">Active</button>
                                    @else
                                    <button class="btn btn-danger btn-sm">Deactive</button>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Last Message</th>
                                <td><button class="btn btn-secondary btn-sm">{{ date('d M, y h:m:s A', strtotime($user->lastmessage->created_at)) }}</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 message-box-wrapper">
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
                                    {!! nl2br($message->message) !!}
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
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Invoice Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>Agent</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Create Login</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->client->invoice as $datas)
                            <tr>
                                <td>
                                    <span class="btn btn-sm btn-dark">#{{ $datas->invoice_number }}</span>
                                </td>
                                <td>
                                    @if($datas->package == 0)
                                    {{ $datas->custom_package }}
                                    @else
                                    {{ $datas->package }}
                                    @endif
                                </td>
                                <td>{{ $datas->sale->name }} {{ $datas->sale->last_name }}</td>
                                <td>
                                    @php
                                    $service_list = explode(',', $datas->service);
                                    @endphp
                                    @for($i = 0; $i < count($service_list); $i++)
                                    <span class="btn btn-info btn-sm mb-1">{{ $datas->services($service_list[$i])->name }}</span>
                                    @endfor
                                </td>
                                <td>
                                    <span class="btn btn-{{ App\Models\Invoice::STATUS_COLOR[$datas->payment_status] }} btn-sm">
                                        {{ App\Models\Invoice::PAYMENT_STATUS[$datas->payment_status] }}
                                        @if($datas->payment_status == 1)
                                        <form method="post" action="{{ route('manager.invoice.paid', $datas->id) }}">
                                            @csrf
                                            <button type="submit" class="mark-paid btn btn-danger p-0">Mark As Paid</button>
                                        </form>
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $datas->currency_show->sign }}{{ $datas->amount }}</td>
                                <td>                                    
                                    @if($datas->payment_status == 2)
                                    <a href="javascript:;" class="btn btn-{{ $datas->client->user == null ? 'primary' : 'success' }} btn-sm auth-create" data-id="{{ $datas->client->id }}" data-auth="{{ $datas->client->user == null ? 0 : 1 }}" data-password="{{ $datas->client->user == null ? '' : $datas->client->user->password }}">{{ $datas->client->user == null ? 'Click Here' : 'Reset Pass' }}</a>
                                    @else
                                    <span class="btn btn-info btn-sm">Payment Pending</span>
                                    @endif

                                </td>
                                <td>
                                    <div class="d-flex">
                                        @if($datas->payment_status == 1)
                                        <a href="{{ route('manager.invoice.edit', $datas->id) }}" class="btn btn-primary btn-icon btn-sm mr-1">
                                            <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                            <span class="ul-btn__text">Edit</span>
                                        </a>
                                        @endif
                                        <a href="{{ route('manager.link', $datas->id) }}" class="btn btn-info btn-icon btn-sm">
                                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                            <span class="ul-btn__text">View</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>Agent</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Create Login</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Project Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Assigned To</th>
                                <th>Brand</th>
                                <th>Reassign</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->projects as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td>{{$datas->name}}</td>
                                <td>
                                    {{$datas->added_by->name}} {{$datas->added_by->last_name}} <br>
                                    {{$datas->added_by->email}}
                                </td>
                                <td><button class="btn btn-info btn-sm">{{$datas->brand->name}}</button></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="openReassign({{$datas->id}}, '{{$datas->brand->id}}')">Reassign</button>
                                </td>
                                <td>
                                    @if($datas->status == 1)
                                        <button class="btn btn-success btn-sm">Active</button>
                                    @else
                                        <button class="btn btn-danger btn-sm">Deactive</button>
                                    @endif
                                </td>
                                <td>
                                    NONE
                                    <!-- <a href="{{ route('manager.project.edit', $datas->id) }}" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                        <span class="ul-btn__text">Edit</span>
                                    </a> -->
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Assigned To</th>
                                <th>Brand</th>
                                <th>Reassign</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Task Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="zero_configuration_table" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Project</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Files</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->projects as $projects)
                            @foreach($projects->tasks as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td><a href="{{route('manager.task.show', $datas->id)}}">{!! \Illuminate\Support\Str::limit($datas->description, 30, $end='...') !!}</a></td>
                                <td>{{$datas->projects->name}}</td>
                                <td><button class="btn btn-primary btn-sm">{{$datas->brand->name}}</button></td>
                                <td>{{$datas->category->name}}</td>
                                <td>{!! $datas->project_status() !!}</td>
                                <td>{{$datas->count_files()}}</td>
                                <td>
                                    <a href="{{route('manager.task.show', $datas->id)}}" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__text">Details</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Project</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Files</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
    
@endpush