        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Book Writing Brief Form</div>
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="book_title">Do you have a desired book title?</label>
                        <input class="form-control" name="book_title" id="book_title" type="text" value="{{ old('book_title', $data->book_title) }}" required/>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="genre_book">What is the Genre of your book?</label>
                        <textarea class="form-control" name="genre_book" id="genre_book" rows="5" >{{ old('genre_book', $data->genre_book) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="brief_summary">Can you provide a brief summary of the book's content and theme?</label>
                        <textarea class="form-control" name="brief_summary" id="brief_summary" rows="5" >{{ old('brief_summary', $data->brief_summary) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="purpose">What is the purpose behind writing this book?</label>
                        <textarea class="form-control" name="purpose" id="purpose" rows="5" >{{ old('purpose', $data->purpose) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="target_audience">Who is the target audience for the book? </label>
                        <textarea class="form-control" name="target_audience" id="target_audience" rows="5" >{{ old('target_audience', $data->target_audience) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="desired_length">What is the desired length of the book (word count/pages)?</label>
                        <textarea class="form-control" name="desired_length" id="desired_length" rows="5" >{{ old('desired_length', $data->desired_length) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="specific_characters">Are there any specific characters or settings that need to be included in the book?</label>
                        <textarea class="form-control" name="specific_characters" id="specific_characters" rows="5" >{{ old('specific_characters', $data->specific_characters) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="specific_themes">Are there any specific themes or messages that need to be conveyed in the book?</label>
                        <textarea class="form-control" name="specific_themes" id="specific_themes" rows="5" >{{ old('specific_themes', $data->specific_themes) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="writing_style">What will be the writing style? (US or UK)</label>
                        <textarea class="form-control" name="writing_style" id="writing_style" rows="5" >{{ old('writing_style', $data->writing_style) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="specific_tone">Is there a specific tone or style that should be used in the book?</label>
                        <textarea class="form-control" name="specific_tone" id="specific_tone" rows="5" >{{ old('specific_tone', $data->specific_tone) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="existing_materials">Are there any existing materials, such as notes or outlines, that can be used in the book?</label>
                        <textarea class="form-control" name="existing_materials" id="existing_materials" rows="5" >{{ old('existing_materials', $data->existing_materials) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="existing_books">Are there any existing books, articles, or other works that should be used as reference or inspiration for the book?</label>
                        <textarea class="form-control" name="existing_books" id="existing_books" rows="5" >{{ old('existing_books', $data->existing_books) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="specific_deadlines">Are there any specific deadlines for the completion of the book?</label>
                        <textarea class="form-control" name="specific_deadlines" id="specific_deadlines" rows="5" >{{ old('specific_deadlines', $data->specific_deadlines) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="specific_instructions">Are there any other specific instructions or requirements that the client wants to include in the book?</label>
                        <textarea class="form-control" name="specific_instructions" id="specific_instructions" rows="5" >{{ old('specific_instructions', $data->specific_instructions) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="research">Is there any research that needs to be done for the book?</label>
                        <textarea class="form-control" name="research" id="research" rows="5" >{{ old('research', $data->research) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="specific_chapter">Are there any specific chapter-wise details or guidelines for the book?</label>
                        <textarea class="form-control" name="specific_chapter" id="specific_chapter" rows="5" >{{ old('specific_chapter', $data->specific_chapter) }}</textarea>
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