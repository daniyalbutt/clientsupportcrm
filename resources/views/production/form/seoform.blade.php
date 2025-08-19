@extends('layouts.app-production')
@section('title', 'SEO Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">SEO Brief INV#{{$seo_form->invoice->invoice_number}}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form" method="post" route="{{ route('client.logo.form.update', $seo_form->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">SEO Brief Form</div>
                <div class="row">
                    <div class="col-md-3 form-group mb-3">
                        <label for="company_name">Company Name</label>
                        <input class="form-control" name="company_name" id="company_name" type="text" value="{{ old('company_name', $seo_form->company_name) }}" required/>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="business_established">Business established Year? </label>
                        <input class="form-control" name="business_established" id="business_established" type="text" value="{{ old('business_established', $seo_form->business_established) }}" required/>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="original_owner">Are you the original owner? </label>
                        <input class="form-control" name="original_owner" id="original_owner" type="text"  value="{{ old('original_owner', $seo_form->original_owner) }}" required/>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="age_current_site">What is the age of the current site?</label>
                        <input class="form-control" name="age_current_site" id="age_current_site" type="text"  value="{{ old('age_current_site', $seo_form->age_current_site) }}" required/>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="top_goals">What are your top 3 goals that you want to achieve with your digital marketing within the next 6 months?</label>
                        <textarea class="form-control" name="top_goals" id="top_goals" rows="5" required>{{ old('top_goals', $seo_form->top_goals) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="core_offer">What's your core offer and how much does it cost?</label>
                        <textarea class="form-control" name="core_offer" id="core_offer" rows="5" required>{{ old('core_offer', $seo_form->core_offer) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="average_order_value">What's your Average Order Value?</label>
                        <textarea class="form-control" name="average_order_value" id="average_order_value" rows="5" required>{{ old('average_order_value', $seo_form->average_order_value) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="selling_per_month">Are you currently selling your offer? If so, how much are you selling per month?</label>
                        <textarea class="form-control" name="selling_per_month" id="selling_per_month" rows="5" required>{{ old('selling_per_month', $seo_form->selling_per_month) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="client_lifetime_value">What is your average client lifetime value?</label>
                        <textarea class="form-control" name="client_lifetime_value" id="client_lifetime_value" rows="5" required>{{ old('client_lifetime_value', $seo_form->client_lifetime_value) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="supplementary_offers">Do you have any supplementary offers that people can purchase if they buy your core offer?</label>
                        <textarea class="form-control" name="supplementary_offers" id="supplementary_offers" rows="5" required>{{ old('supplementary_offers', $seo_form->supplementary_offers) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="getting_clients">How are you getting clients? Can you explain your "traffic - lead - prospect - client" process? How is that process working for you?</label>
                        <textarea class="form-control" name="getting_clients" id="getting_clients" rows="5" required>{{ old('getting_clients', $seo_form->getting_clients) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="currently_spending">How much are you currently spending on paid traffic?</label>
                        <textarea class="form-control" name="currently_spending" id="currently_spending" rows="5" required>{{ old('currently_spending', $seo_form->currently_spending) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="monthly_visitors">How many total monthly visitors do you currently have?</label>
                        <textarea class="form-control" name="monthly_visitors" id="monthly_visitors" rows="5" required>{{ old('monthly_visitors', $seo_form->monthly_visitors) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="people_adding">How big is your email list, and how many people are you adding per day/month?</label>
                        <textarea class="form-control" name="people_adding" id="people_adding" rows="5" required>{{ old('people_adding', $seo_form->people_adding) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="monthly_financial">What are your monthly financial goals in the next 90 days and in the next 6 months or so?</label>
                        <textarea class="form-control" name="monthly_financial" id="monthly_financial" rows="5" required>{{ old('monthly_financial', $seo_form->monthly_financial) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="that_much">Why that much?</label>
                        <textarea class="form-control" name="that_much" id="that_much" rows="5" required>{{ old('that_much', $seo_form->that_much) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="specific_target">Who are your specific target markets/customers? Please be as specific as you can.</label>
                        <textarea class="form-control" name="specific_target" id="specific_target" rows="5" required>{{ old('specific_target', $seo_form->specific_target) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="competitors">Who are your top 3 competitors? (Please list domain names).</label>
                        <textarea class="form-control" name="competitors" id="competitors" rows="5" required>{{ old('competitors', $seo_form->competitors) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="third_party_marketing">Do you have any third-party marketing agencies that perform any marketing services for you? If so who are the agencies and what do they do?</label>
                        <textarea class="form-control" name="third_party_marketing" id="third_party_marketing" rows="5" required>{{ old('third_party_marketing', $seo_form->third_party_marketing) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="current_monthly_sales">What are your current monthly Sales? (in units)</label>
                        <textarea class="form-control" name="current_monthly_sales" id="current_monthly_sales" rows="5" required>{{ old('current_monthly_sales', $seo_form->current_monthly_sales) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="current_monthly_revenue">What is your Current Monthly Revenue?</label>
                        <textarea class="form-control" name="current_monthly_revenue" id="current_monthly_revenue" rows="5" required>{{ old('current_monthly_revenue', $seo_form->current_monthly_revenue) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="target_region">What region would you like to target?</label>
                        <textarea class="form-control" name="target_region" id="target_region" rows="5" required>{{ old('target_region', $seo_form->target_region) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="looking_to_execute">When are you looking to execute?</label>
                        <textarea class="form-control" name="looking_to_execute" id="looking_to_execute" rows="5" required>{{ old('looking_to_execute', $seo_form->looking_to_execute) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="time_zone">What Time Zone are you in?</label>
                        <textarea class="form-control" name="time_zone" id="time_zone" rows="5" required>{{ old('time_zone', $seo_form->time_zone) }}</textarea>
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
                    @foreach($seo_form->formfiles as $formfiles)
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