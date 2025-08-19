@extends('layouts.app-admin')
@push('styles')

@endpush
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Create Package</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Package</li>
                    <li class="breadcrumb-item active">Create Package</li>
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
                        <h4 class="card-title" id="basic-layout-form">Package Details</h4>
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
                            <form class="form" action="{{route('package.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf   
                                <input type="hidden" name="is_employee" value="1">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="brand_id">Brand <span>*</span></label>
                                                <select name="brand_id" id="brand_id" class="form-control select2" required>
                                                    <option value="">Select Brand</option>
                                                    @foreach($brands as $brand)
                                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="service">Service <span>*</span></label>
                                                <select name="service_id" id="service_id" class="form-control select2" required>
                                                    <option value="">Select Service</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name<span>*</span></label>
                                                <input type="text" id="name" class="form-control" value="{{old('name')}}" placeholder="Name" name="name" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-2 pr-0">
                                            <div class="form-group">
                                                <label for="currency">Currency<span>*</span></label>
                                                <select name="currencies_id" id="currencies_id" class="form-control select2">
                                                    @foreach($currencys as $currency)
                                                    <option value="{{$currency->id}}">{{$currency->sign}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 pl-1">
                                            <div class="form-group">
                                                <label for="actual_price">Actual Price<span>*</span></label>
                                                <input type="number" id="actual_price" class="form-control" value="{{old('actual_price')}}" placeholder="Actual Price" name="actual_price" required="required" step=".01">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">Price (Show on website) <span>*</span></label>
                                                <input type="text" id="price" class="form-control" value="{{old('price')}}" placeholder="Price" name="price" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cut_price">Cut Price <span>*</span></label>
                                                <input type="text" id="cut_price" class="form-control" value="{{old('cut_price')}}" placeholder="Cut Price" name="cut_price" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="details">Details <span>*</span></label>
                                                <textarea name="details" id="details" cols="30" rows="10" class="form-control" required>
                                                    {!! old('details') !!}
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="addon">Addon <span>*</span></label>
                                                <textarea name="addon" id="addon" cols="30" rows="5" class="form-control" required>
                                                    {!! old('addon') !!}
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description <span>*</span></label>
                                                <textarea name="description" id="description" cols="30" rows="5" class="form-control" required>
                                                    {!! old('description') !!}
                                                </textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="best_selling">Best Selling <span>*</span></label>
                                                <select name="best_selling" id="best_selling" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="is_combo">Is Combo? <span>*</span></label>
                                                <select name="is_combo" id="is_combo" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="on_landing">Landing Page Key <span>*</span></label>
                                                <input type="text" id="on_landing" class="form-control" value="{{old('on_landing')}}" placeholder="Landing Page Key" name="on_landing" required="required" value="0">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js" integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    CKEDITOR.replace('details');
    CKEDITOR.replace('description');
</script>
<script>
    $( "#brand_id" ).change(function() {
        if($(this).val() != ''){
            $.getJSON("/admin/service-list/"+ $(this).val(), function(jsonData){
                console.log(jsonData);
                select = '';
                $.each(jsonData, function(i,data)
                {
                    select +='<option value="'+data.id+'">'+data.name+'</option>';
                });
                $("#service_id").html(select);
            });
        }else{
            $("#service_id").html('');
        }
    });
</script>
@endpush