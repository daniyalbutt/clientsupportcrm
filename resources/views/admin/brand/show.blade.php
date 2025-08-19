@extends('layouts.app-admin')
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">{{ $brand->name }} - {{ $brand->url }}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="card user-profile o-hidden mb-4">
    <div class="user-info">
        <img class="avatar-lg mb-2" src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}">
        <p class="m-0 text-24">{{ $brand->name }}</p>
        <p class="text-muted m-0">{{ $brand->url }}</p>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs profile-nav mb-4" id="profileTab" role="tablist">
            <li class="nav-item"><a class="nav-link active show" id="timeline-tab" data-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="true">Leads - {{ $client_datas->total() }}</a></li>
            <li class="nav-item"><a class="nav-link" id="about-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false">Paid Invoice - {{ $invoice_datas->total() }}</a></li>
            <li class="nav-item"><a class="nav-link" id="friends-tab" data-toggle="tab" href="#friends" role="tab" aria-controls="friends" aria-selected="false">Unpaid Invoice - {{ $un_paid_invoice_datas->total() }}</a></li>
            <li class="nav-item"><a class="nav-link" id="projects-tab" data-toggle="tab" href="#projects" role="tab" aria-controls="projects" aria-selected="false">Projects - {{ $project_datas->total() }}</a></li>
            <li class="nav-item"><a class="nav-link" id="tasks-tab" data-toggle="tab" href="#tasks" role="tab" aria-controls="tasks" aria-selected="false">Tasks - {{ $task_datas->total() }}</a></li>
        </ul>
        <div class="tab-content" id="profileTabContent">
            <div class="tab-pane fade active show" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered"  style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($client_datas as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td><a href="{{ route('admin.client.show', $datas->id) }}">{{$datas->name}} {{$datas->last_name}}</a></td>
                                <td>{{$datas->email}}</td>
                                <td>
                                    @if($datas->status == 1)
                                        <button class="btn btn-success btn-sm">Active</button><br>
                                    @else
                                        <button class="btn btn-danger btn-sm">Deactive</button><br>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.client.edit', $datas->id) }}" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                        <span class="ul-btn__text">Edit</span>
                                    </a>
                                    <a href="{{ route('admin.client.show', $datas->id) }}" class="btn btn-dark btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Eyeglasses-Smiley"></i></span>
                                        <span class="ul-btn__text">View</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $client_datas->links("pagination::bootstrap-4") }}
                </div>
            </div>
            <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="about-tab">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>User Name</th>
                                <th>Agent Name</th>
                                <th>Amount</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice_datas as $datas)
                            <tr>
                                <td><span class="btn btn-primary btn-sm">#{{ $datas->invoice_number }}</span></td>
                                <td>
                                    @if($datas->package == 0)
                                    {{ $datas->custom_package }}
                                    @else
                                    {{ $datas->package }}
                                    @endif
                                </td>
                                <td>
                                    {{ $datas->client->name }} {{ $datas->client->last_name }}<br>
                                    {{ $datas->client->email }}
                                </td>
                                <td>
                                @if($datas->sales_agent_id != 0)
                                    {{ $datas->sale->name }} {{ $datas->sale->last_name }}<br>
                                    {{ $datas->sale->email }}
                                @else
                                    From Website
                                @endif
                                </td>
                                <td>{{ $datas->currency_show->sign }}{{ $datas->amount }}</td>
                                <td>
                                    <a href="{{ route('admin.link', $datas->id) }}" class="btn btn-info btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                        <span class="ul-btn__text">View</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>User Name</th>
                                <th>Agent Name</th>
                                <th>Amount</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $invoice_datas->links("pagination::bootstrap-4") }}
                </div>
            </div>
            <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>User Name</th>
                                <th>Agent Name</th>
                                <th>Amount</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($un_paid_invoice_datas as $datas)
                            <tr>
                                <td><span class="btn btn-primary btn-sm">#{{ $datas->invoice_number }}</span></td>
                                <td>
                                    @if($datas->package == 0)
                                    {{ $datas->custom_package }}
                                    @else
                                    {{ $datas->package }}
                                    @endif
                                </td>
                                <td>
                                    {{ $datas->client->name }} {{ $datas->client->last_name }}<br>
                                    {{ $datas->client->email }}
                                </td>
                                <td>
                                @if($datas->sales_agent_id != 0)
                                    {{ $datas->sale->name }} {{ $datas->sale->last_name }}<br>
                                    {{ $datas->sale->email }}
                                @else
                                    From Website
                                @endif
                                </td>
                                <td>{{ $datas->currency_show->sign }}{{ $datas->amount }}</td>
                                <td>
                                    <a href="{{ route('admin.link', $datas->id) }}" class="btn btn-info btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                                        <span class="ul-btn__text">View</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>User Name</th>
                                <th>Agent Name</th>
                                <th>Amount</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $un_paid_invoice_datas->links("pagination::bootstrap-4") }}
                </div>
            </div>
            <div class="tab-pane fade" id="projects" role="tabpanel" aria-labelledby="projects-tab">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Client</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project_datas as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td>{{$datas->name}}</td>
                                <td>
                                    {{$datas->client->name}} {{$datas->client->last_name}}<br>
                                    {{$datas->client->email}}                                    
                                </td>
                                <td>
                                    {{$datas->added_by->name}} {{$datas->added_by->last_name}} <br>
                                    {{$datas->added_by->email}}
                                </td>
                                <td>
                                    @if($datas->status == 1)
                                        <button class="btn btn-success btn-sm">Active</button>
                                    @else
                                        <button class="btn btn-danger btn-sm">Deactive</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.project.edit', $datas->id) }}" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                        <span class="ul-btn__text">Edit</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Client</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $project_datas->links("pagination::bootstrap-4") }}
                </div>
            </div>
            <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Project Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Total Files</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($task_datas as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td><a href="{{route('admin.task.show', $datas->id)}}">{!! \Illuminate\Support\Str::limit(strip_tags($datas->description), 30, $end='...') !!}</a></td>
                                <td>{{$datas->projects->name}}</td>
                                <td>{{$datas->category->name}}</td>
                                <td>{!! $datas->project_status() !!}</td>
                                <td>{{$datas->count_files()}}</td>
                                <td>
                                <!-- {{ route('admin.task.edit', $datas->id) }}  -->
                                    <a href="#" class="btn btn-primary btn-icon btn-sm">
                                        <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                                        <span class="ul-btn__text">Edit</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Project Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Total Files</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $task_datas->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')

@endpush