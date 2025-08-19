@extends('layouts.app-client')
@section('title', 'Brief Form')
@section('content')
<style>
    .nav-tabs .nav-item .nav-link {
        text-align: center;
        padding-right: 30px;
        padding-left: 30px;
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
    }
    .nav.nav-tabs li.nav-item.active a {
        color: #7f231c;
        background-color: #fdd9d7;
        border: 1px solid #fccac7;
    }

    .nav.nav-tabs li.nav-item {
        margin-right: 20px;
    }
    .nav.nav-tabs li.nav-item.active a.active {
        border: 1px solid transparent;
        background: rgba(102, 51, 153, 0.1);
        border-color: #0076c2 #0076c2 #fff;
    }
    .category-image-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .category-image-wrapper img {
    }
</style>
<div class="breadcrumb">
    <h1 class="mr-2">Brief Form</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Brief Pending Info</h4>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @php
                    $count = 0;
                    @endphp
                    @foreach($data as $key => $forms)
                    <li class="nav-item {{ (($forms->option == '') || ($forms->option == null) ? 'active' : '') }}">
                        <a class="nav-link {{ $count==0 ? 'active' : ''}}" id="form-brief-tab-{{$forms->invoice->invoice_number}}-{{$key}}" data-toggle="tab" href="#form-brief-{{$forms->invoice->invoice_number}}-{{$key}}" role="tab" aria-controls="form-brief-{{$forms->invoice->invoice_number}}-{{$key}}" aria-selected="true">
                            {{$forms->form_name}} Brief <span>INV# {{$forms->invoice->invoice_number}}</span>
                        </a>
                    </li>
                    @php
                    $count++;
                    @endphp
                    @endforeach
                </ul>
                <div class="tab-content pr-0 pl-0" id="myTabContent">
                    @php
                    $count = 0;
                    @endphp
                    @foreach($data as $key => $forms)
                    <div class="tab-pane fade {{ $count == 0 ? 'show active' : '' }}" id="form-brief-{{$forms->invoice->invoice_number}}-{{$key}}" role="tabpanel" aria-labelledby="form-brief-tab-{{$forms->invoice->invoice_number}}-{{$key}}">
                        @if($forms->form_type == 1)
                        <!-- Logo Form -->
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.logo.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Logo Brief Form</div>
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="logo_name">Exact logo wording ( logo name )</label>
                                            <input class="form-control" name="logo_name" id="logo_name" type="text" placeholder="Enter Logo Name" value="{{ old('logo_name', $forms->logo_name) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="slogan">Slogan/Tagline if any (optional)</label>
                                            <input class="form-control" name="slogan" id="slogan" type="text" placeholder="Enter Slogan/Tagline" value="{{ old('slogan', $forms->slogan) }}"/>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="business">Describe your business / service / organization</label>
                                            <textarea class="form-control" name="business" id="business" rows="5">{{ old('business', $forms->business) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Logo Categories</div>
                                    @php
                                    $logo_categories = json_decode($forms->logo_categories);
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="just_font">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="just_font" name="logo_categories[]" name="just_font" value="Just font" @if($logo_categories != null) {{ in_array('Just font', $logo_categories) ? ' checked' : '' }} @endif>
                                                        <h6>Just font</h6>
                                                        Just font without any symbolic intervention.
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/just_font.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="handmade">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="handmade" name="logo_categories[]" name="Handmade" value="Handmade" @if($logo_categories != null) {{ in_array('Handmade', $logo_categories) ? ' checked' : '' }} @endif>
                                                        <h6>Handmade</h6>
                                                        A calligraphic, handwritten or script font.
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/handmade.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="font_meaning">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="font_meaning" name="logo_categories[]" value="Font + meaning" @if($logo_categories != null) {{ in_array('Font + meaning', $logo_categories) ? ' checked' : '' }} @endif>
                                                        <h6>Font + meaning</h6>
                                                        A font with a tweak that simbolize company/ product/service
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/font_meaning.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="initials">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="initials" name="logo_categories[]" value="Initials" @if($logo_categories != null) {{ in_array('Initials', $logo_categories) ? ' checked' : '' }} @endif>
                                                        <h6>Initials</h6>
                                                        Monogram with Company name initials.
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/initials.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="font_including_shape">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="font_including_shape" name="logo_categories[]" value="Font including in a shape" @if($logo_categories != null) {{ in_array('Font including in a shape', $logo_categories) ? ' checked' : '' }} @endif>
                                                        <h6>Font including in a shape</h6>
                                                        Company name inside / squares / ovals / rectangles or combined shapes.
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/font_including_shape.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Icon Based Logo</div>
                                    @php
                                    $icon_based_logo = json_decode($forms->icon_based_logo);
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <label for="abstract_graphic">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="abstract_graphic" name="icon_based_logo[]" value="Abstract graphic" @if($icon_based_logo != null) {{ in_array('Abstract graphic', $icon_based_logo) ? ' checked' : '' }} @endif>
                                                        <h6>Abstract graphic</h6>
                                                        A sinthetic symbol that represents your Company in a subtle way
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/abstract_graphic.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="silhouet">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="silhouet" name="icon_based_logo[]" value="Silhouet" @if($icon_based_logo != null) {{ in_array('Silhouet', $icon_based_logo) ? ' checked' : '' }} @endif>
                                                        <h6>Silhouet</h6>
                                                        A detailed illustrated silhouet
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/silhouet.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="geometric_symbol">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="geometric_symbol" name="icon_based_logo[]" value="Geometric symbol" @if($icon_based_logo != null) {{ in_array('Geometric symbol', $icon_based_logo) ? ' checked' : '' }} @endif>
                                                        <h6>Geometric symbol</h6>
                                                        A geometric symbol that clearly represents an element.
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/geometric_symbol.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="illustrated_symbol">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="illustrated_symbol" name="icon_based_logo[]" value="Illustrated symbol" @if($icon_based_logo != null) {{ in_array('Illustrated symbol', $icon_based_logo) ? ' checked' : '' }} @endif>
                                                        <h6>Illustrated symbol</h6>
                                                        An illustrated symbol that clearly represents an element.
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/illustrated_symbol.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="detailed_illustration">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="detailed_illustration" name="icon_based_logo[]" value="Detailed illustration" @if($icon_based_logo != null) {{ in_array('Detailed illustration', $icon_based_logo) ? ' checked' : '' }} @endif>
                                                        <h6>Detailed illustration</h6>
                                                        A specific illustration.
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/detailed_illustration.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mascot">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="mascot" name="icon_based_logo[]" value="Mascot" @if($icon_based_logo != null) {{ in_array('Mascot', $icon_based_logo) ? ' checked' : '' }} @endif>
                                                        <h6>Mascot</h6>
                                                        A character representing your Company.
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/mascot.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="seals_and_crests">
                                                <div class="formCheck">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="seals_and_crests" name="icon_based_logo[]" value="Seals and crests" @if($icon_based_logo != null) {{ in_array('Seals and crests', $icon_based_logo) ? ' checked' : '' }} @endif>
                                                        <h6>Seals and crests</h6>
                                                        A detailed crest or seal with just text or maybe including graphics.
                                                    </div>
                                                    <img src="{{ asset('newglobal/images/seals_and_crests.png') }}">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Font Style</div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="comic" name="font_style" value="Comic" {{ $forms->font_style == 'Comic' ? 'checked' : '' }}>
                                                    <label for="comic" class="comic"><img src="{{ asset('newglobal/images/comic.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="stencil" name="font_style" value="Stencil" {{ $forms->font_style == 'Stencil' ? 'checked' : '' }}>
                                                    <label for="stencil" class="comic"><img src="{{ asset('newglobal/images/stencil.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="gothic" name="font_style" value="Gothic" {{ $forms->font_style == 'Gothic' ? 'checked' : '' }}>
                                                    <label for="gothic" class="comic"><img src="{{ asset('newglobal/images/gothic.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="decorative" name="font_style" value="Decorative" {{ $forms->font_style == 'Decorative' ? 'checked' : '' }}>
                                                    <label for="decorative" class="comic"><img src="{{ asset('newglobal/images/decorative.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="typewriter" name="font_style" value="Typewriter" {{ $forms->font_style == 'Typewriter' ? 'checked' : '' }}>
                                                    <label for="typewriter" class="comic"><img src="{{ asset('newglobal/images/typewriter.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="eroded" name="font_style" value="Eroded" {{ $forms->font_style == 'Eroded' ? 'checked' : '' }}>
                                                    <label for="eroded" class="comic"><img src="{{ asset('newglobal/images/eroded.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="graffiti" name="font_style" value="Graffiti" {{ $forms->font_style == 'Graffiti' ? 'checked' : '' }}>
                                                    <label for="graffiti" class="comic"><img src="{{ asset('newglobal/images/graffiti.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="pixelated" name="font_style" value="Pixelated" {{ $forms->font_style == 'Pixelated' ? 'checked' : '' }}>
                                                    <label for="pixelated" class="comic"><img src="{{ asset('newglobal/images/pixelated.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="retro" name="font_style" value="Retro" {{ $forms->font_style == 'Retro' ? 'checked' : '' }}>
                                                    <label for="retro" class="comic"><img src="{{ asset('newglobal/images/retro.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="techno" name="font_style" value="Techno" {{ $forms->font_style == 'Techno' ? 'checked' : '' }}>
                                                    <label for="techno" class="comic"><img src="{{ asset('newglobal/images/techno.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="sansserif" name="font_style" value="Sans serif" {{ $forms->font_style == 'Sans serif' ? 'checked' : '' }}>
                                                    <label for="sansserif" class="comic"><img src="{{ asset('newglobal/images/sansserif.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="serif" name="font_style" value="Serif" {{ $forms->font_style == 'Serif' ? 'checked' : '' }}>
                                                    <label for="serif" class="comic"><img src="{{ asset('newglobal/images/serif.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="calligraphy" name="font_style" value="Calligraphy" {{ $forms->font_style == 'Calligraphy' ? 'checked' : '' }}>
                                                    <label for="calligraphy" class="comic"><img src="{{ asset('newglobal/images/calligraphy.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="script" name="font_style" value="Script" {{ $forms->font_style == 'Script' ? 'checked' : '' }}>
                                                    <label for="script" class="comic"><img src="{{ asset('newglobal/images/script.jpg') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="formCheck font-box">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="handwritten" name="font_style" value="Handwritten" {{ $forms->font_style == 'Handwritten' ? 'checked' : '' }}>
                                                    <label for="handwritten" class="comic"><img src="{{ asset('newglobal/images/handwritten.jpg') }}"></label>
                                                </div>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title mb-3">Additional information (optional)</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="additional_information">Describe your business / service / organization</label>
                                            <textarea name="additional_information" id="additional_information" class="form-control">{{ old('additional_information', $forms->additional_information) }}</textarea>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 2)
                        <form class="col-md-12 brief-form web-brief-form p-0" method="post" action="{{ route('client.web.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Web Brief Form</div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="business_name">Business Name</label>
                                                <input type="text" class="form-control" id="business_name" placeholder="Enter Business Name" name="business_name" required value="{{ old('business_name', $forms->business_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="website_address">Website address – or desired Domain(s)</label>
                                                <input type="text" class="form-control" id="website_address" placeholder="Enter Website address – or desired Domain(s)" name="website_address" value="{{ old('website_address', $forms->website_address) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address" value="{{ old('address', $forms->address) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="decision_makers">Are there other decision makers? Please specify</label>
                                                <textarea name="decision_makers" id="decision_makers" class="form-control" rows="4">{{ old('decision_makers', $forms->decision_makers) }}</textarea>
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
                                                <textarea name="about_company" id="about_company" class="form-control" rows="4">{{ old('about_company', $forms->decision_makers) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                            $purpose = json_decode($forms->purpose);
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
                                                <textarea name="deadline" id="deadline" class="form-control" rows="4">{{ old('deadline', $forms->deadline) }}</textarea>
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
                                                <textarea name="potential_clients" id="potential_clients" class="form-control" rows="4">{{ old('potential_clients', $forms->potential_clients) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="competitor">Why do you believe site visitors should do business with you rather than with a competitor? What problem are you solving for them?</label>
                                                <textarea name="competitor" id="competitor" class="form-control" rows="4">{{ old('competitor', $forms->competitor) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                            $user_perform = json_decode($forms->user_perform);
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
                            $pages = json_decode($forms->pages);
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
                                                <input type="text" class="form-control" id="written_content" name="written_content" value="{{ old('written_content', $forms->written_content) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="copywriting_photography_services">If not, will you need copywriting and photography services?</label>
                                                <select name="copywriting_photography_services" class="form-control" id="copywriting_photography_services">
                                                    <option value="0" {{ $forms->copywriting_photography_services == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->copywriting_photography_services == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cms_site">Are you willing to commit time/effort into learning how to use Content Management System (CMS) and edit your site?</label>
                                                <select name="cms_site" class="form-control" id="cms_site">
                                                    <option value="0" {{ $forms->cms_site == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->cms_site == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="re_design">Is this a site re-design?</label>
                                                <select name="re_design" class="form-control" id="re_design">
                                                    <option value="0" {{ $forms->re_design == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->re_design == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="working_current_site">If yes, can you please explain what is working and not working on your current site?</label>
                                                <select name="working_current_site" class="form-control" id="working_current_site">
                                                    <option value="0" {{ $forms->working_current_site == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->working_current_site == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        @php
                                        $going_to_need = json_decode($forms->going_to_need);
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
                                                <textarea name="additional_features" id="additional_features" class="form-control" rows="4">{{ old('additional_features', $forms->additional_features) }}</textarea>
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
                                                <textarea name="feel_about_company" id="feel_about_company" class="form-control" rows="4">{{ old('feel_about_company', $forms->feel_about_company) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="incorporated">Are there corporate colors, logo, fonts etc. <br>that should be incorporated? </label>
                                                <textarea name="incorporated" id="incorporated" class="form-control" rows="4">{{ old('incorporated', $forms->incorporated) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="need_designed">If you do not already have a logo, are you going to need one designed?</label>
                                                <textarea name="need_designed" id="need_designed" class="form-control" rows="4">{{ old('need_designed', $forms->need_designed) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="specific_look">Is there a specific look and feel that you have in mind?</label>
                                                <textarea name="specific_look" id="specific_look" class="form-control" rows="4">{{ old('specific_look', $forms->specific_look) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                            $competition = json_decode($forms->competition);
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
                            $websites_link = json_decode($forms->websites_link);
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
                                                <input type="text" class="form-control" id="people_find_business" name="people_find_business" value="{{ old('people_find_business', $forms->people_find_business) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="market_site">Have you thought about how you're going to market this site? </label>
                                                <input type="text" class="form-control" id="market_site" name="market_site" value="{{ old('market_site', $forms->market_site) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="accounts_setup">Do you have any social network accounts setup? (Facebook etc)</label>
                                                <input type="text" class="form-control" id="accounts_setup" name="accounts_setup" value="{{ old('accounts_setup', $forms->accounts_setup) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="links_accounts_setup">Do you want links to those accounts on your site?</label>
                                                <input type="text" class="form-control" id="links_accounts_setup" name="links_accounts_setup" value="{{ old('links_accounts_setup', $forms->links_accounts_setup) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="service_account">Do you have a mail service account? (Constant Contact, MailChimpetc)</label>
                                                <input type="text" class="form-control" id="service_account" name="service_account" value="{{ old('service_account', $forms->service_account) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="use_advertising">Will you want to build your mailing list and use it for advertising &amp; newsletters?</label>
                                                <input type="text" class="form-control" id="use_advertising" name="use_advertising" value="{{ old('use_advertising', $forms->use_advertising) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="printed_materials">Will you want printed materials (business cards, catalog, etc.) produced as well?</label>
                                                <input type="text" class="form-control" id="printed_materials" name="printed_materials" value="{{ old('printed_materials', $forms->printed_materials) }}">
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
                                                <input type="text" class="form-control" id="domain_name" name="domain_name" value="{{ old('domain_name', $forms->domain_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="hosting_account">Do you have a hosting account already? (This is where the computer files live.)</label>
                                                <input type="text" class="form-control" id="hosting_account" name="hosting_account" value="{{ old('hosting_account', $forms->hosting_account) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="login_ip">If yes, do you have the login/IP information? </label>
                                                <input type="text" class="form-control" id="login_ip" name="login_ip" value="{{ old('login_ip', $forms->login_ip) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="domain_like_name">If no, what name(s) would you like?</label>
                                                <input type="text" class="form-control" id="domain_like_name" name="domain_like_name" value="{{ old('domain_like_name', $forms->domain_like_name) }}">
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
                                                <input type="text" class="form-control" id="section_regular_updating" name="section_regular_updating" value="{{ old('section_regular_updating', $forms->section_regular_updating) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="updating_yourself">Would you like to be able to do most of the updating yourself?</label>
                                                <input type="text" class="form-control" id="updating_yourself" name="updating_yourself" value="{{ old('updating_yourself', $forms->updating_yourself) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="blog_written">If you’re planning on writing a blog do you already have several things written?</label>
                                                <input type="text" class="form-control" id="blog_written" name="blog_written" value="{{ old('blog_written', $forms->blog_written) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="regular_basis">Do you already write on a regular basis?</label>
                                                <input type="text" class="form-control" id="regular_basis" name="regular_basis" value="{{ old('regular_basis', $forms->regular_basis) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="fugure_pages">Are there any features/pages that you don’t need now but may want in the future? Please be as specific and future thinking as possible.</label>
                                                <textarea name="fugure_pages" id="fugure_pages" class="form-control" rows="4">{{ old('fugure_pages', $forms->fugure_pages) }}</textarea>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                            <textarea name="additional_information" id="additional_information" class="form-control" rows="4">{{ old('additional_information', $forms->additional_information) }}</textarea>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 3)
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.smm.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Social Media Marketing Form</div>
                                    <div class="row">
                                    @php
                                        $desired_results = json_decode($forms->desired_results);
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
                                    <div class="card-title mb-3">Please provide the following information about your Business</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="">This information will be used to create your social profiles and establish the country of origin of your brand - In case the business in purely online, please provide P.O. Box address (however, mailing address remains mandatory)</label>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="business_name">Company/Business Name</label>
                                            <input class="form-control" name="business_name" id="business_name" type="text" value="{{ old('business_name', $forms->business_name) }}" required/>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="business_email_address">Business Email Address</label>
                                            <input class="form-control" name="business_email_address" id="business_email_address" type="email" value="{{ old('business_email_address', $forms->business_email_address) }}" />
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="business_phone_number">Business Phone Number</label>
                                            <input class="form-control" name="business_phone_number" id="business_phone_number" type="text" value="{{ old('business_phone_number', $forms->business_phone_number) }}"/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="business_mailing_address">Business Mailing Address ( Verification Purposes )</label>
                                            <input class="form-control" name="business_mailing_address" id="business_mailing_address" type="email" value="{{ old('business_mailing_address', $forms->business_mailing_address) }}"/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="business_location">Business Location</label>
                                            <input class="form-control" name="business_location" id="business_location" type="text" value="{{ old('business_location', $forms->business_location) }}"/>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="business_website_address">Business Website Address (URL)</label>
                                            <input class="form-control" name="business_website_address" id="business_website_address" type="text" value="{{ old('business_website_address', $forms->business_website_address) }}"/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="business_working_hours">Business Working Hours</label>
                                            <input class="form-control" name="business_working_hours" id="business_working_hours" type="text" value="{{ old('business_working_hours', $forms->business_working_hours) }}"/>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="business_category">Business Category/Industry (Real Estate, Education, IT, Retail etc)</label>
                                            <textarea class="form-control" name="business_category" id="business_category">{{ old('business_category', $forms->business_category) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Existing Social Media Platforms</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="">Please share links and credentials to your existing social media business pages (if any)</label>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="facebook_page">Link to Facebook Page</label>
                                            <input class="form-control" name="facebook_page" id="facebook_page" type="text" value="{{ old('facebook_page', $forms->facebook_page) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="instagram_page">Link to Instagram Page</label>
                                            <input class="form-control" name="instagram_page" id="instagram_page" type="text" value="{{ old('instagram_page', $forms->instagram_page) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="instagram_password">Instagram Password</label>
                                            <input class="form-control" name="instagram_password" id="instagram_password" type="text" value="{{ old('instagram_password', $forms->instagram_password) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="twitter_page">Link to Twitter Page</label>
                                            <input class="form-control" name="twitter_page" id="twitter_page" type="text" value="{{ old('twitter_page', $forms->twitter_page) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="twitter_password">Twitter Password</label>
                                            <input class="form-control" name="twitter_password" id="twitter_password" type="text" value="{{ old('twitter_password', $forms->twitter_password) }}" required/>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="linkedin_page">Link to LinkedIn Page</label>
                                            <input class="form-control" name="linkedin_page" id="linkedin_page" type="text" value="{{ old('linkedin_page', $forms->linkedin_page) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="pinterest_page">Link to Pinterest Page</label>
                                            <input class="form-control" name="pinterest_page" id="pinterest_page" type="text" value="{{ old('pinterest_page', $forms->pinterest_page) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="pinterest_password">Pinterest Password</label>
                                            <input class="form-control" name="pinterest_password" id="pinterest_password" type="text" value="{{ old('pinterest_password', $forms->pinterest_password) }}" required/>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="youtube_page">Link to YouTube Page</label>
                                            <input class="form-control" name="youtube_page" id="youtube_page" type="text" value="{{ old('youtube_page', $forms->youtube_page) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="gmail_address_youtube">Gmail Address for YouTube</label>
                                            <input class="form-control" name="gmail_address_youtube" id="gmail_address_youtube" type="text" value="{{ old('gmail_address_youtube', $forms->gmail_address_youtube) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="gmail_password_youtube">Gmail Password for YouTube</label>
                                            <input class="form-control" name="gmail_password_youtube" id="gmail_password_youtube" type="text" value="{{ old('gmail_password_youtube', $forms->gmail_password_youtube) }}" required/>
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Please mention Social Media platforms that you want to opt (consult your Account Manager)</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            @php
                                                $social_media_platforms = json_decode($forms->social_media_platforms);
                                            @endphp
                                            <label for="social_media_platforms">Check one or more of the following</label>
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
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Demographics</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="target_locations">Target Locations (States, Cities)</label>
                                            <input class="form-control" name="target_locations" id="target_locations" type="text" value="{{ old('target_locations', $forms->target_locations) }}" />
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            @php
                                                $target_audience = json_decode($forms->target_audience);
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
                                            <label for="age_bracket">Age Bracket</label>
                                            <input class="form-control" name="age_bracket" id="age_bracket" type="text" value="{{ old('age_bracket', $forms->age_bracket) }}" />
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="represent_your_business">Please mention keywords or online interests that best represent your audience</label>
                                            <textarea class="form-control" name="represent_your_business" id="represent_your_business">{{ old('represent_your_business', $forms->represent_your_business) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="business_usp">What is your business USP (Unique Selling Points)?</label>
                                            <textarea class="form-control" name="business_usp" id="business_usp">{{ old('business_usp', $forms->business_usp) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="do_not_want_us_to_use">Are there any topics, websites, information or keywords that you DO NOT want us to use?</label>
                                            <textarea class="form-control" name="do_not_want_us_to_use" id="do_not_want_us_to_use">{{ old('do_not_want_us_to_use', $forms->do_not_want_us_to_use) }}</textarea>
                                        </div>
                                        <!-- <div class="col-md-12 form-group mb-3">
                                            <label for="competitors">Share pages of your competitors or other brands you are most inspired by</label>
                                            <textarea class="form-control" name="competitors" id="competitors">{{ old('competitors', $forms->competitors) }}</textarea>
                                        </div> -->
                                        
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                            <textarea name="additional_comments" id="additional_comments" class="form-control">{{ old('additional_comments', $forms->additional_comments) }}</textarea>
                                        </div>
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 4)
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.content.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Content Writing Form</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="company_name">Company Name</label>
                                            <input class="form-control" name="company_name" id="company_name" type="text" value="{{ old('company_name', $forms->company_name) }}" required/>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="company_details">What is the origin, history, timeline, chronology, achievements, and future plans of your company? (Fill out as many as you can, please).</label>
                                            <textarea class="form-control" name="company_details" id="company_details" rows="5">{{ old('company_details', $forms->company_details) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="company_industry">What is the industry that your Business caters to?</label>
                                            <textarea class="form-control" name="company_industry" id="company_industry" rows="5">{{ old('company_industry', $forms->company_industry) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="company_reason">What is the reason behind what you do; passion? Heritage? Necessity?</label>
                                            <textarea class="form-control" name="company_reason" id="company_reason" rows="5">{{ old('company_reason', $forms->company_reason) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="company_products">Please list all products and services you provide?</label>
                                            <textarea class="form-control" name="company_products" id="company_products" rows="5">{{ old('company_products', $forms->company_products) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="short_description">Short description of your Business in your own words?</label>
                                            <textarea class="form-control" name="short_description" id="short_description" rows="5">{{ old('short_description', $forms->short_description) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="mission_statement">What is your mission statement?</label>
                                            <textarea class="form-control" name="mission_statement" id="mission_statement" rows="5">{{ old('mission_statement', $forms->mission_statement) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="keywords">List 10 or more keywords that best describe your Business</label>
                                            <textarea class="form-control" name="keywords" id="keywords" rows="5">{{ old('keywords', $forms->keywords) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="competitor">List three or more of your top competitor</label>
                                            <textarea class="form-control" name="competitor" id="competitor" rows="5">{{ old('competitor', $forms->competitor) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="company_business">In your words, what are the core strengths of your Business?</label>
                                            <textarea class="form-control" name="company_business" id="company_business" rows="5">{{ old('company_business', $forms->company_business) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="customers_accomplish">What do you think your customers accomplish by using your product/services?</label>
                                            <textarea class="form-control" name="customers_accomplish" id="customers_accomplish" rows="5">{{ old('customers_accomplish', $forms->customers_accomplish) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="company_sets">What sets your company apart from your competitors?</label>
                                            <textarea class="form-control" name="company_sets" id="company_sets" rows="5">{{ old('company_sets', $forms->company_sets) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="existing_taglines">Do you have any existing/preferred taglines and/or slogans that you would like us to use?</label>
                                            <textarea class="form-control" name="existing_taglines" id="existing_taglines" rows="5">{{ old('existing_taglines', $forms->existing_taglines) }}</textarea>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                    <div class="row">
                                        @if($forms->company_name == null)
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 5)
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.seo.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">SEO Brief Form</div>
                                    <div class="row">
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="company_name">Company Name</label>
                                            <input class="form-control" name="company_name" id="company_name" type="text" value="{{ old('company_name', $forms->company_name) }}" required/>
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="business_established">Business established Year? </label>
                                            <input class="form-control" name="business_established" id="business_established" type="text" value="{{ old('business_established', $forms->business_established) }}"/>
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="original_owner">Are you the original owner? </label>
                                            <input class="form-control" name="original_owner" id="original_owner" type="text"  value="{{ old('original_owner', $forms->original_owner) }}"/>
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="age_current_site">What is the age of the current site?</label>
                                            <input class="form-control" name="age_current_site" id="age_current_site" type="text"  value="{{ old('age_current_site', $forms->age_current_site) }}"/>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="top_goals">What are your top 3 goals that you want to achieve with your digital marketing within the next 6 months?</label>
                                            <textarea class="form-control" name="top_goals" id="top_goals" rows="5" >{{ old('top_goals', $forms->top_goals) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="core_offer">What's your core offer and how much does it cost?</label>
                                            <textarea class="form-control" name="core_offer" id="core_offer" rows="5" >{{ old('core_offer', $forms->core_offer) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="average_order_value">What's your Average Order Value?</label>
                                            <textarea class="form-control" name="average_order_value" id="average_order_value" rows="5" >{{ old('average_order_value', $forms->average_order_value) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="selling_per_month">Are you currently selling your offer? If so, how much are you selling per month?</label>
                                            <textarea class="form-control" name="selling_per_month" id="selling_per_month" rows="5" >{{ old('selling_per_month', $forms->selling_per_month) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="client_lifetime_value">What is your average client lifetime value?</label>
                                            <textarea class="form-control" name="client_lifetime_value" id="client_lifetime_value" rows="5" >{{ old('client_lifetime_value', $forms->client_lifetime_value) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="supplementary_offers">Do you have any supplementary offers that people can purchase if they buy your core offer?</label>
                                            <textarea class="form-control" name="supplementary_offers" id="supplementary_offers" rows="5" >{{ old('supplementary_offers', $forms->supplementary_offers) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="getting_clients">How are you getting clients? Can you explain your "traffic - lead - prospect - client" process? How is that process working for you?</label>
                                            <textarea class="form-control" name="getting_clients" id="getting_clients" rows="5" >{{ old('getting_clients', $forms->getting_clients) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="currently_spending">How much are you currently spending on paid traffic?</label>
                                            <textarea class="form-control" name="currently_spending" id="currently_spending" rows="5" >{{ old('currently_spending', $forms->currently_spending) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="monthly_visitors">How many total monthly visitors do you currently have?</label>
                                            <textarea class="form-control" name="monthly_visitors" id="monthly_visitors" rows="5" >{{ old('monthly_visitors', $forms->monthly_visitors) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="people_adding">How big is your email list, and how many people are you adding per day/month?</label>
                                            <textarea class="form-control" name="people_adding" id="people_adding" rows="5" >{{ old('people_adding', $forms->people_adding) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="monthly_financial">What are your monthly financial goals in the next 90 days and in the next 6 months or so?</label>
                                            <textarea class="form-control" name="monthly_financial" id="monthly_financial" rows="5" >{{ old('monthly_financial', $forms->monthly_financial) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="that_much">Why that much?</label>
                                            <textarea class="form-control" name="that_much" id="that_much" rows="5" >{{ old('that_much', $forms->that_much) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="specific_target">Who are your specific target markets/customers? Please be as specific as you can.</label>
                                            <textarea class="form-control" name="specific_target" id="specific_target" rows="5" >{{ old('specific_target', $forms->specific_target) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="competitors">Who are your top 3 competitors? (Please list domain names).</label>
                                            <textarea class="form-control" name="competitors" id="competitors" rows="5" >{{ old('competitors', $forms->competitors) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="third_party_marketing">Do you have any third-party marketing agencies that perform any marketing services for you? If so who are the agencies and what do they do?</label>
                                            <textarea class="form-control" name="third_party_marketing" id="third_party_marketing" rows="5" >{{ old('third_party_marketing', $forms->third_party_marketing) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="current_monthly_sales">What are your current monthly Sales? (in units)</label>
                                            <textarea class="form-control" name="current_monthly_sales" id="current_monthly_sales" rows="5" >{{ old('current_monthly_sales', $forms->current_monthly_sales) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="current_monthly_revenue">What is your Current Monthly Revenue?</label>
                                            <textarea class="form-control" name="current_monthly_revenue" id="current_monthly_revenue" rows="5" >{{ old('current_monthly_revenue', $forms->current_monthly_revenue) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="target_region">What region would you like to target?</label>
                                            <textarea class="form-control" name="target_region" id="target_region" rows="5" >{{ old('target_region', $forms->target_region) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="looking_to_execute">When are you looking to execute?</label>
                                            <textarea class="form-control" name="looking_to_execute" id="looking_to_execute" rows="5" >{{ old('looking_to_execute', $forms->looking_to_execute) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="time_zone">What Time Zone are you in?</label>
                                            <textarea class="form-control" name="time_zone" id="time_zone" rows="5" >{{ old('time_zone', $forms->time_zone) }}</textarea>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                    <div class="row">
                                        @if($forms->business_established == null)
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 6)
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.bookformatting.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Book Formatting & Publishing Brief Form</div>
                                    <div class="row">
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="book_title">What is the title of the book? <span>*</span></label>
                                            <input class="form-control" name="book_title" id="book_title" type="text" value="{{ old('book_title', $forms->book_title) }}" required/>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="book_subtitle">What is the subtitle of the book?</label>
                                            <input class="form-control" name="book_subtitle" id="book_subtitle" type="text" value="{{ old('book_subtitle', $forms->book_subtitle) }}"/>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="author_name">What is the name of the author? <span>*</span></label>
                                            <input class="form-control" name="author_name" id="author_name" type="text"  value="{{ old('author_name', $forms->author_name) }}" required/>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="contributors">Any additional contributors you would like to acknowledge? (e.g. Book Illustrator, Editor, etc.) <span>*</span></label>
                                            <textarea class="form-control" name="contributors" id="contributors" rows="5" required>{{ old('contributors', $forms->contributors) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Formatting Requirements</div>
                                    <p>Where do you want to? <span>*</span></p>
                                    @php
                                    $publish_your_book = json_decode($forms->publish_your_book);
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <label for="amazon_kdp" class="w-100"> 
                                                <div class="formCheck purpose-box font-box">
                                                    <div class="form-check ml-0 pl-0">
                                                        <input type="checkbox" class="form-check-input" id="amazon_kdp" name="publish_your_book[]" value="Amazon KDP" @if($publish_your_book != null) {{ in_array('Amazon KDP', $publish_your_book) ? ' checked' : '' }} @endif data-value="Where do you want to?" data-name="required">Amazon KDP
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="barnes_noble" class="w-100">
                                                <div class="formCheck purpose-box font-box">
                                                    <div class="form-check ml-0 pl-0">
                                                        <input type="checkbox" class="form-check-input" id="barnes_noble" name="publish_your_book[]" value="Barnes & Noble" @if($publish_your_book != null) {{ in_array('Barnes & Noble', $publish_your_book) ? ' checked' : '' }} @endif>Barnes & Noble
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="google_books" class="w-100"> 
                                                <div class="formCheck purpose-box font-box">
                                                    <div class="form-check ml-0 pl-0">
                                                        <input type="checkbox" class="form-check-input" id="google_books" name="publish_your_book[]" value="Google Books" @if($publish_your_book != null) {{ in_array('Google Books', $publish_your_book) ? ' checked' : '' }} @endif>Google Books
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="kobo" class="w-100"> 
                                                <div class="formCheck purpose-box font-box">
                                                    <div class="form-check ml-0 pl-0">
                                                        <input type="checkbox" class="form-check-input" id="kobo" name="publish_your_book[]" value="Kobo" @if($publish_your_book != null) {{ in_array('Kobo', $publish_your_book) ? ' checked' : '' }} @endif>Kobo
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="ingram_spark" class="w-100"> 
                                                <div class="formCheck purpose-box font-box">
                                                    <div class="form-check ml-0 pl-0">
                                                        <input type="checkbox" class="form-check-input" id="ingram_spark" name="publish_your_book[]" value="Ingram Spark" @if($publish_your_book != null) {{ in_array('Ingram Spark', $publish_your_book) ? ' checked' : '' }} @endif>Ingram Spark
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <p>Which formats do you want your book to be formatted on? <span>*</span></p>
                                    @php
                                    $book_formatted = json_decode($forms->book_formatted);
                                    @endphp
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <label for="ebook" class="w-100"> 
                                                <div class="formCheck purpose-box font-box">
                                                    <div class="form-check ml-0 pl-0">
                                                        <input type="checkbox" class="form-check-input" id="ebook" name="book_formatted[]" value="eBook" @if($book_formatted != null) {{ in_array('eBook', $book_formatted) ? ' checked' : '' }} @endif data-value="Which formats do you want your book to be formatted on?" data-name="required">eBook
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="paperback" class="w-100"> 
                                                <div class="formCheck purpose-box font-box">
                                                    <div class="form-check ml-0 pl-0">
                                                        <input type="checkbox" class="form-check-input" id="paperback" name="book_formatted[]" value="Paperback" @if($book_formatted != null) {{ in_array('Paperback', $book_formatted) ? ' checked' : '' }} @endif>Paperback
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="hardcover" class="w-100"> 
                                                <div class="formCheck purpose-box font-box">
                                                    <div class="form-check ml-0 pl-0">
                                                        <input type="checkbox" class="form-check-input" id="hardcover" name="book_formatted[]" value="Hardcover" @if($book_formatted != null) {{ in_array('Hardcover', $book_formatted) ? ' checked' : '' }} @endif>Hardcover
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <p>Which trim size do you want your book to be formatted on? <span>*</span></p>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="formCheck font-box">
                                                <div class="form-check pl-0">
                                                    <input type="radio" class="form-check-input" id="trim_size_1" name="trim_size" value="5_8" {{ $forms->trim_size == '5_8' ? 'checked' : '' }} data-value="Which trim size do you want your book to be formatted on?" data-name="required">
                                                    <label for="trim_size_1" class="comic">5″ X 8″</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="formCheck font-box">
                                                <div class="form-check pl-0">
                                                    <input type="radio" class="form-check-input" id="trim_size_2" name="trim_size" value="5.25_8" {{ $forms->trim_size == '5.25_8' ? 'checked' : '' }}>
                                                    <label for="trim_size_2" class="comic">5.25″ X 8″</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="formCheck font-box">
                                                <div class="form-check pl-0">
                                                    <input type="radio" class="form-check-input" id="trim_size_3" name="trim_size" value="5.5_8.5" {{ $forms->trim_size == '5.5_8.5' ? 'checked' : '' }}>
                                                    <label for="trim_size_3" class="comic">5.5″ X 8.5″</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="formCheck font-box">
                                                <div class="form-check pl-0">
                                                    <input type="radio" class="form-check-input" id="trim_size_4" name="trim_size" value="6_9" {{ $forms->trim_size == '6_9' ? 'checked' : '' }}>
                                                    <label for="trim_size_4" class="comic">6″ X 9″</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="formCheck font-box">
                                                <div class="form-check pl-0">
                                                    <input type="radio" class="form-check-input" id="trim_size_5" name="trim_size" value="8.5_11" {{ $forms->trim_size == '8.5_11' ? 'checked' : '' }}>
                                                    <label for="trim_size_5" class="comic">8.5″ X 11″</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="formCheck font-box">
                                                <div class="form-check pl-0">
                                                    <input type="radio" class="form-check-input" id="trim_size_6" name="trim_size" value="Other" {{ $forms->trim_size == 'Other' ? 'checked' : '' }}>
                                                    <label for="trim_size_6" class="comic">Other (Please specify)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 form-group mb-3">
                                            <label for="trim_size_7">If you have selected Other please specify the trim size you want your book to be formatted on.</label>
                                            <input class="form-control" name="other_trim_size" id="trim_size_7" type="text"  value="{{ old('other_trim_size', $forms->other_trim_size) }}"/>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="additional_instructions">Any Additional Instructions that you would like us to follow?</label>
                                            <textarea class="form-control" name="additional_instructions" id="additional_instructions" rows="5">{{ old('additional_instructions', $forms->additional_instructions) }}</textarea>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                    <div class="row">
                                        @if($forms->business_established == null)
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 7)
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.bookwriting.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Book Writing Brief Form</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="book_title">Do you have a desired book title?</label>
                                            <input class="form-control" name="book_title" id="book_title" type="text" value="{{ old('book_title', $forms->book_title) }}" required/>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="genre_book">What is the Genre of your book?</label>
                                            <textarea class="form-control" name="genre_book" id="genre_book" rows="5" >{{ old('genre_book', $forms->genre_book) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="brief_summary">Can you provide a brief summary of the book's content and theme?</label>
                                            <textarea class="form-control" name="brief_summary" id="brief_summary" rows="5" >{{ old('brief_summary', $forms->brief_summary) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="purpose">What is the purpose behind writing this book?</label>
                                            <textarea class="form-control" name="purpose" id="purpose" rows="5" >{{ old('purpose', $forms->purpose) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="target_audience">Who is the target audience for the book? </label>
                                            <textarea class="form-control" name="target_audience" id="target_audience" rows="5" >{{ old('target_audience', $forms->target_audience) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="desired_length">What is the desired length of the book (word count/pages)?</label>
                                            <textarea class="form-control" name="desired_length" id="desired_length" rows="5" >{{ old('desired_length', $forms->desired_length) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="specific_characters">Are there any specific characters or settings that need to be included in the book?</label>
                                            <textarea class="form-control" name="specific_characters" id="specific_characters" rows="5" >{{ old('specific_characters', $forms->specific_characters) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="specific_themes">Are there any specific themes or messages that need to be conveyed in the book?</label>
                                            <textarea class="form-control" name="specific_themes" id="specific_themes" rows="5" >{{ old('specific_themes', $forms->specific_themes) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="writing_style">What will be the writing style? (US or UK)</label>
                                            <textarea class="form-control" name="writing_style" id="writing_style" rows="5" >{{ old('writing_style', $forms->writing_style) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="specific_tone">Is there a specific tone or style that should be used in the book?</label>
                                            <textarea class="form-control" name="specific_tone" id="specific_tone" rows="5" >{{ old('specific_tone', $forms->specific_tone) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="existing_materials">Are there any existing materials, such as notes or outlines, that can be used in the book?</label>
                                            <textarea class="form-control" name="existing_materials" id="existing_materials" rows="5" >{{ old('existing_materials', $forms->existing_materials) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="existing_books">Are there any existing books, articles, or other works that should be used as reference or inspiration for the book?</label>
                                            <textarea class="form-control" name="existing_books" id="existing_books" rows="5" >{{ old('existing_books', $forms->existing_books) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="specific_deadlines">Are there any specific deadlines for the completion of the book?</label>
                                            <textarea class="form-control" name="specific_deadlines" id="specific_deadlines" rows="5" >{{ old('specific_deadlines', $forms->specific_deadlines) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="specific_instructions">Are there any other specific instructions or requirements that the client wants to include in the book?</label>
                                            <textarea class="form-control" name="specific_instructions" id="specific_instructions" rows="5" >{{ old('specific_instructions', $forms->specific_instructions) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="research">Is there any research that needs to be done for the book?</label>
                                            <textarea class="form-control" name="research" id="research" rows="5" >{{ old('research', $forms->research) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="specific_chapter">Are there any specific chapter-wise details or guidelines for the book?</label>
                                            <textarea class="form-control" name="specific_chapter" id="specific_chapter" rows="5" >{{ old('specific_chapter', $forms->specific_chapter) }}</textarea>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                    <div class="row">
                                        @if($forms->business_established == null)
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 8)
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.authorwebsite.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Author Website Client Questionnaire</div>
                                    <div class="row">
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="author_name">Author Name <span>*</span></label>
                                            <input class="form-control" name="author_name" id="author_name" type="text" value="{{ old('author_name', $forms->author_name) }}" required/>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="email_address">Email Address <span>*</span></label>
                                            <input class="form-control" name="email_address" id="email_address" type="email" value="{{ old('email_address', $forms->email_address) }}" required/>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="contact_number">Contact Number <span>*</span></label>
                                            <input class="form-control" name="contact_number" id="contact_number" type="text" value="{{ old('contact_number', $forms->contact_number) }}" required/>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="address">Address</label>
                                            <input class="form-control" name="address" id="address" type="text" value="{{ old('address', $forms->address) }}" />
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="postal_code">ZIP/Postal Code</label>
                                            <input class="form-control" name="postal_code" id="postal_code" type="text" value="{{ old('postal_code', $forms->postal_code) }}" />
                                        </div>
                                        <div class="col-md-3 form-group mb-3">
                                            <label for="city">City/State</label>
                                            <input class="form-control" name="city" id="city" type="text" value="{{ old('city', $forms->city) }}" />
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="desired_domain">Website Address or Desired Domain (example: www.JKRowling.com)</label>
                                            <input class="form-control" name="desired_domain" id="desired_domain" type="text" value="{{ old('desired_domain', $forms->desired_domain) }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Domain & Hosting</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="own_domain">Do you already own a domain name? for example www.StephenKing.com</label>
                                                <select name="own_domain" class="form-control" id="own_domain">
                                                    <option value="0" {{ $forms->own_domain == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->own_domain == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="login_ip">If yes, do you have the login/IP information? Kindly provide the login credentials.</label>
                                            <textarea class="form-control" name="login_ip" id="login_ip" rows="5">{{ old('login_ip', $forms->login_ip) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Tell Us About Yourself</div>
                                    <p>Skip this section if you have ordered an autobiography/biography.</p>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="brief_overview">Please give us a brief overview of your journey as an author – what's your story, what inspires you to be who you are etc.</label>
                                            <textarea class="form-control" name="brief_overview" id="brief_overview" rows="5">{{ old('brief_overview', $forms->brief_overview) }}</textarea>
                                        </div>
                                        @php
                                        $purpose = json_decode($forms->purpose);
                                        @endphp
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="purpose">What are the desired results that you want to get generated from this Social Media project? ( Check one or more of the following )</label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="purpose[]" value="Market your book" @if($purpose != null) {{ in_array('Market your book', $purpose) ? ' checked' : '' }} @endif>
                                                <span>Market your book </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="purpose[]" value="Deliver news or calendar of events" @if($purpose != null) {{ in_array('Deliver news or calendar of events', $purpose) ? ' checked' : '' }} @endif>
                                                <span>Deliver news or calendar of events </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="purpose[]" value="Create a portfolio for yourself" @if($purpose != null) {{ in_array('Create a portfolio for yourself', $purpose) ? ' checked' : '' }} @endif>
                                                <span>Create a portfolio for yourself </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="purpose[]" value="Sell signed copies of your book" @if($purpose != null) {{ in_array('Sell signed copies of your book', $purpose) ? ' checked' : '' }} @endif>
                                                <span>Sell signed copies of your book </span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="purpose_other">Other</label>
                                            <input class="form-control" name="purpose_other" id="purpose_other" type="text" value="{{ old('purpose_other', $forms->purpose_other) }}"/>
                                        </div>
                                        @php
                                        $user_perform = json_decode($forms->user_perform);
                                        @endphp
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="user_perform">What Action(s) Should The User Perform When Visiting Your Site?</label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="user_perform[]" value="Call you" @if($user_perform != null) {{ in_array('Call you', $user_perform) ? ' checked' : '' }} @endif>
                                                <span>Call you </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="user_perform[]" value="Fill out a contact form" @if($user_perform != null) {{ in_array('Fill out a contact form', $user_perform) ? ' checked' : '' }} @endif>
                                                <span>Fill out a contact form </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="user_perform[]" value="Fill out a quote form" @if($user_perform != null) {{ in_array('Fill out a quote form', $user_perform) ? ' checked' : '' }} @endif>
                                                <span>Fill out a quote form </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="user_perform[]" value="Sign up for your mailing list" @if($user_perform != null) {{ in_array('Sign up for your mailing list', $user_perform) ? ' checked' : '' }} @endif>
                                                <span>Sign up for your mailing list </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="user_perform[]" value="Book you as a speaker at an event" @if($user_perform != null) {{ in_array('Book you as a speaker at an event', $user_perform) ? ' checked' : '' }} @endif>
                                                <span>Book you as a speaker at an event </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="user_perform[]" value="Purchase a book/product" @if($user_perform != null) {{ in_array('Purchase a book/product', $user_perform) ? ' checked' : '' }} @endif>
                                                <span>Purchase a book/product </span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="user_perform_other">Other</label>
                                            <input class="form-control" name="user_perform_other" id="user_perform_other" type="text" value="{{ old('user_perform_other', $forms->user_perform_other) }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Website Design</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="feel_website">People are coming to your new site for the first time. How do you want to feel about your website?</label>
                                            <textarea class="form-control" name="feel_website" id="feel_website" rows="5">{{ old('feel_website', $forms->feel_website) }}</textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="have_logo">If you do not already have a logo, are you going to need one designed?</label>
                                                <select name="have_logo" class="form-control" id="have_logo">
                                                    <option value="0" {{ $forms->have_logo == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->have_logo == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="specific_look">Is there a specific look and feel (of your author website) that you have in mind?</label>
                                                <select name="specific_look" class="form-control" id="specific_look">
                                                    <option value="0" {{ $forms->specific_look == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->specific_look == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="feel_website">Competitor Websites – Any Other Author Websites You May Have Liked</label>
                                            <p class="mb-1">Have you seen any other existing author websites on the internet which you liked? Tell us what you liked about them and what would you like us to do differently. Share up to 3 links of author websites you liked.</p>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="competitor_website_link_1">Link 1</label>
                                            <input class="form-control" name="competitor_website_link_1" id="competitor_website_link_1" type="text" value="{{ old('competitor_website_link_1', $forms->competitor_website_link_1) }}" />
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="competitor_website_link_2">Link 2</label>
                                            <input class="form-control" name="competitor_website_link_2" id="competitor_website_link_2" type="text" value="{{ old('competitor_website_link_2', $forms->competitor_website_link_2) }}" />
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label for="competitor_website_link_3">Link 3</label>
                                            <input class="form-control" name="competitor_website_link_3" id="competitor_website_link_3" type="text" value="{{ old('competitor_website_link_3', $forms->competitor_website_link_3) }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Content</div>
                                    <div class="row">
                                    @php
                                        $pages_sections = json_decode($forms->pages_sections);
                                    @endphp
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="pages_sections">What are the desired results that you want to get generated from this Social Media project? ( Check one or more of the following )</label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="pages_sections[]" value="Home" @if($pages_sections != null) {{ in_array('Home', $pages_sections) ? ' checked' : '' }} @endif>
                                                <span>Home </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="pages_sections[]" value="About the Author (with Name i.e. About Myrlande Sauveur)" @if($pages_sections != null) {{ in_array('About the Author (with Name i.e. About Myrlande Sauveur)', $pages_sections) ? ' checked' : '' }} @endif>
                                                <span>About the Author (with Name i.e. About Myrlande Sauveur) </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="pages_sections[]" value="Books" @if($pages_sections != null) {{ in_array('Books', $pages_sections) ? ' checked' : '' }} @endif>
                                                <span>Books </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="pages_sections[]" value="Reviews" @if($pages_sections != null) {{ in_array('Reviews', $pages_sections) ? ' checked' : '' }} @endif>
                                                <span>Reviews </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="pages_sections[]" value="Blogs" @if($pages_sections != null) {{ in_array('Blogs', $pages_sections) ? ' checked' : '' }} @endif>
                                                <span>Blogs </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="pages_sections[]" value="Events" @if($pages_sections != null) {{ in_array('Events', $pages_sections) ? ' checked' : '' }} @endif>
                                                <span>Events </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="pages_sections[]" value="Gallery & Videos" @if($pages_sections != null) {{ in_array('Gallery & Videos', $pages_sections) ? ' checked' : '' }} @endif>
                                                <span>Gallery & Videos </span><span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Written Content & Images</div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="written_content">Do you already have written content and images/photographs for all these pages you selected above?</label>
                                                <select name="written_content" class="form-control" id="written_content">
                                                    <option value="0" {{ $forms->written_content == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->written_content == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="need_copywriting">If not, do you need copywriting and photography services?</label>
                                                <select name="need_copywriting" class="form-control" id="need_copywriting">
                                                    <option value="0" {{ $forms->need_copywriting == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->need_copywriting == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="cms_site">Are you willing/interested in committing time/effort into learning how to use Content Management System (CMS) and edit your site yourself in future?</label>
                                                <select name="cms_site" class="form-control" id="cms_site">
                                                    <option value="0" {{ $forms->cms_site == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->cms_site == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="existing_site">Do you have an existing site and want to get it redesigned?</label>
                                                <select name="existing_site" class="form-control" id="existing_site">
                                                    <option value="0" {{ $forms->existing_site == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->existing_site == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Marketing Your Website</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="about_your_book">How do people find out about you or your books right now? [Google, social media, etc]</label>
                                            <textarea class="form-control" name="about_your_book" id="about_your_book" rows="5">{{ old('about_your_book', $forms->about_your_book) }}</textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="social_networks">Do you have any social networks accounts setup?</label>
                                                <select name="social_networks" class="form-control" id="social_networks">
                                                    <option value="0" {{ $forms->social_networks == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->social_networks == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="social_linked">Do you want all your social media accounts to be linked on your site?</label>
                                                <select name="social_linked" class="form-control" id="social_linked">
                                                    <option value="0" {{ $forms->social_linked == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->social_linked == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="social_marketing">Will you like us to provide social media marketing services?</label>
                                                <select name="social_marketing" class="form-control" id="social_marketing">
                                                    <option value="0" {{ $forms->social_marketing == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->social_marketing == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="advertising_book">Do you want to build your mailing list and use it for advertising your book?</label>
                                                <select name="advertising_book" class="form-control" id="advertising_book">
                                                    <option value="0" {{ $forms->advertising_book == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->advertising_book == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">Website Maintenance</div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="regular_updating">Will there be sections in your website that would need regular updating?</label>
                                                <select name="regular_updating" class="form-control" id="regular_updating">
                                                    <option value="0" {{ $forms->regular_updating == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->regular_updating == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="updating_yourself">Would you like to be able to do most of the updating yourself?</label>
                                                <select name="updating_yourself" class="form-control" id="updating_yourself">
                                                    <option value="0" {{ $forms->updating_yourself == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->updating_yourself == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="already_written">If you are planning on writing a blog, do you have several pieces already written? Do you already write on a regular basis?</label>
                                                <select name="already_written" class="form-control" id="already_written">
                                                    <option value="0" {{ $forms->already_written == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->already_written == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="features_pages">Are there any features/pages which you don’t need right now but may want in the future? Please be as specific and future thinking as possible.</label>
                                                <select name="features_pages" class="form-control" id="features_pages">
                                                    <option value="0" {{ $forms->features_pages == 0 ? 'selected' : ''}}>No</option>
                                                    <option value="1" {{ $forms->features_pages == 1 ? 'selected' : ''}}>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">What a typical homepage for an author website include?</div>
                                    <div class="row">
                                    @php
                                        $typical_homepage = json_decode($forms->typical_homepage);
                                    @endphp
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="typical_homepage">Website include</label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="typical_homepage[]" value="Three to six sliding banners with different quotes and pictures." @if($typical_homepage != null) {{ in_array('Three to six sliding banners with different quotes and pictures.', $typical_homepage) ? ' checked' : '' }} @endif>
                                                <span>Three to six sliding banners with different quotes and pictures. </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="typical_homepage[]" value="A display section for all the books available for the author." @if($typical_homepage != null) {{ in_array('A display section for all the books available for the author.', $typical_homepage) ? ' checked' : '' }} @endif>
                                                <span>A display section for all the books available for the author. </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="typical_homepage[]" value="About the author section – including author’s bio/mission/lifestory." @if($typical_homepage != null) {{ in_array('About the author section – including author’s bio/mission/lifestory.', $typical_homepage) ? ' checked' : '' }} @endif>
                                                <span>About the author section – including author’s bio/mission/lifestory. </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="typical_homepage[]" value="Book Section – including book covers with synopisis." @if($typical_homepage != null) {{ in_array('Book Section – including book covers with synopisis.', $typical_homepage) ? ' checked' : '' }} @endif>
                                                <span>Book Section – including book covers with synopisis. </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="typical_homepage[]" value="Gallery – a collection of photographs and images [optional]" @if($typical_homepage != null) {{ in_array('Gallery – a collection of photographs and images [optional]', $typical_homepage) ? ' checked' : '' }} @endif>
                                                <span>Gallery – a collection of photographs and images [optional] </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="typical_homepage[]" value="Videos – E-book trailer [Optional]" @if($typical_homepage != null) {{ in_array('Videos – E-book trailer [Optional]', $typical_homepage) ? ' checked' : '' }} @endif>
                                                <span>Videos – E-book trailer [Optional] </span><span class="checkmark"></span>
                                            </label>
                                            <label class="checkbox checkbox-primary mt-2">
                                                <input type="checkbox" name="typical_homepage[]" value="Contact details and footer." @if($typical_homepage != null) {{ in_array('Contact details and footer.', $typical_homepage) ? ' checked' : '' }} @endif>
                                                <span>Contact details and footer. </span><span class="checkmark"></span>
                                            </label>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                    <div class="row">
                                        @if($forms->business_established == null)
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 9)
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.proofreading.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="card-title mb-3">{{ $forms->form_name }}</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="description">Can you provide a brief description of the book you would like to have edited and proofread? <span>*</span></label>
                                            <textarea class="form-control" name="description" id="description" rows="5" required>{{ old('description', $forms->description) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="word_count">What is the word count of your book?<span>*</span></label>
                                            <textarea class="form-control" name="word_count" id="word_count" rows="5" required>{{ old('word_count', $forms->word_count) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="services">What type of editing and proofreading services are you looking for (e.g. developmental editing, line editing, copyediting, proofreading, etc.)?<span>*</span></label>
                                            <textarea class="form-control" name="services" id="services" rows="5" required>{{ old('services', $forms->services) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="completion">Do you have a specific deadline for the completion of the editing and proofreading services?<span>*</span></label>
                                            <textarea class="form-control" name="completion" id="completion" rows="5" required>{{ old('completion', $forms->completion) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="previously">Have you edited the book yourself or had it edited previously?<span>*</span></label>
                                            <textarea class="form-control" name="previously" id="previously" rows="5" required>{{ old('previously', $forms->previously) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="specific_areas">Are there any specific areas or elements that you would like the editor to pay close attention to (e.g. grammar, tone, character development, etc.)?<span>*</span></label>
                                            <textarea class="form-control" name="specific_areas" id="specific_areas" rows="5" required>{{ old('specific_areas', $forms->specific_areas) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="suggestions">Would you like to receive suggestions or feedback from the editor regarding the content of the book?<span>*</span></label>
                                            <textarea class="form-control" name="suggestions" id="suggestions" rows="5" required>{{ old('suggestions', $forms->suggestions) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="mention">Is there anything else you would like to mention or specify regarding the editing and proofreading services you require?<span>*</span></label>
                                            <textarea class="form-control" name="mention" id="mention" rows="5" required>{{ old('mention', $forms->mention) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="major">Are there any major plot points we need to know?<span>*</span></label>
                                            <textarea class="form-control" name="major" id="major" rows="5" required>{{ old('major', $forms->major) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="trigger">Are there any trigger warnings, or are there any sections we should avoid while editing?<span>*</span></label>
                                            <textarea class="form-control" name="trigger" id="trigger" rows="5" required>{{ old('trigger', $forms->trigger) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="character">Please provide the main character details or anything else we should know ahead of time.<span>*</span></label>
                                            <textarea class="form-control" name="character" id="character" rows="5" required>{{ old('character', $forms->character) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="guide">Which style guide would you like us to use?<span>*</span></label>
                                            <textarea class="form-control" name="guide" id="guide" rows="5" required>{{ old('guide', $forms->guide) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="areas">Do you have any specific areas you'd like us to edit?<span>*</span></label>
                                            <textarea class="form-control" name="areas" id="areas" rows="5" required>{{ old('areas', $forms->areas) }}</textarea>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                    <div class="row">
                                        @if($forms->business_established == null)
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 10)
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.bookcover.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body mb-4">
                                    <div class="card-title mb-3">{{ $forms->form_name }}</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="title">Title of the book (Exact Wording) <span>*</span></label>
                                            <input type="text" name="title" class="form-control" value="{{ old('title', $forms->title) }}" required>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="subtitle">Subtitle/Tagline if any (Optional)</label>
                                            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $forms->subtitle) }}">
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="author">Name of the Author<span>*</span></label>
                                            <input type="text" name="author" class="form-control" value="{{ old('author', $forms->author) }}" required>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="genre">What is the Genre of the book?</label>
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="formCheck font-box mb-0">
                                                        <div class="form-check pl-0">
                                                            <input type="radio" class="form-check-input" id="genre_1" name="genre" value="fiction" {{ $forms->genre == 'fiction' ? 'checked' : '' }}>
                                                            <label for="genre_1" class="genre">Fiction</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="formCheck font-box mb-0">
                                                        <div class="form-check pl-0">
                                                            <input type="radio" class="form-check-input" id="genre_2" name="genre" value="non-fiction" {{ $forms->genre == 'non-fiction' ? 'checked' : '' }}>
                                                            <label for="genre_2" class="genre">Non Fiction</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="isbn">Do you have an ISBN Number? Or do you need one?<span>*</span></label>
                                            <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $forms->isbn) }}" required>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="trim_size">Book Trim Size<span>*</span></label>
                                            <input type="text" name="trim_size" class="form-control" value="{{ old('trim_size', $forms->trim_size) }}" required>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="explain">Explain your book cover concept that you would like us to follow?<span>*</span></label>
                                            <textarea class="form-control" name="explain" id="explain" rows="5" required>{{ old('explain', $forms->explain) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="information">Provide the information for Back Cover. This information will be added to the back cover.<span>*</span></label>
                                            <textarea class="form-control" name="information" id="information" rows="5" required>{{ old('information', $forms->information) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="about">What is your book about?<span>*</span></label>
                                            <textarea class="form-control" name="about" id="about" rows="5" required>{{ old('about', $forms->about) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="keywords">Keywords that define your book.<span>*</span></label>
                                            <textarea class="form-control" name="keywords" id="keywords" rows="5" required>{{ old('keywords', $forms->keywords) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="images_provide">Any images you would like us to use or provide for reference?<span>*</span></label>
                                            <textarea class="form-control" name="images_provide" id="images_provide" rows="5" required>{{ old('images_provide', $forms->images_provide) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="category">Select one of the style category that you want us to follow for your book cover<span>*</span></label>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/picture_based_1.jpg') }}" alt="Picture Based">
                                                                <img src="{{ asset('newglobal/images/picture_based_2.jpg') }}" alt="Picture Based">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_1" name="category" value="picture_based" {{ $forms->category == 'picture_based' ? 'checked' : '' }}>
                                                            <label for="category_1" class="genre">Picture Based</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/text_based_1.jpg') }}" alt="Text Based">
                                                                <img src="{{ asset('newglobal/images/text_based_2.jpg') }}" alt="Text Based">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_2" name="category" value="text_based" {{ $forms->category == 'text_based' ? 'checked' : '' }}>
                                                            <label for="category_2" class="genre">Text Based</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/picture_collage_1.jpg') }}" alt="Picture Collage">
                                                                <img src="{{ asset('newglobal/images/picture_collage_2.jpg') }}" alt="Picture Collage">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_3" name="category" value="picture_collage" {{ $forms->category == 'picture_collage' ? 'checked' : '' }}>
                                                            <label for="category_3" class="genre">Picture Collage</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/illustration_1.jpg') }}" alt="Illustration">
                                                                <img src="{{ asset('newglobal/images/illustration_2.jpg') }}" alt="Illustration">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_4" name="category" value="illustration" {{ $forms->category == 'illustration' ? 'checked' : '' }}>
                                                            <label for="category_4" class="genre">Illustration</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/abstract_1.jpg') }}" alt="Abstract">
                                                                <img src="{{ asset('newglobal/images/abstract_2.jpg') }}" alt="Abstract">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_5" name="category" value="abstract" {{ $forms->category == 'abstract' ? 'checked' : '' }}>
                                                            <label for="category_5" class="genre">Abstract</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/notebook_1.jpg') }}" alt="Notebook">
                                                                <img src="{{ asset('newglobal/images/notebook_2.jpg') }}" alt="Notebook">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_6" name="category" value="notebook" {{ $forms->category == 'notebook' ? 'checked' : '' }}>
                                                            <label for="category_6" class="genre">Notebook</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/fictional_1.jpg') }}" alt="Fictional">
                                                                <img src="{{ asset('newglobal/images/fictional_2.jpg') }}" alt="Fictional">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_7" name="category" value="fictional" {{ $forms->category == 'fictional' ? 'checked' : '' }}>
                                                            <label for="category_7" class="genre">Fictional</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/vintage_1.jpg') }}" alt="Vintage">
                                                                <img src="{{ asset('newglobal/images/vintage_2.jpg') }}" alt="Vintage">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_8" name="category" value="vintage" {{ $forms->category == 'vintage' ? 'checked' : '' }}>
                                                            <label for="category_8" class="genre">Vintage</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/religious_1.jpg') }}" alt="Religious">
                                                                <img src="{{ asset('newglobal/images/religious_2.jpg') }}" alt="Religious">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_9" name="category" value="religious" {{ $forms->category == 'religious' ? 'checked' : '' }}>
                                                            <label for="category_9" class="genre">Religious</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="formCheck font-box">
                                                        <div class="form-check pl-0">
                                                            <div class="category-image-wrapper">
                                                                <img src="{{ asset('newglobal/images/creative_illustration_1.jpg') }}" alt="Creative Illustration">
                                                                <img src="{{ asset('newglobal/images/creative_illustration_2.jpg') }}" alt="Creative Illustration">
                                                            </div>
                                                            <input type="radio" class="form-check-input" id="category_10" name="category" value="creative_illustration" {{ $forms->category == 'creative_illustration' ? 'checked' : '' }}>
                                                            <label for="category_10" class="genre">Creative Illustration</label>
                                                        </div>
                                                    </div>
                                                </div>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                    <div class="row">
                                        @if($forms->business_established == null)
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        @elseif($forms->form_type == 11)
                        <form class="col-md-12 brief-form p-0" method="post" action="{{ route('client.bookmarketing.form.update', $forms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-4">
                                <div class="card-body mb-4">
                                    <div class="card-title mb-3">{{ $forms->form_name }}</div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="title">What is the title of your book, and which Genre does it belong to? <span>*</span></label>
                                            <input type="text" name="title" class="form-control" value="{{ old('title', $forms->title) }}" required>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="behind_title">What is the meaning behind the title?</label>
                                            <input type="text" name="behind_title" class="form-control" value="{{ old('behind_title', $forms->behind_title) }}">
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="key_message">What is your key message? <span>*</span></label>
                                            <input type="text" name="key_message" class="form-control" value="{{ old('key_message', $forms->key_message) }}" required>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="giveaways">Are you offering any giveaways/products to first-time buyers of your book/store? What are their top features or benefits? <span>*</span></label>
                                            <textarea class="form-control" name="giveaways" id="giveaways" rows="5" required>{{ old('giveaways', $forms->giveaways) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="target_audience">Describe your primary and secondary target audience (their ages, where they are located, their pain points, concerns, interests, etc.) <span>*</span></label>
                                            <textarea class="form-control" name="target_audience" id="target_audience" rows="5" required>{{ old('target_audience', $forms->target_audience) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="launched">Is your book already Launched? If not then what is the expected launch date?</label>
                                            <input type="text" name="launched" class="form-control" value="{{ old('launched', $forms->launched) }}">
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="published_book">Have you published your book online already or do you want us to do it? If you have published it then what are the platforms you have covered? <span>*</span></label>
                                            <textarea class="form-control" name="published_book" id="published_book" rows="5" required>{{ old('published_book', $forms->published_book) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="sold_book">Have you sold any books so far? If yes, then what is the number of books sold?</label>
                                            <textarea class="form-control" name="sold_book" id="sold_book" rows="5">{{ old('sold_book', $forms->sold_book) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="marketing">What will be the start date of your marketing project?</label>
                                            <textarea class="form-control" name="marketing" id="marketing" rows="5">{{ old('marketing', $forms->marketing) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="author_name">Please mention the name of the author(s) and details about their past writing experience(if any) or if they have already written/published a book before? <span>*</span></label>
                                            <textarea class="form-control" name="author_name" id="author_name" rows="5" required>{{ old('author_name', $forms->author_name) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="social_pages">Have you created any social pages/accounts for your book already? If yes then please share the platform list.</label>
                                            <textarea class="form-control" name="social_pages" id="social_pages" rows="5">{{ old('social_pages', $forms->social_pages) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="basics">Do you know the basics about how to run Facebook, Google, YouTube ads and Amazon PPC ads?</label>
                                            <textarea class="form-control" name="basics" id="basics" rows="5">{{ old('basics', $forms->basics) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="selling_point">What is your selling point? How your book is different? What is special in it for the readers? <span>*</span></label>
                                            <textarea class="form-control" name="selling_point" id="selling_point" rows="5" required>{{ old('selling_point', $forms->selling_point) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="keywords">What are the keywords that your target audience might use to search online for a book like yours? <span>*</span></label>
                                            <textarea class="form-control" name="keywords" id="keywords" rows="5" required>{{ old('keywords', $forms->keywords) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="goals">What are the goals you have in your mind to achieve from this book?</label>
                                            <textarea class="form-control" name="goals" id="goals" rows="5">{{ old('goals', $forms->goals) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="book_stores">Do you have any book or book stores in your mind which you want us to look at and plan your marketing plan accordingly? <span>*</span></label>
                                            <textarea class="form-control" name="book_stores" id="book_stores" rows="5" required>{{ old('book_stores', $forms->book_stores) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="approach">What's the approach that you take with your clients?</label>
                                            <textarea class="form-control" name="approach" id="approach" rows="5">{{ old('approach', $forms->approach) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="motto">Do you have any motto, catchphrases, or advertising messages? </label>
                                            <textarea class="form-control" name="motto" id="motto" rows="5">{{ old('motto', $forms->motto) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="price_point">What is your price point? How does your price point compare to other relevant books? <span>*</span></label>
                                            <textarea class="form-control" name="price_point" id="price_point" rows="5" required>{{ old('price_point', $forms->price_point) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="number_pages">What are the number of pages in your book? <span>*</span></label>
                                            <textarea class="form-control" name="number_pages" id="number_pages" rows="5" required>{{ old('number_pages', $forms->number_pages) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="paper_back">Do you have a paper back/Hard cover option for your buyers?</label>
                                            <textarea class="form-control" name="paper_back" id="paper_back" rows="5">{{ old('paper_back', $forms->paper_back) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="advantages">What are the advantages to buy your book? (it has Business tips, living tips, history  info, selling skills, educative stuff, etc.)? <span>*</span></label>
                                            <textarea class="form-control" name="advantages" id="advantages" rows="5" required>{{ old('advantages', $forms->advantages) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="existing_website">Do you have an existing website? Would you like us to re-write/update it? Please share the URL here: <span>*</span></label>
                                            <textarea class="form-control" name="existing_website" id="existing_website" rows="5" required>{{ old('existing_website', $forms->existing_website) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="call_action">Call-to-Action: if not purchase then what do you want your potential/current customers to do – call, email, visit your office, or something else? <span>*</span></label>
                                            <textarea class="form-control" name="call_action" id="call_action" rows="5" required>{{ old('call_action', $forms->call_action) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="web_pages">How many web pages do you need? Please provide the number, names, and links (if available). For instance, you may need four pages, titled Home, About Us, Books, and Contact Us. <span>*</span></label>
                                            <textarea class="form-control" name="web_pages" id="web_pages" rows="5" required>{{ old('web_pages', $forms->web_pages) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="achieve_goals">What do you want to achieve from the new site? (Goals should be SMART: specific, measurable, achievable, realistic, and have a timeframe) <span>*</span></label>
                                            <textarea class="form-control" name="achieve_goals" id="achieve_goals" rows="5" required>{{ old('achieve_goals', $forms->achieve_goals) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="competitors">Please provide competitors' websites for content reference and research purposes (three to five). <span>*</span></label>
                                            <textarea class="form-control" name="competitors" id="competitors" rows="5" required>{{ old('competitors', $forms->competitors) }}</textarea>
                                        </div>
                                        <div class="col-md-12 form-group mb-3">
                                            <label for="relevant_information">Is there any other relevant information or requests that you want to share? Please use this space to do so. </label>
                                            <textarea class="form-control" name="relevant_information" id="relevant_information" rows="5">{{ old('relevant_information', $forms->relevant_information) }}</textarea>
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
                                        @foreach($forms->formfiles as $formfiles)
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
                                    <div class="row">
                                        @if($forms->business_established == null)
                                        <div class="col-md-12 mt-1">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                        
                    </div>
                    @php
                    $count++;
                    @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.delete-file').click(function(){
            var id = $(this).data('id');
            var e = $(this);
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0CC27E',
                cancelButtonColor: '#FF586B',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success mr-5',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function () {
                $.ajax({
                    type:'POST',
                    url:"{{ route('client.logo.form.file.delete') }}",
                    data:{id:id},
                    success:function(data){
                        if(data.success == true){
                            swal({
                                type: 'success',
                                title: 'Success!',
                                text: data.message,
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $(e).parents('.col-md-3').remove();
                        }else{
                            swal({
                                type: 'error',
                                title: 'Error!',
                                text: data.message,
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        }
                    }
                });
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    swal('Cancelled', 'Your imaginary file is safe :)', 'error');
                }
            });
        })
    });

    $('.brief-form').submit(function(e){
        $error = 0;
        $(this).find('[data-name]').each(function(){
            if($('input[name="'+$(this).attr('name')+'"]:checked').length == 0){
                toastr.error('Select Atleast One', $(this).data('value'));
                $error++;
            }
        });
        if($error != 0){
            e.preventDefault();
        }
    })
</script>
@endpush