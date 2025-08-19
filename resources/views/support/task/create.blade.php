@extends('layouts.app-support')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
<div class="breadcrumb">
    <h1>{{ $project->name }}</h1>
    <ul>
        <li><a href="#">Task</a></li>
        <li>Create Task</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Task Details</div>
                <form class="form" action="{{route('store.task.by.support')}}" method="POST" enctype="multipart/form-data" id="create-task">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="project">Select Project <span>*</span></label>
                                <input type="text" name="project_name" id="project_name" class="form-control" value="{{ $project->name }}" required>
                                <input type="hidden" name="project" value="{{ $project->id }}">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="category">Select Category <span>*</span></label>
                                <select name="category[]" id="category" class="form-control select2" required multiple>
                                    @foreach($categorys as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-4">
                                <label for="duedate">Due Date <span>*</span></label>
                                <input class="form-control" type="date" name="duedate" id="duedate" value="{{old('duedate')}}" required>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="description">Description <span>*</span></label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="10" required="required" required>{{old('description')}}</textarea>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label>Select File</label>
                                <input type="file" id="files" multiple name="filenames[]" class="dropify">
                                <span class="file-custom"></span>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary create-task-btn" type="submit">Create Task</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

        $('#create-task').on('submit', function(evt) {
            $(this).find('.create-task-btn').hide();
        });
        
    </script>
@endpush