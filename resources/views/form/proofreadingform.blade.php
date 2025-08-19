        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Editing & Proofreading Questionnaire</div>
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="description">Can you provide a brief description of the book you would like to have edited and proofread? <span>*</span></label>
                        <textarea class="form-control" name="description" id="description" rows="5" required>{{ old('description', $data->description) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="word_count">What is the word count of your book?<span>*</span></label>
                        <textarea class="form-control" name="word_count" id="word_count" rows="5" required>{{ old('word_count', $data->word_count) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="services">What type of editing and proofreading services are you looking for (e.g. developmental editing, line editing, copyediting, proofreading, etc.)?<span>*</span></label>
                        <textarea class="form-control" name="services" id="services" rows="5" required>{{ old('services', $data->services) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="completion">Do you have a specific deadline for the completion of the editing and proofreading services?<span>*</span></label>
                        <textarea class="form-control" name="completion" id="completion" rows="5" required>{{ old('completion', $data->completion) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="previously">Have you edited the book yourself or had it edited previously?<span>*</span></label>
                        <textarea class="form-control" name="previously" id="previously" rows="5" required>{{ old('previously', $data->previously) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="specific_areas">Are there any specific areas or elements that you would like the editor to pay close attention to (e.g. grammar, tone, character development, etc.)?<span>*</span></label>
                        <textarea class="form-control" name="specific_areas" id="specific_areas" rows="5" required>{{ old('specific_areas', $data->specific_areas) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="suggestions">Would you like to receive suggestions or feedback from the editor regarding the content of the book?<span>*</span></label>
                        <textarea class="form-control" name="suggestions" id="suggestions" rows="5" required>{{ old('suggestions', $data->suggestions) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="mention">Is there anything else you would like to mention or specify regarding the editing and proofreading services you require?<span>*</span></label>
                        <textarea class="form-control" name="mention" id="mention" rows="5" required>{{ old('mention', $data->mention) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="major">Are there any major plot points we need to know?<span>*</span></label>
                        <textarea class="form-control" name="major" id="major" rows="5" required>{{ old('major', $data->major) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="trigger">Are there any trigger warnings, or are there any sections we should avoid while editing?<span>*</span></label>
                        <textarea class="form-control" name="trigger" id="trigger" rows="5" required>{{ old('trigger', $data->trigger) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="character">Please provide the main character details or anything else we should know ahead of time.<span>*</span></label>
                        <textarea class="form-control" name="character" id="character" rows="5" required>{{ old('character', $data->character) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="guide">Which style guide would you like us to use?<span>*</span></label>
                        <textarea class="form-control" name="guide" id="guide" rows="5" required>{{ old('guide', $data->guide) }}</textarea>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="areas">Do you have any specific areas you'd like us to edit?<span>*</span></label>
                        <textarea class="form-control" name="areas" id="areas" rows="5" required>{{ old('areas', $data->areas) }}</textarea>
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