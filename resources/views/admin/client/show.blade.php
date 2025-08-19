@extends('layouts.app-admin')
   
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">{{$client->name}} (ID: {{$client->id}})</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-6">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">{{$client->name}} Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{$client->name}} {{$client->last_name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$client->email}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{$client->contact}}</td>
                            </tr>
                            <tr>
                                <th>Brand</th>
                                <td>{{$client->brand->name}}</td>
                            </tr>
                            @if($client->url != null)
                            <tr>
                                <th>URL</th>
                                <td>{{$client->url}}</td>
                            </tr>
                            @endif
                            @if($client->subject != null)
                            <tr>
                                <th>Subject</th>
                                <td>{{$client->subject}}</td>
                            </tr>
                            @endif
                            @if($client->service != null)
                            <tr>
                                <th>Service</th>
                                <td>{{$client->service}}</td>
                            </tr>
                            @endif
                            @if($client->message != null)
                            <tr>
                                <th>Message</th>
                                <td>{{$client->message}}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Credit-Card"></i>
                        <p class="text-muted mt-2 mb-2">Paid Invoices</p>
                        <p class="text-primary text-24 line-height-1 m-0">${{ $client->invoice_paid() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Credit-Card-3"></i>
                        <p class="text-muted mt-2 mb-2">UnPaid Invoices</p>
                        <p class="text-primary text-24 line-height-1 m-0">${{ $client->invoice_unpaid() }}</p>
                    </div>
                </div>
            </div>
            @if($client->user != null)
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Suitcase"></i>
                        <p class="text-muted mt-2 mb-2">Projects</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ count($client->user->projects) }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="card text-left mt-5">
            <div class="card-body">
                <h4 class="card-title mb-3">Invoices</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>User Name</th>
                                <th>Agent Name</th>
                                <th>Brand</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($client->invoice as $datas)
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
                                <td>{{ $datas->brands->name }}</td>
                                <td>{{ $datas->currency_show->sign }}{{ $datas->amount }}</td>
                                <td>
                                    <span class="btn btn-{{ App\Models\Invoice::STATUS_COLOR[$datas->payment_status] }} btn-sm">
                                        {{ App\Models\Invoice::PAYMENT_STATUS[$datas->payment_status] }}
                                        @if($datas->payment_status == 1)
                                        <form method="post" action="{{ route('admin.invoice.paid', $datas->id) }}">
                                            @csrf
                                            <button type="submit" class="mark-paid btn btn-danger p-0">Mark As Paid</button>
                                        </form>
                                        @endif
                                    </span>
                                </td>
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
                                <th>Brand</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @if($client->user != null)
        <div class="card text-left mt-5">
            <div class="card-body">
                <h4 class="card-title mb-3">Project Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Client</th>
                                <th>Assigned To</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($client->user->projects as $datas)
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
                                <td><button class="btn btn-info btn-sm">{{$datas->brand->name}}</button></td>
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
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif
        @if($client->user != null)
        @foreach($client->user->projects as $datas)
        <div class="card text-left mt-5">
            <div class="card-body">
                <h4 class="card-title mb-3">{{$datas->name}} Details</h4>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Project Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Total Files</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas->tasks as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td><a href="{{route('admin.task.show', $datas->id)}}">{!! \Illuminate\Support\Str::limit(strip_tags($datas->description), 30, $end='...') !!}</a></td>
                                <td>{{$datas->projects->name}}</td>
                                <td><button class="btn btn-primary btn-sm">{{$datas->brand->name}}</button></td>
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
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Total Files</th>
                                <th>Active</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection

@push('scripts')
    
@endpush