    <div class="card mb-4">
        <div class="card-body mb-4">
            <div class="row">
                <div class="col-md-12 form-group mb-3">
                    <label for="title">What is the title of your book, and which Genre does it belong to? <span>*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $data->title) }}" required>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="behind_title">What is the meaning behind the title?</label>
                    <input type="text" name="behind_title" class="form-control" value="{{ old('behind_title', $data->behind_title) }}">
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="key_message">What is your key message? <span>*</span></label>
                    <input type="text" name="key_message" class="form-control" value="{{ old('key_message', $data->key_message) }}" required>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="giveaways">Are you offering any giveaways/products to first-time buyers of your book/store? What are their top features or benefits? <span>*</span></label>
                    <textarea class="form-control" name="giveaways" id="giveaways" rows="5" required>{{ old('giveaways', $data->giveaways) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="target_audience">Describe your primary and secondary target audience (their ages, where they are located, their pain points, concerns, interests, etc.) <span>*</span></label>
                    <textarea class="form-control" name="target_audience" id="target_audience" rows="5" required>{{ old('target_audience', $data->target_audience) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="launched">Is your book already Launched? If not then what is the expected launch date?</label>
                    <input type="text" name="launched" class="form-control" value="{{ old('launched', $data->launched) }}">
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="published_book">Have you published your book online already or do you want us to do it? If you have published it then what are the platforms you have covered? <span>*</span></label>
                    <textarea class="form-control" name="published_book" id="published_book" rows="5" required>{{ old('published_book', $data->published_book) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="sold_book">Have you sold any books so far? If yes, then what is the number of books sold?</label>
                    <textarea class="form-control" name="sold_book" id="sold_book" rows="5">{{ old('sold_book', $data->sold_book) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="marketing">What will be the start date of your marketing project?</label>
                    <textarea class="form-control" name="marketing" id="marketing" rows="5">{{ old('marketing', $data->marketing) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="author_name">Please mention the name of the author(s) and details about their past writing experience(if any) or if they have already written/published a book before? <span>*</span></label>
                    <textarea class="form-control" name="author_name" id="author_name" rows="5" required>{{ old('author_name', $data->author_name) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="social_pages">Have you created any social pages/accounts for your book already? If yes then please share the platform list.</label>
                    <textarea class="form-control" name="social_pages" id="social_pages" rows="5">{{ old('social_pages', $data->social_pages) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="basics">Do you know the basics about how to run Facebook, Google, YouTube ads and Amazon PPC ads?</label>
                    <textarea class="form-control" name="basics" id="basics" rows="5">{{ old('basics', $data->basics) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="selling_point">What is your selling point? How your book is different? What is special in it for the readers? <span>*</span></label>
                    <textarea class="form-control" name="selling_point" id="selling_point" rows="5" required>{{ old('selling_point', $data->selling_point) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="keywords">What are the keywords that your target audience might use to search online for a book like yours? <span>*</span></label>
                    <textarea class="form-control" name="keywords" id="keywords" rows="5" required>{{ old('keywords', $data->keywords) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="goals">What are the goals you have in your mind to achieve from this book?</label>
                    <textarea class="form-control" name="goals" id="goals" rows="5">{{ old('goals', $data->goals) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="book_stores">Do you have any book or book stores in your mind which you want us to look at and plan your marketing plan accordingly? <span>*</span></label>
                    <textarea class="form-control" name="book_stores" id="book_stores" rows="5" required>{{ old('book_stores', $data->book_stores) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="approach">What's the approach that you take with your clients?</label>
                    <textarea class="form-control" name="approach" id="approach" rows="5">{{ old('approach', $data->approach) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="motto">Do you have any motto, catchphrases, or advertising messages? </label>
                    <textarea class="form-control" name="motto" id="motto" rows="5">{{ old('motto', $data->motto) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="price_point">What is your price point? How does your price point compare to other relevant books? <span>*</span></label>
                    <textarea class="form-control" name="price_point" id="price_point" rows="5" required>{{ old('price_point', $data->price_point) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="number_pages">What are the number of pages in your book? <span>*</span></label>
                    <textarea class="form-control" name="number_pages" id="number_pages" rows="5" required>{{ old('number_pages', $data->number_pages) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="paper_back">Do you have a paper back/Hard cover option for your buyers?</label>
                    <textarea class="form-control" name="paper_back" id="paper_back" rows="5">{{ old('paper_back', $data->paper_back) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="advantages">What are the advantages to buy your book? (it has Business tips, living tips, history  info, selling skills, educative stuff, etc.)? <span>*</span></label>
                    <textarea class="form-control" name="advantages" id="advantages" rows="5" required>{{ old('advantages', $data->advantages) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="existing_website">Do you have an existing website? Would you like us to re-write/update it? Please share the URL here: <span>*</span></label>
                    <textarea class="form-control" name="existing_website" id="existing_website" rows="5" required>{{ old('existing_website', $data->existing_website) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="call_action">Call-to-Action: if not purchase then what do you want your potential/current customers to do – call, email, visit your office, or something else? <span>*</span></label>
                    <textarea class="form-control" name="call_action" id="call_action" rows="5" required>{{ old('call_action', $data->call_action) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="web_pages">How many web pages do you need? Please provide the number, names, and links (if available). For instance, you may need four pages, titled Home, About Us, Books, and Contact Us. <span>*</span></label>
                    <textarea class="form-control" name="web_pages" id="web_pages" rows="5" required>{{ old('web_pages', $data->web_pages) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="achieve_goals">What do you want to achieve from the new site? (Goals should be SMART: specific, measurable, achievable, realistic, and have a timeframe) <span>*</span></label>
                    <textarea class="form-control" name="achieve_goals" id="achieve_goals" rows="5" required>{{ old('achieve_goals', $data->achieve_goals) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="competitors">Please provide competitors' websites for content reference and research purposes (three to five). <span>*</span></label>
                    <textarea class="form-control" name="competitors" id="competitors" rows="5" required>{{ old('competitors', $data->competitors) }}</textarea>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="relevant_information">Is there any other relevant information or requests that you want to share? Please use this space to do so. </label>
                    <textarea class="form-control" name="relevant_information" id="relevant_information" rows="5">{{ old('relevant_information', $data->relevant_information) }}</textarea>
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