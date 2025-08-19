@extends('layouts.app-manager')
@section('title', 'Social Media Marketing Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Social Media Marketing Brief INV#{{$smm_form->invoice->invoice_number}}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form" method="post" route="{{ route('client.smm.form.update', $smm_form->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Social Media Marketing Form</div>
                <div class="row">
                @php
                    $desired_results = json_decode($smm_form->desired_results);
                @endphp
                    <div class="col-md-12 form-group mb-3">
                        <label for="desired_results">What are the desired results that you want to get generated from this Social Media project? ( Check one or more of the following )</label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="desired_results[]" value="Increase in Page Likes/Followers" @if($desired_results != null) {{ in_array('Increase in Page Likes/Followers', $desired_results) ? ' checked' : '' }} @endif>
                            <span>Increase in Page Likes/Followers </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="desired_results[]" value="Targeted Advertisement" @if($desired_results != null) {{ in_array('Targeted Advertisement', $desired_results) ? ' checked' : '' }} @endif>
                            <span>Targeted Advertisement </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="desired_results[]" value="Social Media Management" @if($desired_results != null) {{ in_array('Social Media Management', $desired_results) ? ' checked' : '' }} @endif>
                            <span>Social Media Management </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="desired_results[]" value="Brand Awareness" @if($desired_results != null) {{ in_array('Brand Awareness', $desired_results) ? ' checked' : '' }} @endif>
                            <span>Brand Awareness </span><span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Please provide the following information for your Business</div>
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="">This information will be used to create your social profiles and establish the country of origin of your brand - In case the business in purely online, please provide P.O. Box address (however, mailing address remains mandatory)</label>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="business_name">Company/Business Name</label>
                        <input class="form-control" name="business_name" id="business_name" type="text" value="{{ old('business_name', $smm_form->business_name) }}" required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="business_email_address">Business Email Address</label>
                        <input class="form-control" name="business_email_address" id="business_email_address" type="email" value="{{ old('business_email_address', $smm_form->business_email_address) }}" required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="business_phone_number">Business Phone Number</label>
                        <input class="form-control" name="business_phone_number" id="business_phone_number" type="text" value="{{ old('business_phone_number', $smm_form->business_phone_number) }}" required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="business_mailing_address">Business Mailing Address ( Verification Purposes )</label>
                        <input class="form-control" name="business_mailing_address" id="business_mailing_address" type="email" value="{{ old('business_mailing_address', $smm_form->business_mailing_address) }}" required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="business_website_address">Business Website Address (URL)</label>
                        <input class="form-control" name="business_website_address" id="business_website_address" type="text" value="{{ old('business_website_address', $smm_form->business_website_address) }}" required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="business_working_hours">Business Working Hours</label>
                        <input class="form-control" name="business_working_hours" id="business_working_hours" type="text" value="{{ old('business_working_hours', $smm_form->business_working_hours) }}" required/>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="business_location">Business Location</label>
                        <input class="form-control" name="business_location" id="business_location" type="text" value="{{ old('business_location', $smm_form->business_location) }}" required/>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="business_category">Business Category/Industry (Real Estate, Education, IT, Retail etc)</label>
                        <textarea class="form-control" name="business_category" id="business_category" required>{{ old('business_category', $smm_form->business_category) }}</textarea>
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        @php
                            $social_media_platforms = json_decode($smm_form->social_media_platforms);
                        @endphp
                        <label for="social_media_platforms">Please mention Social Media platforms that you want to opt <br>(consult your Account Manager)</label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="social_media_platforms[]" value="Facebook" @if($social_media_platforms != null) {{ in_array('Facebook', $social_media_platforms) ? ' checked' : '' }} @endif>
                            <span>Facebook </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="social_media_platforms[]" value="Twitter" @if($social_media_platforms != null) {{ in_array('Twitter', $social_media_platforms) ? ' checked' : '' }} @endif>
                            <span>Twitter </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="social_media_platforms[]" value="Instagram" @if($social_media_platforms != null) {{ in_array('Instagram', $social_media_platforms) ? ' checked' : '' }} @endif>
                            <span>Instagram </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="social_media_platforms[]" value="Pinterest" @if($social_media_platforms != null) {{ in_array('Pinterest', $social_media_platforms) ? ' checked' : '' }} @endif>
                            <span>Pinterest </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="social_media_platforms[]" value="YouTube" @if($social_media_platforms != null) {{ in_array('YouTube', $social_media_platforms) ? ' checked' : '' }} @endif>
                            <span>YouTube </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="social_media_platforms[]" value="Linkedin" @if($social_media_platforms != null) {{ in_array('Linkedin', $social_media_platforms) ? ' checked' : '' }} @endif>
                            <span>Linkedin </span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        @php
                            $target_audience = json_decode($smm_form->target_audience);
                        @endphp
                        <label for="target_audience">Target Audience</label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="target_audience[]" value="Male" @if($target_audience != null) {{ in_array('Male', $target_audience) ? ' checked' : '' }} @endif>
                            <span>Male </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="target_audience[]" value="Female" @if($target_audience != null) {{ in_array('Female', $target_audience) ? ' checked' : '' }} @endif>
                            <span>Female </span><span class="checkmark"></span>
                        </label>
                        <label class="checkbox checkbox-primary mt-2">
                            <input type="checkbox" name="target_audience[]" value="Both" @if($target_audience != null) {{ in_array('Both', $target_audience) ? ' checked' : '' }} @endif>
                            <span>Both </span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="target_locations">Target Locations (States, Cities)</label>
                        <input class="form-control" name="target_locations" id="target_locations" type="text" value="{{ old('target_locations', $smm_form->target_locations) }}" required/>
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="age_bracket">Age Bracket</label>
                        <input class="form-control" name="age_bracket" id="age_bracket" type="text" value="{{ old('age_bracket', $smm_form->age_bracket) }}" required/>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="represent_your_business">Please mention search terms or services that best represent your business</label>
                        <textarea class="form-control" name="represent_your_business" id="represent_your_business" required>{{ old('represent_your_business', $smm_form->represent_your_business) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="business_usp">What is your business USP (Unique Selling Points)?</label>
                        <textarea class="form-control" name="business_usp" id="business_usp" required>{{ old('business_usp', $smm_form->business_usp) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="do_not_want_us_to_use">Are there any topics, websites, information or keywords that you DO NOT want us to use?</label>
                        <textarea class="form-control" name="do_not_want_us_to_use" id="do_not_want_us_to_use" required>{{ old('do_not_want_us_to_use', $smm_form->do_not_want_us_to_use) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="competitors">Share pages of your competitors or other brands you are most inspired by</label>
                        <textarea class="form-control" name="competitors" id="competitors" required>{{ old('competitors', $smm_form->competitors) }}</textarea>
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
                    @foreach($smm_form->formfiles as $formfiles)
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

        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Additional information (optional)</div>
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="additional_comments">Describe your business / service / organization</label>
                        <textarea name="additional_comments" id="additional_comments" class="form-control">{{ old('additional_comments', $smm_form->additional_comments) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


@endsection

@push('scripts')
@endpush