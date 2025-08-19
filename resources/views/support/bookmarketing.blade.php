@extends('layouts.app-support')
@section('title', 'Book Marketing')

@section('content')
<div class="breadcrumb d-flex justify-content-between">
    <h1 class="mr-2">Book Marketing INV#{{$data->invoice->invoice_number}}</h1>
    <form action="{{ route('support.form.download', ['form_id' => $data->id, 'check' => 11]) }}">
        <button class="btn btn-primary" type="submit">Download Form</button>
    </form>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form" method="post" route="{{ route('client.logo.form.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
        @include('form.bookmarketingform')
    </form>
</div>
@endsection

@push('scripts')
@endpush