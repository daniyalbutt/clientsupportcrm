@extends('layouts.app-sale')
   
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Tasks List</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sale.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Tasks</li>
                    <li class="breadcrumb-item">Tasks List</li>
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
                        <h4 class="card-title">Task Details</h4>
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
                                        @foreach($data as $datas)
                                        <tr>
                                            <td>{{$datas->id}}</td>
                                            <td><a href="{{route('task.show', $datas->id)}}">{!! \Illuminate\Support\Str::limit($datas->description, 30, $end='...') !!}</a></td>
                                            <td>{{$datas->projects->name}}</td>
                                            <td><span class="badge badge-primary">{{$datas->brand->name}}</span></td>
                                            <td>{{$datas->category->name}}</td>
                                            <td>{!! $datas->project_status() !!}</td>
                                            <td>{{$datas->count_files()}}</td>
                                            <td>
                                                <div class="fonticon-wrap">
                                                    <a class="btn btn-sm btn-info" href="{{route('task.edit', $datas->id)}}"><i class="ft-edit"></i></a>
                                                </div>
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
                </div>
            </div>
        </div>
    </section>
</div>


@endsection

@push('scripts')
    
@endpush