@extends('layouts.app-sale')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Edit Sale Person (ID: {{$data->id}})</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sale.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Sale Person</li>
                    <li class="breadcrumb-item active">Edit Sale Person</li>
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
                        <h4 class="card-title" id="basic-layout-form">Sale Person Details</h4>
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
                            <form class="form" action="{{route('admin.user.sales.update', $data->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf   
                                @method('PATCH')  
                                <input type="hidden" name="is_employee" value="1">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">First Name <span>*</span></label>
                                                <input type="text" id="name" class="form-control" value="{{old('name', $data->name)}}" placeholder="First Name" name="name" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name <span>*</span></label>
                                                <input type="text" id="last_name" class="form-control" value="{{old('last_name', $data->last_name)}}" placeholder="Last Name" name="last_name" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email Address <span>*</span></label>
                                                <input type="email" id="email" class="form-control" value="{{old('email', $data->email)}}" placeholder="Email Address" name="email" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category">Category <span>*</span></label>
                                                <select name="category[]" id="category" class="form-control select2" required multiple="multiple">
                                                    @php
                                                        $found = 0;
                                                    @endphp
                                                    @foreach($category as $categorys)
                                                        @foreach($data->category as $user_cat)
                                                            @if($user_cat->pivot->category_id == $categorys->id)
                                                            @php
                                                                $found = 1;
                                                            @endphp
                                                            <option value="{{$categorys->id}}" selected>{{$categorys->name}}</option>
                                                            @break
                                                            @endif
                                                        @endforeach
                                                        @if($found == 0)
                                                        <option value="{{$categorys->id}}">{{$categorys->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact">Contact Number <span>*</span></label>
                                                <input type="text" id="contact" class="form-control" value="{{old('contact', $data->contact)}}" placeholder="Contact Number" name="contact" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Select Status <span>*</span></label>
                                                <select name="status" id="status" class="form-control" >
                                                    <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Active</option>
                                                    <option value="0" {{$data->status == 0 ? 'selected' : ''}}>Deactive</option>
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
    <script>
        $('#contact').keypress(function(event){
            if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                event.preventDefault(); //stop character from entering input
            }
        });
    </script>
@endpush