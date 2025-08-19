@extends('layouts.app-member')
@section('title', 'Web Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Web Brief INV#{{$web_form->invoice->invoice_number}}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form web-brief-form" method="post" route="{{ route('client.web.form.update', $web_form->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Details</div>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="client_name">Client Name</label>
                        <input class="form-control" name="client_name" id="client_name" type="text" placeholder="{{ $web_form->user->name }} {{ $web_form->user->last_name }}" value="{{ $web_form->user->name }} {{ $web_form->user->last_name }}" required readonly/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="agent_name">Agent Name</label>
                        <input class="form-control" name="agent_name" id="agent_name" type="text" placeholder="{{ $web_form->invoice->sale->name }} {{ $web_form->invoice->sale->last_name }}" value="{{ $web_form->invoice->sale->name }} {{ $web_form->invoice->sale->last_name }}" readonly required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="brand_name">Brand Name</label>
                        <input class="form-control" name="brand_name" id="brand_name" type="text" placeholder="{{ $web_form->invoice->brands->name }}" value="{{ $web_form->invoice->brands->name }}" readonly required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Web Brief Form</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="business_name">Business Name</label>
                            <input type="text" class="form-control" id="business_name" placeholder="Enter Business Name" name="business_name" required value="{{ old('business_name', $web_form->business_name) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="website_address">Website address – or desired Domain(s)</label>
                            <input type="text" class="form-control" id="website_address" placeholder="Enter Website address – or desired Domain(s)" name="website_address" required value="{{ old('website_address', $web_form->website_address) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address" value="{{ old('address', $web_form->address) }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="decision_makers">Are there other decision makers? Please specify</label>
                            <textarea name="decision_makers" id="decision_makers" class="form-control" rows="4">{{ old('decision_makers', $web_form->decision_makers) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Tell me about Your Company</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="about_company">Please give me a brief overview of the company, what you do or produce?</label>
                            <textarea name="about_company" id="about_company" class="form-control" rows="4">{{ old('about_company', $web_form->decision_makers) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
        $purpose = json_decode($web_form->purpose);
        @endphp
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">What is the purpose of this site?</div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="products_service"> 
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="products_service" name="purpose[]" value="Explain your products and services" @if($purpose != null) {{ in_array('Explain your products and services', $purpose) ? ' checked' : '' }} @endif>Explain your products and services
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="bring_client">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="bring_client" name="purpose[]" value="Bring in new clients to your business" @if($purpose != null) {{ in_array('Bring in new clients to your business', $purpose) ? ' checked' : '' }} @endif>Bring in new clients to your business
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="news">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="news" name="purpose[]" value="Deliver news or calendar of events" @if($purpose != null) {{ in_array('Deliver news or calendar of events', $purpose) ? ' checked' : '' }} @endif>Deliver news or calendar of events
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="certain_subject">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="certain_subject" name="purpose[]" value="Provide your customers with information on a certain subject" @if($purpose != null) {{ in_array('Provide your customers with information on a certain subject', $purpose) ? ' checked' : '' }} @endif>Provide your customers with information on a certain subject
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="blog">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="blog" name="purpose[]" value="Create a blog that addresses specific topics or interests" @if($purpose != null) {{ in_array('Create a blog that addresses specific topics or interests', $purpose) ? ' checked' : '' }} @endif>Create a blog that addresses specific topics or interests
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="sell_product">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="sell_product" name="purpose[]" value="Sell a product or products online" @if($purpose != null) {{ in_array('Sell a product or products online', $purpose) ? ' checked' : '' }} @endif>Sell a product or products online
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="provide_support">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="provide_support" name="purpose[]" value="Provide support for current clients" @if($purpose != null) {{ in_array('Provide support for current clients', $purpose) ? ' checked' : '' }} @endif>Provide support for current clients
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Do you have a time frame or deadline to get this site online?</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="deadline">If you have a specific deadline, please state why?</label>
                            <textarea name="deadline" id="deadline" class="form-control" rows="4">{{ old('deadline', $web_form->deadline) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Target market</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="potential_clients">Who will visit this site? Describe your potential clients. (Young, old, demographics, etc) </label>
                            <textarea name="potential_clients" id="potential_clients" class="form-control" rows="4">{{ old('potential_clients', $web_form->potential_clients) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="competitor">Why do you believe site visitors should do business with you rather than with a competitor? What problem are you solving for them?</label>
                            <textarea name="competitor" id="competitor" class="form-control" rows="4">{{ old('competitor', $web_form->competitor) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
        $user_perform = json_decode($web_form->user_perform);
        @endphp
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">What action(s) should the user perform when visiting your site?</div>
                <div class="row">
                    <div class="col-lg-3">
                        <label for="call_you">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="call_you" name="user_perform[]" value="Call you" @if($user_perform != null) {{ in_array('Call you', $user_perform) ? ' checked' : '' }} @endif> Call You
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="contact_form">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="contact_form" name="user_perform[]" value="Fill out a contact form" @if($user_perform != null) {{ in_array('Fill out a contact form', $user_perform) ? ' checked' : '' }} @endif> Fill out a contact form
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="quote_form">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="quote_form" name="user_perform[]" value="Fill out a quote form" @if($user_perform != null) {{ in_array('Fill out a quote form', $user_perform) ? ' checked' : '' }} @endif> Fill out a quote form
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="mailing_list">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="mailing_list" name="user_perform[]" value="Sign up for your mailing list" @if($user_perform != null) {{ in_array('Sign up for your mailing list', $user_perform) ? ' checked' : '' }} @endif> Sign up for your mailing list
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="search_information">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="search_information" name="user_perform[]" value="Search for information" @if($user_perform != null) {{ in_array('Search for information', $user_perform) ? ' checked' : '' }} @endif> Search for information
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-3">
                        <label for="purchase_product">
                            <div class="formCheck purpose-box">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="purchase_product" name="user_perform[]" value="Purchase a product(s)" @if($user_perform != null) {{ in_array('Purchase a product(s)', $user_perform) ? ' checked' : '' }} @endif>Purchase a product(s)
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        @php
        $pages = json_decode($web_form->pages);
        @endphp
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Content  <div class="form-group"> <label for=""> What are you offering? Make a list of all the sections/pages you think that you'll need. (Samples below are just an example to get you started, please fill this out completely.)</label></div></div>
                <div class="row">
                    @if($pages == null)
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="page_one">Page</label>
                            <input type="text" class="form-control" id="page_one" placeholder="Enter Page Name" name="page[page_name][]" value="Home">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="content_notes_one">Content Notes</label>
                            <input type="text" class="form-control" id="content_notes_one" placeholder="Enter Content Notes" name="page[content_notes][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="page_two" placeholder="Enter Page Name" name="page[page_name][]" value="Contact Us">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="content_notes_two" placeholder="Enter Content Notes" name="page[content_notes][]" value="Form needed?">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="page_three" placeholder="Enter Page Name" name="page[page_name][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="content_notes_three" placeholder="Enter Content Notes" name="page[content_notes][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="page_four" placeholder="Enter Page Name" name="page[page_name][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="content_notes_four" placeholder="Enter Content Notes" name="page[content_notes][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="page_five" placeholder="Enter Page Name" name="page[page_name][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="content_notes_five" placeholder="Enter Content Notes" name="page[content_notes][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="page_six" placeholder="Enter Page Name" name="page[page_name][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="content_notes_six" placeholder="Enter Content Notes" name="page[content_notes][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="page_seven" placeholder="Enter Page Name" name="page[page_name][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="content_notes_seven" placeholder="Enter Content Notes" name="page[content_notes][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="page_eight" placeholder="Enter Page Name" name="page[page_name][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="content_notes_eight" placeholder="Enter Content Notes" name="page[content_notes][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="page_nine" placeholder="Enter Page Name" name="page[page_name][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="content_notes_nine" placeholder="Enter Content Notes" name="page[content_notes][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="page_ten" placeholder="Enter Page Name" name="page[page_name][]">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="content_notes_ten" placeholder="Enter Content Notes" name="page[content_notes][]">
                        </div>
                    </div>
                    @else
                    <div class="col-md-6">
                    @foreach($pages->page_name as $key => $page_name)
                        <div class="form-group">
                            @if($loop->first)
                            <label for="page_one">Page</label>
                            @endif
                            <input type="text" class="form-control" id="page_{{$key}}" placeholder="Enter Page Name" name="page[page_name][]" value="{{ $page_name }}">
                        </div>
                    @endforeach
                    </div>
                    <div class="col-md-6">
                    @foreach($pages->content_notes as $key => $content_notes)
                        <div class="form-group">
                            @if($loop->first)
                            <label for="content_notes_{{$key}}">Content Notes</label>
                            @endif
                            <input type="text" class="form-control" id="content_notes_{{$key}}" placeholder="Enter Content Notes" name="page[content_notes][]" value="{{ $content_notes }}">
                        </div>
                    @endforeach
                    </div>
                    <div class="w-100"></div>
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="written_content">Do you have the written content and images/photographs prepared for these pages? </label>
                            <input type="text" class="form-control" id="written_content" name="written_content" value="{{ old('written_content', $web_form->written_content) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="copywriting_photography_services">If not, will you need copywriting and photography services?</label>
                            <select name="copywriting_photography_services" class="form-control" id="copywriting_photography_services">
                                <option value="0" {{ $web_form->copywriting_photography_services == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $web_form->copywriting_photography_services == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cms_site">Are you willing to commit time/effort into learning how to use Content Management System (CMS) and edit your site?</label>
                            <select name="cms_site" class="form-control" id="cms_site">
                                <option value="0" {{ $web_form->cms_site == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $web_form->cms_site == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="re_design">Is this a site re-design?</label>
                            <select name="re_design" class="form-control" id="re_design">
                                <option value="0" {{ $web_form->re_design == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $web_form->re_design == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="working_current_site">If yes, can you please explain what is working and not working on your current site?</label>
                            <select name="working_current_site" class="form-control" id="working_current_site">
                                <option value="0" {{ $web_form->working_current_site == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $web_form->working_current_site == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    @php
                    $going_to_need = json_decode($web_form->going_to_need);
                    @endphp
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Are you going to need?</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="going_to_need_ecommerce">
                                        <div class="formCheck purpose-box">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="going_to_need_ecommerce" name="going_to_need[]" value="Ecommerce (sell products)" @if($going_to_need != null) {{ in_array('Ecommerce (sell products)', $going_to_need) ? ' checked' : '' }} @endif> Ecommerce (sell products)
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-lg-6">
                                    <label for="going_to_need_membership">
                                        <div class="formCheck purpose-box">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="going_to_need_membership" name="going_to_need[]" value="Membership of any kind" @if($going_to_need != null) {{ in_array('Membership of any kind', $going_to_need) ? ' checked' : '' }} @endif> Membership of any kind
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="additional_features">Are there any additional features that you would like for your site or things that you would like to add in the future? Please be as specific and detailed as possible.</label>
                            <textarea name="additional_features" id="additional_features" class="form-control" rows="4">{{ old('additional_features', $web_form->additional_features) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Design</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="feel_about_company">People are coming to your new site for the first time. How do you want them to feel about your company?</label>
                            <textarea name="feel_about_company" id="feel_about_company" class="form-control" rows="4">{{ old('feel_about_company', $web_form->feel_about_company) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="incorporated">Are there corporate colors, logo, fonts etc. <br>that should be incorporated? </label>
                            <textarea name="incorporated" id="incorporated" class="form-control" rows="4">{{ old('incorporated', $web_form->incorporated) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="need_designed">If you do not already have a logo, are you going to need one designed?</label>
                            <textarea name="need_designed" id="need_designed" class="form-control" rows="4">{{ old('need_designed', $web_form->need_designed) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="specific_look">Is there a specific look and feel that you have in mind?</label>
                            <textarea name="specific_look" id="specific_look" class="form-control" rows="4">{{ old('specific_look', $web_form->specific_look) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
        $competition = json_decode($web_form->competition);
        @endphp
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Websites of your closest competition <div class="form-group"><label>Please include at least 3 links of sites of your competition. What do you like and don't like about them? What would you like to differently or better?</label></div></div>
                <div class="row">
                    @if($competition == null)
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="competition_one" placeholder="Enter Competition 1" name="competition[]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="competition_two" placeholder="Enter Competition 2" name="competition[]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="competition_three" placeholder="Enter Competition 3" name="competition[]">
                        </div>
                    </div>
                    @else
                    @for($i = 0; $i < count($competition); $i++)
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="competition_{{$i}}" placeholder="Enter Competition {{$i+1}}" name="competition[]" value="{{ $competition[$i] }}">
                        </div>
                    </div>
                    @endfor
                    @endif
                </div>
            </div>
        </div>
        @php
        $websites_link = json_decode($web_form->websites_link);
        @endphp
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Websites that we like <div class="form-group"><label>Along with putting down the site address, please comment on what you like about each site, i.e. the look and feel, functionality, colors etc. These do not have to have anything to do with your business, but could have features you like. Please include at least 3 examples.</label></div></div>
                <div class="row">
                    @if($competition == null)
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="websites_link_one" placeholder="Enter Website 1" name="websites_link[]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="websites_link_two" placeholder="Enter Website 2" name="websites_link[]">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="websites_link_three" placeholder="Enter Website 3" name="websites_link[]">
                        </div>
                    </div>
                    @else
                    @for($i = 0; $i < count($websites_link); $i++)
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="websites_link_{{$i}}" placeholder="Enter Website {{$i+1}}" name="websites_link[]" value="{{ $websites_link[$i] }}">
                        </div>
                    </div>
                    @endfor
                    @endif
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Marketing the Site</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="people_find_business">How do people find out about your business right now?</label>
                            <input type="text" class="form-control" id="people_find_business" name="people_find_business" value="{{ old('people_find_business', $web_form->people_find_business) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="market_site">Have you thought about how you're going to market this site? </label>
                            <input type="text" class="form-control" id="market_site" name="market_site" value="{{ old('market_site', $web_form->market_site) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="accounts_setup">Do you have any social network accounts setup? (Facebook etc)</label>
                            <input type="text" class="form-control" id="accounts_setup" name="accounts_setup" value="{{ old('accounts_setup', $web_form->accounts_setup) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="links_accounts_setup">Do you want links to those accounts on your site?</label>
                            <input type="text" class="form-control" id="links_accounts_setup" name="links_accounts_setup" value="{{ old('links_accounts_setup', $web_form->links_accounts_setup) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="service_account">Do you have a mail service account? (Constant Contact, MailChimpetc)</label>
                            <input type="text" class="form-control" id="service_account" name="service_account" value="{{ old('service_account', $web_form->service_account) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="use_advertising">Will you want to build your mailing list and use it for advertising &amp; newsletters?</label>
                            <input type="text" class="form-control" id="use_advertising" name="use_advertising" value="{{ old('use_advertising', $web_form->use_advertising) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="printed_materials">Will you want printed materials (business cards, catalog, etc.) produced as well?</label>
                            <input type="text" class="form-control" id="printed_materials" name="printed_materials" value="{{ old('printed_materials', $web_form->printed_materials) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Domain and Hosting</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="domain_name">Do you already own a domain name(s)? (www.mygreatsite.com)</label>
                            <input type="text" class="form-control" id="domain_name" name="domain_name" value="{{ old('domain_name', $web_form->domain_name) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hosting_account">Do you have a hosting account already? (This is where the computer files live.)</label>
                            <input type="text" class="form-control" id="hosting_account" name="hosting_account" value="{{ old('hosting_account', $web_form->hosting_account) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="login_ip">If yes, do you have the login/IP information? </label>
                            <input type="text" class="form-control" id="login_ip" name="login_ip" value="{{ old('login_ip', $web_form->login_ip) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="domain_like_name">If no, what name(s) would you like?</label>
                            <input type="text" class="form-control" id="domain_like_name" name="domain_like_name" value="{{ old('domain_like_name', $web_form->domain_like_name) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Maintenance</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="section_regular_updating">Will there be sections that need regular updating? Which ones?</label>
                            <input type="text" class="form-control" id="section_regular_updating" name="section_regular_updating" value="{{ old('section_regular_updating', $web_form->section_regular_updating) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updating_yourself">Would you like to be able to do most of the updating yourself?</label>
                            <input type="text" class="form-control" id="updating_yourself" name="updating_yourself" value="{{ old('updating_yourself', $web_form->updating_yourself) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="blog_written">If you’re planning on writing a blog do you already have several things written?</label>
                            <input type="text" class="form-control" id="blog_written" name="blog_written" value="{{ old('blog_written', $web_form->blog_written) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regular_basis">Do you already write on a regular basis?</label>
                            <input type="text" class="form-control" id="regular_basis" name="regular_basis" value="{{ old('regular_basis', $web_form->regular_basis) }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="fugure_pages">Are there any features/pages that you don’t need now but may want in the future? Please be as specific and future thinking as possible.</label>
                            <textarea name="fugure_pages" id="fugure_pages" class="form-control" rows="4">{{ old('fugure_pages', $web_form->fugure_pages) }}</textarea>
                        </div>
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
                    @foreach($web_form->formfiles as $formfiles)
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
                        <textarea name="additional_information" id="additional_information" class="form-control" rows="4">{{ old('additional_information', $web_form->additional_information) }}</textarea>
                    </div>
                    <!-- <div class="col-md-12 mt-1">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div> -->
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@endpush