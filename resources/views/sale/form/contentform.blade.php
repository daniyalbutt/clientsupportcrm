@extends('layouts.app-sale')
@section('title', 'Content Writing Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Content Writing Brief INV#{{$content_form->invoice->invoice_number}}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form" method="post" route="{{ route('client.content.form.update', $content_form->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Content Writing Form</div>
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="company_name">Company Name</label>
                        <input class="form-control" name="company_name" id="company_name" type="text" value="{{ old('company_name', $content_form->company_name) }}" required/>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="company_details">What is the origin, history, timeline, chronology, achievements, and future plans of your company? (Fill out as many as you can, please).</label>
                        <textarea class="form-control" name="company_details" id="company_details" rows="5" required>{{ old('company_details', $content_form->company_details) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="company_industry">What is the industry that your Business caters to?</label>
                        <textarea class="form-control" name="company_industry" id="company_industry" rows="5" required>{{ old('company_industry', $content_form->company_industry) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="company_reason">What is the reason behind what you do; passion? Heritage? Necessity?</label>
                        <textarea class="form-control" name="company_reason" id="company_reason" rows="5" required>{{ old('company_reason', $content_form->company_reason) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="company_products">Please list all products and services you provide?</label>
                        <textarea class="form-control" name="company_products" id="company_products" rows="5" required>{{ old('company_products', $content_form->company_products) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="short_description">Short description of your Business in your own words?</label>
                        <textarea class="form-control" name="short_description" id="short_description" rows="5" required>{{ old('short_description', $content_form->short_description) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="mission_statement">What is your mission statement?</label>
                        <textarea class="form-control" name="mission_statement" id="mission_statement" rows="5" required>{{ old('mission_statement', $content_form->mission_statement) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="keywords">List 10 or more keywords that best describe your Business</label>
                        <textarea class="form-control" name="keywords" id="keywords" rows="5" required>{{ old('keywords', $content_form->keywords) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="competitor">List three or more of your top competitor</label>
                        <textarea class="form-control" name="competitor" id="competitor" rows="5" required>{{ old('competitor', $content_form->competitor) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="company_business">In your words, what are the core strengths of your Business?</label>
                        <textarea class="form-control" name="company_business" id="company_business" rows="5" required>{{ old('company_business', $content_form->company_business) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="customers_accomplish">What do you think your customers accomplish by using your product/services?</label>
                        <textarea class="form-control" name="customers_accomplish" id="customers_accomplish" rows="5" required>{{ old('customers_accomplish', $content_form->customers_accomplish) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="company_sets">What sets your company apart from your competitors?</label>
                        <textarea class="form-control" name="company_sets" id="company_sets" rows="5" required>{{ old('company_sets', $content_form->company_sets) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="existing_taglines">Do you have any existing/preferred taglines and/or slogans that you would like us to use?</label>
                        <textarea class="form-control" name="existing_taglines" id="existing_taglines" rows="5" required>{{ old('existing_taglines', $content_form->existing_taglines) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Attachment</div>
                <div class="row">
                    <div class="col-12">
                        <input type="file" name="attachment[]" multiple/>
                    </div>
                    @foreach($content_form->formfiles as $formfiles)
                    <div class="col-md-3">
                        <div class="file-box">
                            <h3>{{ $formfiles->name }}</h3>
                            <a href="{{ asset('files/form') }}/{{$formfiles->path}}" target="_blank" class="btn btn-primary">Download</a>
                            <a href="javascript:;" data-id="{{ $formfiles->id }}" class="btn btn-danger delete-file">Delete</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@endpush