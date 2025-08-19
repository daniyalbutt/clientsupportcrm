@extends('layouts.app-manager')
@section('title', 'Editing & Proofreading Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Editing & Proofreading Brief INV#{{$data->invoice->invoice_number}}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form web-brief-form" method="post" route="{{ route('client.web.form.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
        @include('form.proofreadingform')
    </form>
</div>
@endsection

@push('scripts')
@endpush