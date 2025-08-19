@extends('layouts.app-member')
@section('title', 'Task')
@push('styles')
<style>
    .checkbox-wrapper {display: flex;gap: 20px;justify-content: end;}
</style>
@endpush
@section('content')


<div class="breadcrumb">
    <h1 class="mr-2">Tasks</h1>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <form action="{{ route('member.home') }}" method="GET" id="status-task">
                    <div class="row align-items-center">
                        <div class="col-md-12 form-group mb-0 ml-auto">
                            <div class="checkbox-wrapper">
                                <label class="checkbox checkbox-danger">
                                    <input type="checkbox" @if(request()->get('status') != null) {{ in_array(0, request()->get('status')) ? ' checked' : '' }} @else checked @endif name="status[]" value="0" /><span>Open</span><span class="checkmark"></span>
                                </label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="status[]" value="1" @if(request()->get('status') != null) {{ in_array(1, request()->get('status')) ? ' checked' : '' }} @endif/><span>Re Open</span><span class="checkmark"></span>
                                </label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="status[]" value="4" @if(request()->get('status') != null) {{ in_array(4, request()->get('status')) ? ' checked' : '' }} @endif/><span>In Progress</span><span class="checkmark"></span>
                                </label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="status[]" value="5" @if(request()->get('status') != null) {{ in_array(5, request()->get('status')) ? ' checked' : '' }} @endif/><span>Sent for Approval</span><span class="checkmark"></span>
                                </label>
                                <label class="checkbox checkbox-primary">
                                    <input type="checkbox" name="status[]" value="6" @if(request()->get('status') != null) {{ in_array(6, request()->get('status')) ? ' checked' : '' }} @endif/><span>Incomplete Brief</span><span class="checkmark"></span>
                                </label>
                                <label class="checkbox checkbox-success">
                                    <input type="checkbox" name="status[]" value="3" @if(request()->get('status') != null) {{ in_array(3, request()->get('status')) ? ' checked' : '' }} @endif/><span>Completed</span><span class="checkmark"></span>
                                </label>
                                <label class="checkbox checkbox-info">
                                    <input type="checkbox" name="status[]" value="2" @if(request()->get('status') != null) {{ in_array(2, request()->get('status')) ? ' checked' : '' }} @endif/><span>On Hold</span><span class="checkmark"></span>
                                </label>
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
                    <table class="table table-striped table-bordered zero-configuration">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Project Name</th>
                                <th>Agent</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Form</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subtasks as $datas)
                            <tr>
                                <td>{{$datas->id}}</td>
                                <td>
                                    <a href="{{route('member.subtask.show', $datas->id)}}">
                                        {!! \Illuminate\Support\Str::limit(preg_replace("/<\/?a( [^>]*)?>/i", "", strip_tags($datas->subtask->description)), 50, $end='...') !!}
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">
                                        {{$datas->task->projects->name}}
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-secondary">{{ $datas->task->projects->added_by->name }} {{ $datas->task->projects->added_by->last_name }}</button>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary">
                                        {{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $datas->task->brand->name))) }}
                                    </button>
                                    <button class="btn btn-sm btn-dark">
                                        {{ implode('', array_map(function($v) { return $v[0]; }, explode(' ', $datas->task->category->name))) }}
                                    </button>
                                </td>
                                <td>{!! $datas->get_status() !!}</td>
                                <td>
                                    @php
                                    $date_now = new DateTime();
                                    $date2 = new DateTime(date('d-m-Y', strtotime($datas->duadate)));
                                    @endphp
                                    @if ($date_now > $date2)
                                    <button class="btn btn-danger btn-sm">{{ date('d-m-Y', strtotime($datas->duadate)) }}</button>
                                    @else
                                    <button class="btn btn-success btn-sm">{{ date('d-m-Y', strtotime($datas->duadate)) }}</button>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex;gap:4px">
                                        <a target="_blank" href="{{ route('member.form', [ 'form_id' => $datas->task->projects->form_id , 'check' => $datas->task->projects->form_checker, 'id' => $datas->task->projects->id]) }}" class="btn btn-primary btn-icon btn-sm">
                                            View Form
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('member.subtask.show', $datas->id) }}" class="btn btn-primary btn-icon btn-sm">
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
                                <th>Project Name</th>
                                <th>Agent</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Form</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('input[name="status[]"]').change(function() {
            $('#status-task').submit();
        });
    });
    $('#category').change(function(){
        $('#status-task').submit();
    })
</script>
@endpush