@extends('layouts.app-admin')
@section('title', 'Book Writing Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Book Writing Brief INV#{{$data->invoice->invoice_number}}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form" method="post" route="{{ route('client.content.form.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
        @include('form.bookwritingform')
    </form>
</div>
@endsection

@push('scripts')
@endpush