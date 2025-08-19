        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Details</div>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="client_name">Client Name</label>
                        <input class="form-control" name="client_name" id="client_name" type="text" placeholder="{{ $data->user->name }} {{ $data->user->last_name }}" value="{{ $data->user->name }} {{ $data->user->last_name }}" required readonly/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="agent_name">Agent Name</label>
                        <input class="form-control" name="agent_name" id="agent_name" type="text" placeholder="{{ $data->invoice->sale->name }} {{ $data->invoice->sale->last_name }}" value="{{ $data->invoice->sale->name }} {{ $data->invoice->sale->last_name }}" readonly required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="brand_name">Brand Name</label>
                        <input class="form-control" name="brand_name" id="brand_name" type="text" placeholder="{{ $data->invoice->brands->name }}" value="{{ $data->invoice->brands->name }}" readonly required/>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Author Website Client Questionnaire</div>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="author_name">Author Name <span>*</span></label>
                        <input class="form-control" name="author_name" id="author_name" type="text" value="{{ old('author_name', $data->author_name) }}" required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="email_address">Email Address <span>*</span></label>
                        <input class="form-control" name="email_address" id="email_address" type="email" value="{{ old('email_address', $data->email_address) }}" required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="contact_number">Contact Number <span>*</span></label>
                        <input class="form-control" name="contact_number" id="contact_number" type="text" value="{{ old('contact_number', $data->contact_number) }}" required/>
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="address">Address</label>
                        <input class="form-control" name="address" id="address" type="text" value="{{ old('address', $data->address) }}" />
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="postal_code">ZIP/Postal Code</label>
                        <input class="form-control" name="postal_code" id="postal_code" type="text" value="{{ old('postal_code', $data->postal_code) }}" />
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label for="city">City/State</label>
                        <input class="form-control" name="city" id="city" type="text" value="{{ old('city', $data->city) }}" />
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="desired_domain">Website Address or Desired Domain (example: www.JKRowling.com)</label>
                        <input class="form-control" name="desired_domain" id="desired_domain" type="text" value="{{ old('desired_domain', $data->desired_domain) }}" />
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
                                <option value="0" {{ $data->own_domain == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->own_domain == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="login_ip">If yes, do you have the login/IP information? Kindly provide the login credentials.</label>
                        <textarea class="form-control" name="login_ip" id="login_ip" rows="5">{{ old('login_ip', $data->login_ip) }}</textarea>
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
                        <textarea class="form-control" name="brief_overview" id="brief_overview" rows="5">{{ old('brief_overview', $data->brief_overview) }}</textarea>
                    </div>
                    @php
                    $purpose = json_decode($data->purpose);
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
                        <input class="form-control" name="purpose_other" id="purpose_other" type="text" value="{{ old('purpose_other', $data->purpose_other) }}"/>
                    </div>
                    @php
                    $user_perform = json_decode($data->user_perform);
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
                        <input class="form-control" name="user_perform_other" id="user_perform_other" type="text" value="{{ old('user_perform_other', $data->user_perform_other) }}"/>
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
                        <textarea class="form-control" name="feel_website" id="feel_website" rows="5">{{ old('feel_website', $data->feel_website) }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="have_logo">If you do not already have a logo, are you going to need one designed?</label>
                            <select name="have_logo" class="form-control" id="have_logo">
                                <option value="0" {{ $data->have_logo == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->have_logo == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="specific_look">Is there a specific look and feel (of your author website) that you have in mind?</label>
                            <select name="specific_look" class="form-control" id="specific_look">
                                <option value="0" {{ $data->specific_look == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->specific_look == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="feel_website">Competitor Websites – Any Other Author Websites You May Have Liked</label>
                        <p class="mb-1">Have you seen any other existing author websites on the internet which you liked? Tell us what you liked about them and what would you like us to do differently. Share up to 3 links of author websites you liked.</p>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="competitor_website_link_1">Link 1</label>
                        <input class="form-control" name="competitor_website_link_1" id="competitor_website_link_1" type="text" value="{{ old('competitor_website_link_1', $data->competitor_website_link_1) }}" />
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="competitor_website_link_2">Link 2</label>
                        <input class="form-control" name="competitor_website_link_2" id="competitor_website_link_2" type="text" value="{{ old('competitor_website_link_2', $data->competitor_website_link_2) }}" />
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="competitor_website_link_3">Link 3</label>
                        <input class="form-control" name="competitor_website_link_3" id="competitor_website_link_3" type="text" value="{{ old('competitor_website_link_3', $data->competitor_website_link_3) }}" />
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Content</div>
                <div class="row">
                @php
                    $pages_sections = json_decode($data->pages_sections);
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
                                <option value="0" {{ $data->written_content == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->written_content == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="need_copywriting">If not, do you need copywriting and photography services?</label>
                            <select name="need_copywriting" class="form-control" id="need_copywriting">
                                <option value="0" {{ $data->need_copywriting == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->need_copywriting == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="cms_site">Are you willing/interested in committing time/effort into learning how to use Content Management System (CMS) and edit your site yourself in future?</label>
                            <select name="cms_site" class="form-control" id="cms_site">
                                <option value="0" {{ $data->cms_site == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->cms_site == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="existing_site">Do you have an existing site and want to get it redesigned?</label>
                            <select name="existing_site" class="form-control" id="existing_site">
                                <option value="0" {{ $data->existing_site == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->existing_site == 1 ? 'selected' : ''}}>Yes</option>
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
                        <textarea class="form-control" name="about_your_book" id="about_your_book" rows="5">{{ old('about_your_book', $data->about_your_book) }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="social_networks">Do you have any social networks accounts setup?</label>
                            <select name="social_networks" class="form-control" id="social_networks">
                                <option value="0" {{ $data->social_networks == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->social_networks == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="social_linked">Do you want all your social media accounts to be linked on your site?</label>
                            <select name="social_linked" class="form-control" id="social_linked">
                                <option value="0" {{ $data->social_linked == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->social_linked == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="social_marketing">Will you like us to provide social media marketing services?</label>
                            <select name="social_marketing" class="form-control" id="social_marketing">
                                <option value="0" {{ $data->social_marketing == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->social_marketing == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="advertising_book">Do you want to build your mailing list and use it for advertising your book?</label>
                            <select name="advertising_book" class="form-control" id="advertising_book">
                                <option value="0" {{ $data->advertising_book == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->advertising_book == 1 ? 'selected' : ''}}>Yes</option>
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
                                <option value="0" {{ $data->regular_updating == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->regular_updating == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="updating_yourself">Would you like to be able to do most of the updating yourself?</label>
                            <select name="updating_yourself" class="form-control" id="updating_yourself">
                                <option value="0" {{ $data->updating_yourself == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->updating_yourself == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="already_written">If you are planning on writing a blog, do you have several pieces already written? Do you already write on a regular basis?</label>
                            <select name="already_written" class="form-control" id="already_written">
                                <option value="0" {{ $data->already_written == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->already_written == 1 ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="features_pages">Are there any features/pages which you don’t need right now but may want in the future? Please be as specific and future thinking as possible.</label>
                            <select name="features_pages" class="form-control" id="features_pages">
                                <option value="0" {{ $data->features_pages == 0 ? 'selected' : ''}}>No</option>
                                <option value="1" {{ $data->features_pages == 1 ? 'selected' : ''}}>Yes</option>
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
                    $typical_homepage = json_decode($data->typical_homepage);
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