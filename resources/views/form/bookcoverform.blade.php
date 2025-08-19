        <div class="card mb-4">
            <div class="card-body mb-4">
                <div class="card-title mb-3">Book Cover Questionnaire</div>
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="title">Title of the book (Exact Wording) <span>*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $data->title) }}" required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="subtitle">Subtitle/Tagline if any (Optional)</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $data->subtitle) }}">
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="author">Name of the Author<span>*</span></label>
                        <input type="text" name="author" class="form-control" value="{{ old('author', $data->author) }}" required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="genre">What is the Genre of the book?</label>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="formCheck font-box mb-0">
                                    <div class="form-check pl-0">
                                        <input type="radio" class="form-check-input" id="genre_1" name="genre" value="fiction" {{ $data->genre == 'fiction' ? 'checked' : '' }}>
                                        <label for="genre_1" class="genre">Fiction</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="formCheck font-box mb-0">
                                    <div class="form-check pl-0">
                                        <input type="radio" class="form-check-input" id="genre_2" name="genre" value="non-fiction" {{ $data->genre == 'non-fiction' ? 'checked' : '' }}>
                                        <label for="genre_2" class="genre">Non Fiction</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="isbn">Do you have an ISBN Number? Or do you need one?<span>*</span></label>
                        <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $data->isbn) }}" required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="trim_size">Book Trim Size<span>*</span></label>
                        <input type="text" name="trim_size" class="form-control" value="{{ old('trim_size', $data->trim_size) }}" required>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="explain">Explain your book cover concept that you would like us to follow?<span>*</span></label>
                        <textarea class="form-control" name="explain" id="explain" rows="5" required>{{ old('explain', $data->explain) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="information">Provide the information for Back Cover. This information will be added to the back cover.<span>*</span></label>
                        <textarea class="form-control" name="information" id="information" rows="5" required>{{ old('information', $data->information) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="about">What is your book about?<span>*</span></label>
                        <textarea class="form-control" name="about" id="about" rows="5" required>{{ old('about', $data->about) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="keywords">Keywords that define your book.<span>*</span></label>
                        <textarea class="form-control" name="keywords" id="keywords" rows="5" required>{{ old('keywords', $data->keywords) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="images_provide">Any images you would like us to use or provide for reference?<span>*</span></label>
                        <textarea class="form-control" name="images_provide" id="images_provide" rows="5" required>{{ old('images_provide', $data->images_provide) }}</textarea>
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
                                        <input type="radio" class="form-check-input" id="category_1" name="category" value="picture_based" {{ $data->category == 'picture_based' ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" id="category_2" name="category" value="text_based" {{ $data->category == 'text_based' ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" id="category_3" name="category" value="picture_collage" {{ $data->category == 'picture_collage' ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" id="category_4" name="category" value="illustration" {{ $data->category == 'illustration' ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" id="category_5" name="category" value="abstract" {{ $data->category == 'abstract' ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" id="category_6" name="category" value="notebook" {{ $data->category == 'notebook' ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" id="category_7" name="category" value="fictional" {{ $data->category == 'fictional' ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" id="category_8" name="category" value="vintage" {{ $data->category == 'vintage' ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" id="category_9" name="category" value="religious" {{ $data->category == 'religious' ? 'checked' : '' }}>
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
                                        <input type="radio" class="form-check-input" id="category_10" name="category" value="creative_illustration" {{ $data->category == 'creative_illustration' ? 'checked' : '' }}>
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