@extends('layouts.app-sale')
@section('title', 'Logo Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Logo Brief INV#{{$logo_form->invoice->invoice_number}}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form" method="post" route="{{ route('client.logo.form.update', $logo_form->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Details</div>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="client_name">Client Name</label>
                        <input class="form-control" name="client_name" id="client_name" type="text" placeholder="{{ $logo_form->user->name }} {{ $logo_form->user->last_name }}" value="{{ $logo_form->user->name }} {{ $logo_form->user->last_name }}" required readonly/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="agent_name">Agent Name</label>
                        <input class="form-control" name="agent_name" id="agent_name" type="text" placeholder="{{ $logo_form->invoice->sale->name }} {{ $logo_form->invoice->sale->last_name }}" value="{{ $logo_form->invoice->sale->name }} {{ $logo_form->invoice->sale->last_name }}" readonly required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="brand_name">Brand Name</label>
                        <input class="form-control" name="brand_name" id="brand_name" type="text" placeholder="{{ $logo_form->invoice->brands->name }}" value="{{ $logo_form->invoice->brands->name }}" readonly required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Logo Brief Form</div>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="logo_name">Exact logo wording ( logo name )</label>
                        <input class="form-control" name="logo_name" id="logo_name" type="text" placeholder="Enter Logo Name" value="{{ old('logo_name', $logo_form->logo_name) }}" required/>
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="slogan">Slogan/Tagline if any (optional)</label>
                        <input class="form-control" name="slogan" id="slogan" type="text" placeholder="Enter Slogan/Tagline" value="{{ old('slogan', $logo_form->slogan) }}" required/>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="business">Describe your business / service / organization</label>
                        <textarea class="form-control" name="business" id="business" rows="5" required>{{ old('business', $logo_form->business) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Logo Categories</div>
                @php
                    $logo_categories = json_decode($logo_form->logo_categories);
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
                    $icon_based_logo = json_decode($logo_form->icon_based_logo);
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
                                <input type="radio" class="form-check-input" id="comic" name="font_style" value="Comic" {{ $logo_form->font_style == 'Comic' ? 'checked' : '' }}>
                                <label for="comic" class="comic"><img src="{{ asset('newglobal/images/comic.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="stencil" name="font_style" value="Stencil" {{ $logo_form->font_style == 'Stencil' ? 'checked' : '' }}>
                                <label for="stencil" class="comic"><img src="{{ asset('newglobal/images/stencil.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="gothic" name="font_style" value="Gothic" {{ $logo_form->font_style == 'Gothic' ? 'checked' : '' }}>
                                <label for="gothic" class="comic"><img src="{{ asset('newglobal/images/gothic.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="decorative" name="font_style" value="Decorative" {{ $logo_form->font_style == 'Decorative' ? 'checked' : '' }}>
                                <label for="decorative" class="comic"><img src="{{ asset('newglobal/images/decorative.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="typewriter" name="font_style" value="Typewriter" {{ $logo_form->font_style == 'Typewriter' ? 'checked' : '' }}>
                                <label for="typewriter" class="comic"><img src="{{ asset('newglobal/images/typewriter.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="eroded" name="font_style" value="Eroded" {{ $logo_form->font_style == 'Eroded' ? 'checked' : '' }}>
                                <label for="eroded" class="comic"><img src="{{ asset('newglobal/images/eroded.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="graffiti" name="font_style" value="Graffiti" {{ $logo_form->font_style == 'Graffiti' ? 'checked' : '' }}>
                                <label for="graffiti" class="comic"><img src="{{ asset('newglobal/images/graffiti.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="pixelated" name="font_style" value="Pixelated" {{ $logo_form->font_style == 'Pixelated' ? 'checked' : '' }}>
                                <label for="pixelated" class="comic"><img src="{{ asset('newglobal/images/pixelated.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="retro" name="font_style" value="Retro" {{ $logo_form->font_style == 'Retro' ? 'checked' : '' }}>
                                <label for="retro" class="comic"><img src="{{ asset('newglobal/images/retro.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="techno" name="font_style" value="Techno" {{ $logo_form->font_style == 'Techno' ? 'checked' : '' }}>
                                <label for="techno" class="comic"><img src="{{ asset('newglobal/images/techno.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="sansserif" name="font_style" value="Sans serif" {{ $logo_form->font_style == 'Sans serif' ? 'checked' : '' }}>
                                <label for="sansserif" class="comic"><img src="{{ asset('newglobal/images/sansserif.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="serif" name="font_style" value="Serif" {{ $logo_form->font_style == 'Serif' ? 'checked' : '' }}>
                                <label for="serif" class="comic"><img src="{{ asset('newglobal/images/serif.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="calligraphy" name="font_style" value="Calligraphy" {{ $logo_form->font_style == 'Calligraphy' ? 'checked' : '' }}>
                                <label for="calligraphy" class="comic"><img src="{{ asset('newglobal/images/calligraphy.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="formCheck font-box">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="script" name="font_style" value="Script" {{ $logo_form->font_style == 'Script' ? 'checked' : '' }}>
                                <label for="script" class="comic"><img src="{{ asset('newglobal/images/script.jpg') }}"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                    <div class="formCheck font-box">
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="handwritten" name="font_style" value="Handwritten" {{ $logo_form->font_style == 'Handwritten' ? 'checked' : '' }}>
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
                    @foreach($logo_form->formfiles as $formfiles)
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
                        <label for="additional_information">Describe your business / service / organization</label>
                        <textarea name="additional_information" id="additional_information" class="form-control">{{ old('additional_information', $logo_form->additional_information) }}</textarea>
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