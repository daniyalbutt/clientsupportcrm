@extends('layouts.app-support')
@section('title', 'Cover Design')

@section('content')
<div class="breadcrumb d-flex justify-content-between">
    <h1 class="mr-2">Cover Design INV#{{$data->invoice->invoice_number}}</h1>
    <form action="{{ route('support.form.download', ['form_id' => $data->id, 'check' => 10]) }}">
        <button class="btn btn-primary" type="submit">Download Form</button>
    </form>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form" method="post" route="{{ route('client.logo.form.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
        @include('form.bookcoverform')
    </form>
</div>
@endsection

@push('scripts')
@endpush