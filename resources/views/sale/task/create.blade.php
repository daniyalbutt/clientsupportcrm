@extends('layouts.app-sale')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
        <h3 class="content-header-title mb-0 d-inline-block">Create Task</h3>
        <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sale.home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">Tasks</li>
                    <li class="breadcrumb-item active">Create Task</li>
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
                        <h4 class="card-title" id="basic-layout-form">Task Details</h4>
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
                            <form class="form" action="{{route('task.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="project">Select Project <span>*</span></label>
                                                <select name="project" id="project" class="form-control select2" requirced>
                                                    <option value="">Select Project</option>
                                                    @foreach($project as $projects)
                                                    <option value="{{$projects->id}}" data-category="{{$projects->project_category}}">{{$projects->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="category">Select Category <span>*</span></label>
                                                <select name="category" id="category" class="form-control select2" required>
                                                    <option value="">Select Category</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description <span>*</span></label>
                                                <textarea class="form-control" name="description" id="description" cols="30" rows="10" required="required" required>{{old('description')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Select File</label>
                                                <label id="files" class="form-control">
                                                    <input type="file" id="files" multiple name="filenames[]" class="dropify">
                                                    <span class="file-custom"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="duedate">Due Date <span>*</span></label>
                                                <input class="form-control" type="date" name="duedate" id="duedate" value="{{old('duedate')}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions text-right">
                                    <input type="hidden" value="" id="created_at" name="created_at">
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
        $(document).ready(function(){
            $('#project').on('change', function() {
                $("#category").empty();
                var categorySelect = $('#category');
                var category = $(this).children('option:selected').data('category');
                for(var i = 0; i < category.length; i++){
                    var option = new Option(category[i].name, category[i].id, false, false);
                    categorySelect.append(option).trigger('change');
                }
            });
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js" integrity="sha512-OF6VwfoBrM/wE3gt0I/lTh1ElROdq3etwAquhEm2YI45Um4ird+0ZFX1IwuBDBRufdXBuYoBb0mqXrmUA2VnOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        CKEDITOR.replace('description');
        $('.dropify').dropify();
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
            $('#created_at').val(dateStr);
        }, 1000);
        $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate() + 1;
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;
            $('#duedate').attr('min', maxDate);
        });
    </script>
@endpush