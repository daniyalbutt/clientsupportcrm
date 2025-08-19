@extends('layouts.app-support')
   
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Tasks List</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('support.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Tasks</li>
                    <li class="breadcrumb-item">Tasks List</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-lg-9">
    @if(count($notify_data) != 0)
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Notification Task Details</h4>
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Task</th>
                                        <th>Project</th>
                                        <th>Client</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notify_data as $datas)
                                    <tr class="selected">
                                        <td>{{$datas->id}}</td>
                                        <td>
                                            <a href="{{route('support.task.show', $datas->id)}}">{!! \Illuminate\Support\Str::limit(preg_replace("/<\/?a( [^>]*)?>/i", "", strip_tags($datas->description)), 30, $end='...') !!}</a>
                                        </td>
                                        <td>{{$datas->projects->name}}</td>
                                        <td>
                                            {{ $datas->projects->client->name }} {{ $datas->projects->client->last_name }}
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" title="{{ $datas->brand->name }}">{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $datas->brand->name))) }}</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-dark" title="{{ $datas->category->name }}">{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $datas->category->name))) }}</button>
                                            @if(count($datas->member_list) != 0)
                                            <ul id="member-box" class="task-list-member-box">
                                            @foreach($datas->member_list as $key => $member)
                                            <li><div class="member-box"><a href="javascript:;" title="{{ $member->user->name . ' ' . $member->user->last_name }}"><span>{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $member->user->name . ' ' . $member->user->last_name))) }}</span></a></div></li>
                                            @endforeach
                                            </ul>
                                            @endif
                                        </td>
                                        <td>{!! $datas->project_status() !!}</td>
                                        <td>
                                            <a href="{{route('support.task.show', $datas->id)}}" class="btn btn-primary btn-icon btn-sm">
                                                <span class="ul-btn__text">Details</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Task</th>
                                        <th>Project</th>
                                        <th>Client</th>
                                        <th>Brand</th>
                                        <th>Category</th>
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
        @endif
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card text-left">
                    <div class="card-body">
                        <form class="form" method="get" action="{{ route('support.task') }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4 form-group mb-0">
                                        <label for="id">Search By ID</label>
                                        <input type="text" class="form-control" id="id" name="id" value="{{ Request::get('id') }}">
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="brand">Search From Brand</label>
                                        <select name="brand" class="form-control select2" >
                                            <option value="">Any Brand</option>
                                            @foreach($brands as $brand)
                                            <option value="{{$brand->id}}" {{ Request::get('brand') ==  $brand->id ? 'selected' : ' '}}>{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group mb-0">
                                        <label for="brand">Search From Client Name Or Email</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ Request::get('name') }}">
                                    </div>
                                    <div class="col-md-4 form-group mb-0">
                                        <label for="category">Search From Category</label>
                                        <select name="category" class="form-control select2" >
                                            <option value="">Any</option>
                                            @foreach($categorys as $category)
                                            <option value="{{$category->id}}" {{ Request::get('category') ==  $category->id ? 'selected' : ' '}}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group mb-0">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="" {{ Request::get('status') ==  null ? 'selected' : ''}}>Any</option>
                                            <option value="0" {{ Request::get('status') ==  '0' ? 'selected' : ''}}>Open</option>
                                            <option value="1" {{ Request::get('status') ==  '1' ? 'selected' : ''}}>Re Open</option>
                                            <option value="4" {{ Request::get('status') ==  '4' ? 'selected' : ''}}>In Progress</option>
                                            <option value="5" {{ Request::get('status') ==  '5' ? 'selected' : ''}}>Sent for Approval</option>
                                            <option value="6" {{ Request::get('status') ==  '6' ? 'selected' : ''}}>Incomplete Brief</option>
                                            <option value="2" {{ Request::get('status') ==  '2' ? 'selected' : ''}}>Hold</option>
                                            <option value="3" {{ Request::get('status') ==  '3' ? 'selected' : ''}}>Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <button class="btn btn-primary" type="submit">Search Result</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Task Details</h4>
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered zero-configuration" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Task</th>
                                        <th>Project</th>
                                        <th>Client</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $datas)
                                    <tr>
                                        <td>{{$datas->id}}</td>
                                        <td><a href="{{route('support.task.show', $datas->id)}}">{!! \Illuminate\Support\Str::limit(preg_replace("/<\/?a( [^>]*)?>/i", "", strip_tags($datas->description)), 30, $end='...') !!}</a></td>
                                        <td>{{$datas->projects->name}}</td>
                                        <td>
                                            {{ $datas->projects->client->name }} {{ $datas->projects->client->last_name }}
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" title="{{ $datas->brand->name }}">{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $datas->brand->name))) }}</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-dark" title="{{ $datas->category->name }}">{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $datas->category->name))) }}</button>
                                            <br>
                                            @if(count($datas->member_list) != 0)
                                            <ul id="member-box" class="task-list-member-box">
                                            @foreach($datas->member_list as $key => $member)
                                            <li><div class="member-box"><a href="javascript:;" title="{{ $member->user->name . ' ' . $member->user->last_name }}"><span>{{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $member->user->name . ' ' . $member->user->last_name))) }}</span></a></div></li>
                                            @endforeach
                                            </ul>
                                            @endif
                                        </td>
                                        <td>
                                            {!! $datas->getDueDate() !!}
                                        </td>
                                        <td>{!! $datas->project_status() !!}</td>
                                        <td>
                                            <a href="{{route('support.task.show', $datas->id)}}" class="btn btn-primary btn-icon btn-sm">
                                                <span class="ul-btn__text">Details</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Task</th>
                                        <th>Project</th>
                                        <th>Client</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Active</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{ $data->appends(['brand' => Request::get('brand'), 'name' => Request::get('name'), 'category' => Request::get('category'), 'status' => Request::get('status')])->links("pagination::bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card text-left">
            <div class="card-body expected-delivery-card-body">
                <h4 class="card-title mb-3">Expected Delivery</h4>
                <h5>Overdue</h5>
                <div class="ul-widget1">
                    @if(count($myData['due_date_sub_task']) == 0)
                    <div class="alert alert-info" style="padding: 6px 15px;">No Data</div>
                    @endif
                    @foreach($myData['due_date_sub_task'] as $duedatesubtask)
                    @php
                        $duedate = $duedatesubtask->task;
                    @endphp
                    <div class="ul-widget4__item ul-widget4__users">
                        <div class="ul-widget2__info ul-widget4__users-info ml-0">
                            <a class="ul-widget2__title" href="{{route('support.task.show', $duedate->id)}}">{{ $duedate->projects->name }}</a>
                            <a class="ul-widget2__username" href="{{route('support.task.show', $duedate->id)}}">{!! \Illuminate\Support\Str::limit(preg_replace("/<\/?a( [^>]*)?>/i", "", strip_tags($duedate->description)), 25, $end='...') !!}</a>
                        </div>
                        <div class="ul-widget4__actions ul-widget4__date">
                            <button class="btn btn-outline-success m-1" type="button"> {{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $duedate->category->name))) }} </button>
                            <button class="btn btn-success text-white">{{$duedatesubtask->duedate}}</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <h5>Expected Delivery</h5>
                @if(count($myData['today_date']) == 0)
                    <div class="alert alert-info" style="padding: 6px 15px;">No Data</div>
                @endif
                <div class="ul-widget1">
                    @foreach($myData['today_date'] as $todaysubtask)
                        @php
                            $today = $todaysubtask->task;
                        @endphp
                        
                    <div class="ul-widget4__item ul-widget4__users">
                        <div class="ul-widget2__info ul-widget4__users-info ml-0">
                            <a class="ul-widget2__title" href="{{route('support.task.show', $today->id)}}">{{ $today->projects->name }}</a>
                            <a class="ul-widget2__username" href="{{route('support.task.show', $today->id)}}">{!! \Illuminate\Support\Str::limit(preg_replace("/<\/?a( [^>]*)?>/i", "", strip_tags($today->description)), 30, $end='...') !!}</a>
                        </div>
                        <div class="ul-widget4__actions ul-widget4__date">
                            <button class="btn btn-outline-success m-1" type="button"> {{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $today->category->name))) }} </button>
                            <button class="btn btn-warning text-white btn-sm">
                                {{  $todaysubtask->duedate}}
                            </button>
                          
                        </div>
                    </div>
                    @endforeach
                </div>
                <h5>Upcoming</h5>
                @if(count($myData['yesterday_date']) == 0)
                <div class="alert alert-info mb-0" style="padding: 6px 15px;">No Data</div>
                @endif
                <div class="ul-widget1">
                    @foreach($myData['yesterday_date'] as $duedateyesterday)
                    @php
                        $duedate = $duedateyesterday->task;
                    @endphp
                    <div class="ul-widget4__item ul-widget4__users">
                        <div class="ul-widget2__info ul-widget4__users-info ml-0">
                            <a class="ul-widget2__title" href="{{route('support.task.show', $duedate->id)}}">{{ $duedate->projects->name }}</a>
                            <a class="ul-widget2__username" href="{{route('support.task.show', $duedate->id)}}">{!! \Illuminate\Support\Str::limit(preg_replace("/<\/?a( [^>]*)?>/i", "", strip_tags($duedate->description)), 25, $end='...') !!}</a>
                        </div>
                        <div class="ul-widget4__actions ul-widget4__date">
                            <button class="btn btn-outline-success m-1" type="button"> {{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $duedate->category->name))) }} </button>
                            <button class="btn btn-danger text-white">{{$duedateyesterday->duedate}}</button>
                        </div>
                    </div>
                    @endforeach
                </div>    
            </div>
        </div>
    <div>
</div>


@endsection

@push('scripts')
    <script>
        // if($('.zero-configuration').length != 0){
        //     $('.zero-configuration').DataTable({
        //         order: [[0, "desc"]],
        //         responsive: true,
        //     });
        // }
    </script>
@endpush