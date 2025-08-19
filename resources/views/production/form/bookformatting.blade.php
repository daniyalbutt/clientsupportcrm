@extends('layouts.app-production')
@section('title', 'Book Formatting & Publishing Form')

@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Book Formatting & Publishing Brief INV#{{$data->invoice->invoice_number}}</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <form class="col-md-12 brief-form" method="post" route="{{ route('client.logo.form.update', $data->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Book Formatting & Publishing Brief Form</div>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="book_title">What is the title of the book? <span>*</span></label>
                        <input class="form-control" name="book_title" id="book_title" type="text" value="{{ old('book_title', $data->book_title) }}" required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="book_subtitle">What is the subtitle of the book?</label>
                        <input class="form-control" name="book_subtitle" id="book_subtitle" type="text" value="{{ old('book_subtitle', $data->book_subtitle) }}"/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="author_name">What is the name of the author? <span>*</span></label>
                        <input class="form-control" name="author_name" id="author_name" type="text"  value="{{ old('author_name', $data->author_name) }}" required/>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="contributors">Any additional contributors you would like to acknowledge? (e.g. Book Illustrator, Editor, etc.) <span>*</span></label>
                        <textarea class="form-control" name="contributors" id="contributors" rows="5" required>{{ old('contributors', $data->contributors) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Formatting Requirements</div>
                <p>Where do you want to? <span>*</span></p>
                @php
                $publish_your_book = json_decode($data->publish_your_book);
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
                $book_formatted = json_decode($data->book_formatted);
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
                                <input type="radio" class="form-check-input" id="trim_size_1" name="trim_size" value="5_8" {{ $data->trim_size == '5_8' ? 'checked' : '' }} data-value="Which trim size do you want your book to be formatted on?" data-name="required">
                                <label for="trim_size_1" class="comic">5″ X 8″</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="formCheck font-box">
                            <div class="form-check pl-0">
                                <input type="radio" class="form-check-input" id="trim_size_2" name="trim_size" value="5.25_8" {{ $data->trim_size == '5.25_8' ? 'checked' : '' }}>
                                <label for="trim_size_2" class="comic">5.25″ X 8″</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="formCheck font-box">
                            <div class="form-check pl-0">
                                <input type="radio" class="form-check-input" id="trim_size_3" name="trim_size" value="5.5_8.5" {{ $data->trim_size == '5.5_8.5' ? 'checked' : '' }}>
                                <label for="trim_size_3" class="comic">5.5″ X 8.5″</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="formCheck font-box">
                            <div class="form-check pl-0">
                                <input type="radio" class="form-check-input" id="trim_size_4" name="trim_size" value="6_9" {{ $data->trim_size == '6_9' ? 'checked' : '' }}>
                                <label for="trim_size_4" class="comic">6″ X 9″</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="formCheck font-box">
                            <div class="form-check pl-0">
                                <input type="radio" class="form-check-input" id="trim_size_5" name="trim_size" value="8.5_11" {{ $data->trim_size == '8.5_11' ? 'checked' : '' }}>
                                <label for="trim_size_5" class="comic">8.5″ X 11″</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="formCheck font-box">
                            <div class="form-check pl-0">
                                <input type="radio" class="form-check-input" id="trim_size_6" name="trim_size" value="Other" {{ $data->trim_size == 'Other' ? 'checked' : '' }}>
                                <label for="trim_size_6" class="comic">Other (Please specify)</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group mb-3">
                        <label for="trim_size_7">If you have selected Other please specify the trim size you want your book to be formatted on.</label>
                        <input class="form-control" name="other_trim_size" id="trim_size_7" type="text"  value="{{ old('other_trim_size', $data->other_trim_size) }}"/>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="additional_instructions">Any Additional Instructions that you would like us to follow?</label>
                        <textarea class="form-control" name="additional_instructions" id="additional_instructions" rows="5">{{ old('additional_instructions', $data->additional_instructions) }}</textarea>
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
                    @foreach($data->formfiles as $formfiles)
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