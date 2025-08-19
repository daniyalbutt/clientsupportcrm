@extends('layouts.app-production')
@section('title', 'Book Cover Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Book Cover Brief INV#{{$data->invoice->invoice_number}}</h1>
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