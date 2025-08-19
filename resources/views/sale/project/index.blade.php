@extends('layouts.app-sale')
   
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Projects List</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sale.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Projects</li>
                    <li class="breadcrumb-item">Projects List</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">

    <section id="configuration">
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Project Details</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body card-dashboard pt-0">
                            <div class="">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Client</th>
                                            <th>Added By</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Active</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $datas)
                                        <tr>
                                            <td>{{$datas->id}}</td>
                                            <td>{{$datas->name}}</td>
                                            <td>{{$datas->client->name}} {{$datas->client->last_name}}</td>
                                            <td>{{$datas->added_by->name}} {{$datas->added_by->last_name}}</td>
                                            <td><span class="badge badge-info badge-sm">{{$datas->brand->name}}</span></td>
                                            <td>
                                            @foreach($datas->project_category as $project_categories)
                                            <span class="badge badge-primary">{{$project_categories->name}}</span>
                                            @endforeach
                                            </td>
                                            <td>
                                                @if($datas->status == 1)
                                                    <span class="badge badge-success">Active</span><br>
                                                @else
                                                    <span class="badge badge-danger">Deactive</span><br>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fonticon-wrap">
                                                    <a class="btn btn-sm btn-info" href="{{route('project.edit', $datas->id)}}"><i class="ft-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Client</th>
                                            <th>Added By</th>
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
        </div>
    </section>
</div>


@endsection

@push('scripts')
    
@endpush