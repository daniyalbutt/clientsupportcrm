@extends('layouts.app-sale')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Create Project</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sale.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Projects</li>
                    <li class="breadcrumb-item active">Create Project</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <section id="basic-form-layouts">
        <div class="row match-height">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Project Details</h4>
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
                        <div class="card-body">
                            <form class="form" action="{{route('project.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name <span>*</span></label>
                                                <input type="text" id="name" class="form-control" value="{{old('name')}}" placeholder="Name" name="name" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="client">Select Client <span>*</span></label>
                                                <select name="client" id="client" class="form-control select2">
                                                    <option value="">Select Client</option>
                                                    @foreach($clients as $client)
                                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description <span>*</span></label>
                                                <textarea class="form-control" name="description" id="description" cols="30" rows="10" required="required">{{old('description')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cost">Project Cost </label>
                                                <input type="text" id="cost" class="form-control" value="{{old('cost')}}" placeholder="Project Cost" name="cost">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Select Status <span>*</span></label>
                                                <select name="status" id="status" class="form-control" >
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="category">Category <span>*</span></label>
                                                <select name="category[]" id="category" class="form-control select2" required multiple="multiple">
                                                    @foreach($category as $categorys)
                                                    <option value="{{$categorys->id}}">{{$categorys->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-right">
                                    <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
               <div class="card">
                  <div class="card-header">
                     <h4 class="card-title" id="basic-layout-colored-form-control">Information</h4>
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
                     <div class="card-body pt-0">
                        @if($errors->any())
                        <div class="alert alert-danger">
                           <ul>
                              @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                              @endforeach
                           </ul>
                        </div>
                        @endif
                        @if (\Session::has('error'))
                        <div class="alert alert-danger">
                           <ul>
                              <li>{!! \Session::get('error') !!}</li>
                           </ul>
                        </div>
                        @endif
                        @if (\Session::has('success'))
                        <div class="alert alert-success">
                           <ul>
                              <li>{!! \Session::get('success') !!}</li>
                           </ul>
                        </div>
                        @endif
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