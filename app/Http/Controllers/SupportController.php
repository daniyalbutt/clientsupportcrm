<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\LogoForm;
use App\Models\WebForm;
use App\Models\SmmForm;
use App\Models\Client;
use App\Models\ContentWritingForm;
use App\Models\SeoForm;
use App\Models\BookFormatting;
use App\Models\BookWriting;
use App\Models\AuthorWebsite;
use App\Models\Proofreading;
use App\Models\BookCover;
use App\Models\BookMarketing;
use App\Models\NoForm;
use App\Models\Brand;
use App\Models\Service;
use App\Models\ClientFile;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\SubtasKDueDate;
use App\Models\User;
use App\Models\Message;
use App\Models\ProjectObjection;
use Illuminate\Http\Request;
use App\Notifications\MessageNotification;
use App\Notifications\ObjectionNotification;
use Illuminate\Support\Str;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Auth;
use Notification;
use Mail;
use DB;
use PDF;
use Pusher\Pusher;
use \Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $project_count = Project::where('user_id', Auth()->user()->id)->orderBy('id', 'desc')->count();
        $task_count = Task::where('user_id', Auth()->user()->id)->count();
        return view('support.home', compact('project_count', 'task_count'));
    }

    public function getServices(){
        $data = DB::table('services')->get();
        return response()->json(['data' => $data]);
    }

    public function markAsRead(){
        $user = User::find(Auth()->user()->id);
        $user->notifications->markAsRead();
        return back();
    }

    public function assignServices(Request $request){
        $service = $request->service_id;
        $user_id = $request->client_id;
        $user = User::find($user_id);
        $client_id = $user->client->id;
        $invoice_id = $user->client->last_invoice_paid->id;
        $service = Service::find($service);
        $form = null;

        if($service->form == 0){
            // No Form
            $form = new NoForm();
            $form->name = 'No Form';
            $name = 'No Form';
        }elseif($service->form == 1){
            // Logo Form
            $form = new LogoForm();
            $name = 'Logo Form';
        }elseif($service->form == 2){
            // Website Form
            $form = new WebForm();
            $name = 'Website Form';
        }elseif($service->form == 3){
            // Smm Form
            $form = new SmmForm();
            $name = 'SMM Form';
        }elseif($service->form == 4){
            // Content Writing Form
            $form = new ContentWritingForm();
            $name = 'Content Writing Form';
        }elseif($service->form == 5){
            // Search Engine Optimization Form
            $form = new SeoForm();
            $name = 'Search Engine Optimization Form';
        }elseif($service->form == 6){
            // Book Formatting & Publishing
            $form = new BookFormatting();
            $name = 'Book Formatting & Publishing';
        }elseif($service->form == 7){
            // Book Writing Form
            $form = new BookWriting();
            $name = 'Book Writing Form';
        }elseif($service->form == 8){
            // Author Website
            $form = new AuthorWebsite();
            $name = 'Author Website';
        }elseif($service->form == 9){
            // Proofreading
            $form = new Proofreading();
            $name = 'Proofreading';
        }elseif($service->form == 10){
            // Book Cover
            $form = new BookCover();
            $name = 'Book Cover';
        }elseif($service->form == 11){
            // Book Marketing
            $form = new BookMarketing();
            $name = 'Book Marketing';
        }
        $form->invoice_id = $invoice_id;
        $form->user_id = $user_id;
        $form->client_id = $client_id;
        $form->agent_id = Auth::user()->id;
        $form->save();

        $project = new Project();
        $project->name = $user->name . ' ' . $user->last_name . ' - ' . $name;
        $project->status = 1;
        $project->user_id = Auth::user()->id;
        $project->client_id = $user_id;
        $project->brand_id = $user->client->brand->id;
        $project->form_id = $form->id;
        $project->form_checker = $service->form;
        $project->save();

        return redirect()->back()->with('success', 'Form Assign Successfully to .' . $user->name . ' ' . $user->last_name);
    }

    public function projects(Request $request)
    {
        $data = new Project;
        $data = $data->where('user_id', Auth()->user()->id);
        $data = $data->orderBy('id', 'desc');
        if ($request->project != '') {
            $data = $data->where('name', 'LIKE', "%$request->project%");
        }
        if ($request->project_id != '') {
            $data = $data->where('id', $request->project_id);
        }
        if ($request->user != '') {
            $user = $request->user;
            $data = $data->whereHas('client', function ($query) use ($user) {
                return $query->where('name', 'LIKE', "%$user%")->orWhere('email', 'LIKE', "%$user%");
            });
        }

        $data = $data->paginate(10);
        return view('support.project', compact('data'));
    }

    public function allProjects()
    {
        $brand_list = Auth::user()->brand_list();
        $data = Project::whereIn('brand_id', $brand_list)->where('user_id', '!=', Auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
        return view('support.all-projects', compact('data'));
    }

    public function getPdfFormByProduction($form_id, $check, $id)
    {
        $project = Project::find($id);
        if ($check == 1) {
            $logo_form = LogoForm::find($form_id);
            // return view('production.form.logoform', compact('logo_form'));
        } else if ($check == 2) {
            $web_form = WebForm::find($form_id);
            $data = [
                'data' => $web_form,
            ];
            $pdf = PDF::loadView('production.pdf.web-form', $data);
            return $pdf->download('testing.pdf');
            // return view('production.form.webform', compact('web_form'));
        } elseif ($check == 3) {
            $smm_form = SmmForm::find($form_id);
            // return view('production.form.smmform', compact('smm_form'));
        } elseif ($check == 4) {
            $content_form = ContentWritingForm::find($form_id);
            // return view('production.form.contentform', compact('content_form'));
        } elseif ($check == 5) {
            $seo_form = SeoForm::find($form_id);
            // return view('production.form.seoform', compact('seo_form'));
        }
    }

    public function getFormByProduction($form_id, $check, $id)
    {
        $project = Project::find($id);
        // if($project->user_id == Auth()->user()->id){
        if ($check == 1) {
            $logo_form = LogoForm::find($form_id);
            return view('production.form.logoform', compact('logo_form'));
        } else if ($check == 2) {
            $web_form = WebForm::find($form_id);
            return view('production.form.webform', compact('web_form'));
        } elseif ($check == 3) {
            $smm_form = SmmForm::find($form_id);
            return view('production.form.smmform', compact('smm_form'));
        } elseif ($check == 4) {
            $content_form = ContentWritingForm::find($form_id);
            return view('production.form.contentform', compact('content_form'));
        } elseif ($check == 5) {
            $seo_form = SeoForm::find($form_id);
            return view('production.form.seoform', compact('seo_form'));
        } elseif ($check == 6) {
            $data = BookFormatting::find($form_id);
            return view('production.form.bookformatting', compact('data'));
        } elseif ($check == 7) {
            $data = BookWriting::find($form_id);
            return view('production.form.bookwriting', compact('data'));
        } elseif ($check == 8) {
            $data = AuthorWebsite::find($form_id);
            return view('production.form.authorwebsite', compact('data'));
        } elseif ($check == 9) {
            $data = Proofreading::find($form_id);
            return view('production.form.proofreading', compact('data'));
        } elseif ($check == 10) {
            $data = BookCover::find($form_id);
            return view('production.form.bookcover', compact('data'));
        }
    }

    public function getFormByMember($form_id, $check, $id)
    {
        $project = Project::find($id);
        // if($project->user_id == Auth()->user()->id){
        if ($check == 1) {
            $logo_form = LogoForm::find($form_id);
            return view('member.form.logoform', compact('logo_form'));
        } else if ($check == 2) {
            $web_form = WebForm::find($form_id);
            return view('member.form.webform', compact('web_form'));
        } elseif ($check == 3) {
            $smm_form = SmmForm::find($form_id);
            return view('member.form.smmform', compact('smm_form'));
        } elseif ($check == 4) {
            $content_form = ContentWritingForm::find($form_id);
            return view('member.form.contentform', compact('content_form'));
        } elseif ($check == 5) {
            $seo_form = SeoForm::find($form_id);
            return view('member.form.seoform', compact('seo_form'));
        } elseif ($check == 6) {
            $data = BookFormatting::find($form_id);
            return view('member.form.bookformatting', compact('data'));
        } elseif ($check == 7) {
            $data = BookWriting::find($form_id);
            return view('member.form.bookwriting', compact('data'));
        } elseif ($check == 8) {
            $data = AuthorWebsite::find($form_id);
            return view('member.form.authorwebsite', compact('data'));
        } elseif ($check == 9) {
            $data = Proofreading::find($form_id);
            return view('member.form.proofreading', compact('data'));
        } elseif ($check == 10) {
            $data = BookCover::find($form_id);
            return view('member.form.bookcover', compact('data'));
        }
    }

    public function getForm($form_id, $check, $id)
    {
        $project = Project::find($id);
        // if($project->user_id == Auth()->user()->id){
        if ($check == 1) {
            $logo_form = LogoForm::find($form_id);
            return view('support.logoform', compact('logo_form'));
        } else if ($check == 2) {
            $web_form = WebForm::find($form_id);
            return view('support.webform', compact('web_form'));
        } elseif ($check == 3) {
            $smm_form = SmmForm::find($form_id);
            return view('support.smmform', compact('smm_form'));
        } elseif ($check == 4) {
            $content_form = ContentWritingForm::find($form_id);
            return view('support.contentform', compact('content_form'));
        } elseif ($check == 5) {
            $seo_form = SeoForm::find($form_id);
            return view('support.seoform', compact('seo_form'));
        } elseif ($check == 6) {
            $data = BookFormatting::find($form_id);
            return view('support.bookformatting', compact('data'));
        } elseif ($check == 7) {
            $data = BookWriting::find($form_id);
            return view('support.bookwriting', compact('data'));
        } elseif ($check == 8) {
            $data = AuthorWebsite::find($form_id);
            return view('support.authorwesbite', compact('data'));
        } elseif ($check == 9) {
            $data = Proofreading::find($form_id);
            return view('support.proofreading', compact('data'));
        } elseif ($check == 10) {
            $data = BookCover::find($form_id);
            return view('support.bookcover', compact('data'));
        } elseif ($check == 11) {
            $data = BookMarketing::find($form_id);
            return view('support.bookmarketing', compact('data'));
        }
        // }else{
        //     return redirect()->back();
        // }
    }

    public function downloadForm($id, $check){
        if($check == 6){
            $form_data = BookFormatting::find($id);
            $data = [
                'Form_Name' => 'Book Formatting',
                'Client_name' => $form_data->client->name . ' ' . $form_data->client->last_name,
                'What_is_the_title_of_the_book?' => $form_data->book_title,
                'What_is_the_subtitle_of_the_book?' => $form_data->book_subtitle,
                'What_is_the_name_of_the_author?' => $form_data->author_name,
                'Any_additional_contributors_you_would_like_to_acknowledge?_(e.g._Book_Illustrator,_Editor,_etc.)' => $form_data->contributors,
                'Where_do_you_want_to?' => $form_data->publish_your_book,
                'Which_formats_do_you_want_your_book_to_be_formatted_on?' => $form_data->book_formatted,
                'Which_trim_size_do_you_want_your_book_to_be_formatted_on?' => $form_data->trim_size,
                'If_you_have_selected_Other_please_specify_the_trim_size_you_want_your_book_to_be_formatted_on.' => $form_data->other_trim_size,
                'Any_Additional_Instructions_that_you_would_like_us_to_follow?' => $form_data->additional_instructions,
            ];
            $pdf = PDF::loadView('pdf.form_pdf', compact('data'));
            return $pdf->download('book_formatting_'. strtolower($form_data->client->name) . '_' . strtolower($form_data->client->last_name) .'.pdf');
        }elseif($check == 10){
            $form_data = BookCover::find($id);
            $data = [
                'Form_Name' => 'Cover Design',
                'Client_name' => $form_data->client->name . ' ' . $form_data->client->last_name,
                'Title_of_the_book_(Exact_Wording)' => $form_data->title,
                'Subtitle/Tagline_if_any_(Optional)' => $form_data->subtitle,
                'Name_of_the_Author' => $form_data->author,
                'What_is_the_Genre_of_the_book?' => $form_data->genre,
                'Do_you_have_an_ISBN_Number?_Or_do_you_need_one?*' => $form_data->isbn,
                'Book_Trim_Size*' => $form_data->trim_size,
                'Explain_your_book_cover_concept_that_you_would_like_us_to_follow?*' => $form_data->explain,
                'Provide_the_information_for_Back_Cover._This_information_will_be_added_to_the_back_cover.*' => $form_data->information,
                'What_is_your_book_about?*' => $form_data->about,
                'Keywords_that_define_your_book.*' => $form_data->keywords,
                'Any_images_you_would_like_us_to_use_or_provide_for_reference?*' => $form_data->images_provide,
                'Select_one_of_the_style_category_that_you_want_us_to_follow_for_your_book_cover*' => $form_data->category,
            ];
            $pdf = PDF::loadView('pdf.form_pdf', compact('data'));
            return $pdf->download('cover_design_'. strtolower($form_data->client->name) . '_' . strtolower($form_data->client->last_name) .'.pdf');
        }elseif($check == 11){
            $form_data = BookMarketing::find($id);
            $data = [
                'Form_Name' => 'Book Marketing',
                'Client_name' => $form_data->client->name . ' ' . $form_data->client->last_name,
                'What_is_the_title_of_your_book,_and_which_Genre_does_it_belong_to?_*' => $form_data->title,
                'What_is_the_meaning_behind_the_title?' => $form_data->behind_title,
                'What_is_your_key_message?_*' => $form_data->key_message,
                'Are_you_offering_any_giveaways/products_to_first-time_buyers_of_your_book/store?_What_are_their_top_features_or_benefits?_*' => $form_data->giveaways,
                'Describe_your_primary_and_secondary_target_audience_(their_ages,_where_they_are_located,_their_pain_points,_concerns,_interests,_etc.)_*' => $form_data->target_audience,
                'Is_your_book_already_Launched?_If_not_then_what_is_the_expected_launch_date?' => $form_data->launched,
                'Have_you_published_your_book_online_already_or_do_you_want_us_to_do_it?_If_you_have_published_it_then_what_are_the_platforms_you_have_covered?_*' => $form_data->published_book,
                'Have_you_sold_any_books_so_far?_If_yes,_then_what_is_the_number_of_books_sold?' => $form_data->sold_book,
                'What_will_be_the_start_date_of_your_marketing_project?' => $form_data->marketing,
                'Please_mention_the_name_of_the_author(s)_and_details_about_their_past_writing_experience(if_any)_or_if_they_have_already_written/published_a_book_before?_*' => $form_data->author_name,
                'Have_you_created_any_social_pages/accounts_for_your_book_already?_If_yes_then_please_share_the_platform_list.' => $form_data->social_pages,
                'Do_you_know_the_basics_about_how_to_run_Facebook,_Google,_YouTube_ads_and_Amazon_PPC_ads?' => $form_data->basics,
                'What_is_your_selling_point?_How_your_book_is_different?_What_is_special_in_it_for_the_readers?_*' => $form_data->selling_point,
                'What_are_the_keywords_that_your_target_audience_might_use_to_search_online_for_a_book_like_yours?_*' => $form_data->keywords,
                'What_are_the_goals_you_have_in_your_mind_to_achieve_from_this_book?' => $form_data->goals,
                'Do_you_have_any_book_or_book_stores_in_your_mind_which_you_want_us_to_look_at_and_plan_your_marketing_plan_accordingly?_*' => $form_data->book_stores,
                'Whats_the_approach_that_you_take_with_your_clients?' => $form_data->approach,
                'Do_you_have_any_motto,_catchphrases,_or_advertising_messages?' => $form_data->motto,
                'What_is_your_price_point?_How_does_your_price_point_compare_to_other_relevant_books?_*' => $form_data->price_point,
                'What_are_the_number_of_pages_in_your_book?_*' => $form_data->number_pages,
                'Do_you_have_a_paper_back/Hard_cover_option_for_your_buyers?' => $form_data->paper_back,
                'What_are_the_advantages_to_buy_your_book?_(it_has_Business_tips,_living_tips,_history_info,_selling_skills,_educative_stuff,_etc.)?_*' => $form_data->advantages,
                'Do_you_have_an_existing_website?_Would_you_like_us_to_re-write/update_it?_Please_share_the_URL_here:_*' => $form_data->existing_website,
                'Call-to-Action:_if_not_purchase_then_what_do_you_want_your_potential/current_customers_to_do_–_call,_email,_visit_your_office,_or_something_else?_*' => $form_data->call_action,
                'How_many_web_pages_do_you_need?_Please_provide_the_number,_names,_and_links_(if_available)._For_instance,_you_may_need_four_pages,_titled_Home,_About_Us,_Books,_and_Contact_Us._*' => $form_data->web_pages,
                'What_do_you_want_to_achieve_from_the_new_site?_(Goals_should_be_SMART:_specific,_measurable,_achievable,_realistic,_and_have_a_timeframe)_*' => $form_data->achieve_goals,
                'Please_provide_competitors_websites_for_content_reference_and_research_purposes_(three_to_five)._*' => $form_data->competitors,
                'Is_there_any_other_relevant_information_or_requests_that_you_want_to_share?_Please_use_this_space_to_do_so.' => $form_data->relevant_information,
            ];
            $pdf = PDF::loadView('pdf.form_pdf', compact('data'));
            return $pdf->download('book_marketing_'. strtolower($form_data->client->name) . '_' . strtolower($form_data->client->last_name) .'.pdf');
        }
    }

    public function getFormManager($form_id, $check, $id)
    {
        $project = Project::find($id);
        // if($project->user_id == Auth()->user()->id){
        if ($check == 1) {
            $logo_form = LogoForm::find($form_id);
            return view('manager.form.logoform', compact('logo_form'));
        } else if ($check == 2) {
            $web_form = WebForm::find($form_id);
            return view('manager.form.webform', compact('web_form'));
        } elseif ($check == 3) {
            $smm_form = SmmForm::find($form_id);
            return view('manager.form.smmform', compact('smm_form'));
        } elseif ($check == 4) {
            $content_form = ContentWritingForm::find($form_id);
            return view('manager.form.contentform', compact('content_form'));
        } elseif ($check == 5) {
            $seo_form = SeoForm::find($form_id);
            return view('manager.form.seoform', compact('seo_form'));
        } elseif ($check == 6) {
            $data = BookFormatting::find($form_id);
            return view('manager.form.bookformattingform', compact('data'));
        } elseif ($check == 7) {
            $data = BookWriting::find($form_id);
            return view('manager.form.bookwritingform', compact('data'));
        } elseif ($check == 8) {
            $data = AuthorWebsite::find($form_id);
            return view('manager.form.authorwebsiteform', compact('data'));
        } elseif ($check == 9) {
            $data = Proofreading::find($form_id);
            return view('manager.form.proofreadingform', compact('data'));
        } elseif ($check == 10) {
            $data = BookCover::find($form_id);
            return view('manager.form.bookcoverform', compact('data'));
        }
        // }else{
        //     return redirect()->back();
        // }
    }

    public function getFormSale($form_id, $check, $id)
    {
        $project = Project::find($id);
        // if($project->user_id == Auth()->user()->id){
        if ($check == 1) {
            $logo_form = LogoForm::find($form_id);
            return view('sale.form.logoform', compact('logo_form'));
        } else if ($check == 2) {
            $web_form = WebForm::find($form_id);
            return view('sale.form.webform', compact('web_form'));
        } elseif ($check == 3) {
            $smm_form = SmmForm::find($form_id);
            return view('sale.form.smmform', compact('smm_form'));
        } elseif ($check == 4) {
            $content_form = ContentWritingForm::find($form_id);
            return view('sale.form.contentform', compact('content_form'));
        } elseif ($check == 5) {
            $seo_form = SeoForm::find($form_id);
            return view('sale.form.seoform', compact('seo_form'));
        }
        // }else{
        //     return redirect()->back();
        // }
    }

    public function editProfile(){
        return view('support.edit-profile');
    }

    public function updateProfile($id, Request $request){
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
        ]);
        $user = User::find($id);
        if($request->has('file')){
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $file->move('uploads/users', $name);
            $path = 'uploads/users/'.$name;
            if($user->image != ''  && $user->image != null){
                $file_old = $user->image;
                unlink($file_old);
           } 
           $user->image = $path;   
        }
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $contact = $request->contact;
        if($contact == null){
            $contact = '#';
        }
        $user->contact = $contact;
        $user->update();
        return redirect()->back()->with('success', 'Profile Updated Successfully.');
    }

    public function changePassword()
    {
        return view('support.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        return redirect()->back()->with('success', 'Password Change Successfully.');
    }

    public function message()
    {
        $data = Project::where('user_id', Auth()->user()->id)->orderBy('id', 'desc')->get();
        $project = null;
        return view('support.message', compact('data', 'project'));
    }

    public function showMessage($id)
    {
        $project = Project::find($id);
        $data = Project::where('user_id', Auth()->user()->id)->orderBy('id', 'desc')->get();
        if (Auth()->user()->id == $project->user_id) {
            return view('support.message', compact('data', 'project'));
        } else {
            return redirect()->back();
        }
    }

    public function managerSendMessage(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);
        $carbon = Carbon::now(new DateTimeZone('America/Los_Angeles'))->toDateTimeString();
        $task = Task::find($request->task_id);
        $message = new Message();
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        if ($task == null) {
            $message->sender_id = $request->client_id;
            $message->client_id = $request->client_id;
        } else {
            $message->sender_id = $task->projects->client->id;
            $message->client_id = $task->projects->client->id;
        }
        $message->task_id = $request->task_id;
        $message->role_id = 6;
        $message->created_at = $carbon;
        $message->save();
        if ($request->hasfile('images')) {
            $i = 0;
            foreach ($request->file('images') as $file) {
                $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $name = $file_name . '_' . $i . '_' . time() . '.' . $file->extension();
                $file->move(public_path() . '/files/', $name);
                $i++;
                $client_file = new ClientFile();
                $client_file->name = $file_name;
                $client_file->path = $name;
                $client_file->task_id = $request->task_id;
                $client_file->user_id = Auth()->user()->id;
                $client_file->user_check = Auth()->user()->is_employee;
                $client_file->production_check = 2;
                $client_file->message_id = $message->id;
                $client_file->created_at = $carbon;
                $client_file->save();
            }
        }
        $details = [
            'title' => Auth()->user()->name . ' ' . Auth()->user()->last_name . ' has message on your task.',
            'body' => 'Please Login into your Dashboard to view it..'
        ];
        if ($task != null) {
            \Mail::to($task->projects->client->email)->send(new \App\Mail\ClientNotifyMail($details));
        } else {
            $client = User::find($request->client_id);
            \Mail::to($client->email)->send(new \App\Mail\ClientNotifyMail($details));
        }
        $task_id = 0;
        $project_id = 0;
        if ($task != null) {
            $task_id = $task->projects->id;
            $project_id = $task->projects->id;
        }

        $messageData = [
            'id' => Auth()->user()->id,
            'task_id' => $task_id,
            'project_id' => $project_id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => Auth()->user()->name . ' ' . Auth()->user()->last_name . ' has send you a Message',
            'details' => Str::limit(filter_var($request->message, FILTER_SANITIZE_STRING), 40),
            'url' => '',
        ];
        if ($task != null) {
            $task->projects->client->notify(new MessageNotification($messageData));
        } else {
            $client = User::find($request->client_id);
            $client->notify(new MessageNotification($messageData));
        }
        // Message Notification sending to Admin
        $adminusers = User::where('is_employee', 2)->get();
        foreach ($adminusers as $adminuser) {
            Notification::send($adminuser, new MessageNotification($messageData));
        }
        return redirect()->back()->with('success', 'Message Send Successfully.')->with('data', 'message');;
    }

    public function sendMessageChunks(Request $request)
    {
        // dd($request->file->getSize());
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        $save = $receiver->receive();
        if ($save->isFinished()) {
            if($request->client_id == 0){
                $get_client_id = Auth::user()->id;
                $get_message = $request->message;
                $set_email = strtolower(Auth::user()->email);
                return $this->saveFileToS3($save->getFile(), $set_email);
            }else{
                $get_client_id = $request->client_id;
                $get_message = $request->message;
                $client = User::find($get_client_id);
                $set_email = strtolower($client->email);
                return $this->saveFileToS3($save->getFile(), $set_email);
            }
        }

        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    protected function saveFileToS3($file, $email){

        $fileName = $this->createFilename($file);
        $file_actual_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $disk = Storage::disk('wasabi');
        $data = $disk->putFileAs('messages/'.$email, $file, $fileName);
        $disk->setVisibility($data, 'public');
        $mime = str_replace('/', '-', $file->getMimeType());
        unlink($file->getPathname());
        
        return response()->json([
            'path' => $disk,
            'name' => $fileName,
            'mime_type' =>$mime,
            'file' => $data,
            'actual_name' => $file_actual_name
        ]);
    }

    protected function createFilename(UploadedFile $file){
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName());
        $mytime = Carbon::now();
        $set_time = str_replace(' ', '-', $mytime->toDateTimeString());
        $filename .= "_" . $set_time . "." . $extension;
        return $filename;
    }

    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);
        $carbon = Carbon::now(new DateTimeZone('America/Los_Angeles'))->toDateTimeString();
        $task = Task::find($request->task_id);
        // send Notification to customer
        $message = new Message();
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        if ($task == null) {
            $message->sender_id = $request->client_id;
            $message->client_id = $request->client_id;
        } else {
            $message->sender_id = $task->projects->client->id;
            $message->client_id = $task->projects->client->id;
        }
        $message->role_id = 4;
        $message->created_at = $carbon;
        $message->save();
        $client = User::find($request->client_id);
        $set_email = strtolower($client->email);
        $get_files = [];

        if($request->sender_files){
            $files = $request->sender_files;
            if(count($files) != 0){
                for($i = 0; $i < count($files); $i++){
                    $client_file = new ClientFile();
                    $client_file->name = $files[$i]['name'];
                    $client_file->path = $files[$i]['file'];
                    $client_file->task_id = $request->task_id;
                    $client_file->user_id = Auth()->user()->id;
                    $client_file->user_check = Auth()->user()->is_employee;
                    $client_file->production_check = 2;
                    $client_file->message_id = $message->id;
                    $client_file->created_at = $carbon;
                    $client_file->save();
                    $get_files[$i]['path'] = $client_file->generatePresignedUrl();
                    $get_files[$i]['name'] = $files[$i]['name'];
                    $get_files[$i]['extension'] = $client_file->get_extension();
                }
            }
        }

        $details = [
            'sender_name' => Auth::user()->name . ' ' . Auth::user()->last_name,
            'sender_email' => Auth::user()->email,
            'brand_name' => $client->client->brand->name,
            'brand_logo' => $client->client->brand->logo,
            'brand_phone' => $client->client->brand->phone,
            'brand_email' => $client->client->brand->email,
            'brand_address' => $client->client->brand->address,
            'name' => $client->name,
            'email' => $client->email,
            'contact' => $client->contact,
            'date' => $carbon,
            'discription' => $request->message
        ];

        if ($task != null) {
            \Mail::to($task->projects->client->email)->send(new \App\Mail\ClientNotifyMail($details));
        } else {
            \Mail::to($client->email)->send(new \App\Mail\ClientNotifyMail($details));
        }
        $task_id = 0;
        $project_id = 0;
        if ($task != null) {
            $task_id = $task->projects->id;
            $project_id = $task->projects->id;
        }

        $messageData = [
            'id' => Auth()->user()->id,
            'task_id' => $task_id,
            'project_id' => $project_id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => Auth()->user()->name . ' ' . Auth()->user()->last_name . ' has send you a Message',
            'details' => Str::limit(filter_var($request->message, FILTER_SANITIZE_STRING), 40),
            'url' => '',
        ];
        if ($task != null) {
            $task->projects->client->notify(new MessageNotification($messageData));
        } else {
            $client = User::find($request->client_id);
            $client->notify(new MessageNotification($messageData));
            $last_notify = $client->notifications()->latest()->first();
        }

        // Message Notification sending to Admin
        $adminusers = User::where('is_employee', 2)->get();
        foreach ($adminusers as $adminuser) {
            Notification::send($adminuser, new MessageNotification($messageData));
        }
        
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $pusher->trigger('private.' .  $message->sender_id, 'receivemessage', [
            'title' => 'Incoming Message',
            'full_message' => $request->message ,
            'message' => \Illuminate\Support\Str::limit(strip_tags($request->message), 40, '...'),
            'user' => Auth::user(),
            'date' =>  now()->format('d m, y'),
            'image' => 'new-message.png',
            'link' => route('client.message', ['notify' => $last_notify->id]),
            'files' => $get_files
        ]);

        return response()->json([
            'status' => true,
            'files' => $get_files,
            'message' => nl2br($message->message),
            'user_name' => Auth::user()->name . ' ' . Auth::user()->last_name,
            'created_at' => date('h:m a - d M, Y', strtotime($message->created_at))
        ]);
    }

    public function sendMessageClient(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
            'task_id' => 'required',
        ]);
        $task = Task::find($request->task_id);
        $message = new Message();
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        $message->sender_id = 1;
        $message->task_id = $request->task_id;
        $message->client_id = Auth::user()->id;
        $message->save();
        $details = [
            'title' => $task->projects->client->name . ' ' . $task->projects->client->last_name . ' has message on your task.',
            'body' => 'Please Login into your Dashboard to view it..'
        ];
        \Mail::to($task->projects->added_by->email)->send(new \App\Mail\ClientNotifyMail($details));
        return response()->json(['success' => true, 'data' => $message->message, 'name' => Auth::user()->name . ' ' . Auth::user()->last_name, 'created_at' => $message->created_at->diffForHumans()]);
    }

    public function getMessageByManager()
    {

        $messages = Message::select('messages.*', DB::raw('MAX(messages.id) as max_id'))
            ->join('users', 'users.id', '=', 'messages.client_id')
            ->join('clients', 'users.client_id', '=', 'clients.id')
            ->where('messages.role_id', 3)
            ->whereIn('clients.brand_id', Auth()->user()->brand_list())
            ->groupBy('messages.client_id')
            ->orderBy('max_id', 'desc')
            ->paginate(20);
        return view('manager.messageshow', compact('messages'));
    }

    public function updateSupportMessage(Request $request)
    {
        $request->validate([
            'message_id' => 'required',
            'editmessage' => 'required',
        ]);
        $message = Message::find($request->message_id);
        if ($message != null) {
            $message->message = $request->editmessage;
            $message->save();
            return redirect()->back()->with('success', 'Message Updated Successfully.');
        }
        return redirect()->back()->with('success', 'Error Occured');
    }

    public function updateManagerMessage(Request $request)
    {
        $request->validate([
            'message_id' => 'required',
            'editmessage' => 'required',
        ]);
        $message = Message::find($request->message_id);
        if ($message != null) {
            $message->message = $request->editmessage;
            $message->save();
            return redirect()->back()->with('success', 'Message Updated Successfully.');
        }
        return redirect()->back()->with('success', 'Error Occured');
    }

    public function updateAdminMessage(Request $request)
    {
        $request->validate([
            'message_id' => 'required',
            'editmessage' => 'required',
        ]);
        $message = Message::find($request->message_id);
        if ($message != null) {
            $message->message = $request->editmessage;
            $message->save();
            return redirect()->back()->with('success', 'Message Updated Successfully.');
        }
        return redirect()->back()->with('success', 'Error Occured');
    }

    public function editMessageByManagerClientId($id)
    {
        $message = Message::find($id);
        return response()->json(['success' => true, 'data' => $message]);
    }

    public function editMessageByAdminClientId($id)
    {
        $message = Message::find($id);
        return response()->json(['success' => true, 'data' => $message]);
    }

    public function editMessageBySupportClientId($id)
    {
        $message = Message::find($id);
        return response()->json(['success' => true, 'data' => $message]);
    }

    public function getMessageBySupportClientId($id, $name, $notify = null)
    {
        if ($notify != null) {
            $Notification = Auth::user()->Notifications->find($notify);
            if ($Notification) {
                $Notification->markAsRead();
            }
        }
        $user = User::find($id);
        $messages = Message::where('client_id', $id)->get();
        DB::table('messages')
            ->where('client_id', $id)
            ->where('sender_seen', 0)
            ->update([
                'sender_seen' => 1,
            ]);
        return view('support.message.index', compact('messages', 'user'));
    }

    public function getMessageByAdminClientId($id, $name)
    {
        $user = User::find($id);
        $messages = Message::where('client_id', $id)->orderBy('id', 'asc')->get();
        return view('admin.message.index', compact('messages', 'user'));
    }

    public function getMessageByManagerClientId($id, $name)
    {
        $user = User::find($id);
        $messages = Message::where('client_id', $id)->orderBy('id', 'desc')->get();
        return view('manager.message.index', compact('messages', 'user'));
    }

    public function getMessageBySupport()
    {
        $datas = Project::where('user_id', Auth()->user()->id)->orderBy('id', 'desc')->get();
        $message_array = [];
        foreach ($datas as $data) {
            $task_array_id = array();
            $task_id = 0;
            if (count($data->tasks) != 0) {
                $task_id = $data->tasks[0]->id;
            }
            $message = Message::where('user_id', $data->client->id)->orWhere('sender_id', $data->client->id)->orderBy('id', 'desc')->first();
            if ($message != null) {
                $message_array[$data->client->id]['id'] = $data->client->id;
                $message_array[$data->client->id]['f_name'] = $data->client->name;
                $message_array[$data->client->id]['l_name'] = $data->client->last_name;
                $message_array[$data->client->id]['email'] = $data->client->email;
                $message_array[$data->client->id]['message'] = $message->message;
                $message_array[$data->client->id]['image'] = $data->client->image;
                $message_array[$data->client->id]['task_id'] = $task_id;
                $message_array[$data->client->id]['project_id'] = $data->id;
                $message_array[$data->client->id]['support_id'] = $data->user_id;
                $sender_seen = DB::table('messages')->where('user_id', $data->client->id)->orWhere('sender_id', $data->client->id)->get();
                $sender_seen = $sender_seen->where('sender_seen', 0)->count();
                if($sender_seen != 0){
                    $sender_seen = 1;
                }
                $message_array[$data->client->id]['sender_seen'] = $sender_seen;
                $message_array[$data->client->id]['created_at'] = $message->created_at->timestamp;
            }
        }
        if(count($message_array) != 0){
            usort($message_array, function($a, $b) {
                return $b['sender_seen'] <=> $a['sender_seen'];
            });
        }
        
        $objection_count = ProjectObjection::where('support_id','=',Auth::user()->id)
        ->where('status', '=',0)
        ->get()->count();
        
        return view('support.messageshow', compact('message_array','objection_count'));
    }

    public function getMessageByAdmin(Request $request)
    {
        // $filter = 0;
        // $message_array = [];
        // $datas = Project::orderBy('id', 'desc')->get();
        // if($request->message != ''){
        //     $task_id = 0;
        //     $messages = Message::where('message', 'like', '%' . $request->message . '%')->orderBy('id', 'desc')->get();
        //     foreach($messages as $message){
        //         if($message->user_name != null){
        //             $message_array[$message->user_name->id]['f_name'] = $message->user_name->name;
        //             $message_array[$message->user_name->id]['l_name'] = $message->user_name->last_name;
        //             $message_array[$message->user_name->id]['email'] = $message->user_name->email;
        //             $message_array[$message->user_name->id]['message'] = $message->message;
        //             $message_array[$message->user_name->id]['image'] = $message->user_name->image;
        //             $projects = Project::where('client_id', $message->user_name->id)->get();
        //             foreach($projects as $project){
        //                 foreach($project->tasks as $key => $tasks){
        //                     $message_array[$message->user_name->id]['task_id'][$key] = $tasks->id;
        //                 }
        //             }
        //         }
        //     }

        // }else{
        //     $filter = 1;
        //     foreach($datas as $data){
        //         $task_array_id = array();
        //         $task_id = 0;
        //         if(count($data->tasks) != 0){
        //             $task_id = $data->tasks[0]->id;
        //         }
        //         $message = Message::where('user_id', $data->client->id)->orWhere('sender_id', $data->client->id)->orderBy('id', 'desc')->first();
        //         if($message != null){
        //             $message_array[$data->client->id]['f_name'] = $data->client->name;
        //             $message_array[$data->client->id]['l_name'] = $data->client->last_name;
        //             $message_array[$data->client->id]['email'] = $data->client->email;
        //             $message_array[$data->client->id]['message'] = $message->message;
        //             $message_array[$data->client->id]['image'] = $data->client->image;
        //             $projects = Project::where('client_id', $data->client->id)->get();
        //             foreach($projects as $project){
        //                 foreach($project->tasks as $key => $tasks){
        //                     $message_array[$data->client->id]['task_id'][$key] = $tasks->id;
        //                 }
        //             }
        //         }
        //     }
        // }
        $filter = 0;
        $brands = DB::table('brands')->select('id', 'name')->get();

        $data = DB::table('messages')
            ->select(
                'messages.created_at',
                'messages.id as message_id',
                'brands.name as brand_name',
                'users.client_id',
                'messages.user_id',
                'users.name',
                'users.last_name',
                'users.email',
                'messages.message',
                'projects.user_id as support_id',
                'projects.id as project_id'
            )
            ->join('users', 'users.id', '=', 'messages.user_id')
            ->join('clients', 'clients.id', '=', 'users.client_id')
            ->join('brands', 'brands.id', '=', 'clients.brand_id')
            ->join('projects', 'projects.client_id', '=', 'messages.user_id')
            ->where('messages.role_id', 3)
            ->orderBy('messages.id', 'desc');

        if ($request->brand != null) {
            $data = $data->where('brands.id', $request->brand);
        }

        if($request->client_name != null){
            $data = $data->where('users.name', 'like', '%'.$request->client_name.'%')->orWhere('users.last_name', 'like', '%'.$request->client_name.'%')->orWhere('users.email', 'like', '%'.$request->client_name.'%');
        }

        if($request->message != ''){
            $message = $request->message;
            $data = $data->whereIn('messages.id', function($query) use ($message) {
                $query->select(DB::raw('MAX(messages.id)'))
                    ->from('messages')
                    ->where('messages.message', 'like', '%'.$message.'%')
                    ->groupBy('messages.user_id');
            });

        }else{
            $data = $data->whereIn('messages.id', function($query) {
                $query->select(DB::raw('MAX(messages.id)'))
                    ->from('messages')
                    ->where('messages.role_id', 3)
                    ->groupBy('messages.user_id');
            });
        }



        $data = $data->get();
        // $brand_array = [];
        // foreach ($brands as $key => $brand) {
        //     array_push($brand_array, $brand->id);
        // }
        // $message_array = [];
        // $data = User::where('is_employee', 3)->where('client_id', '!=', 0);
        // if ($request->brand != null) {
        //     $get_brand = $request->brand;
        //     $data = $data->whereHas('client', function ($query) use ($get_brand) {
        //         return $query->where('brand_id', $get_brand);
        //     });
        // } else {
        //     $data = $data->whereHas('client', function ($query) use ($brand_array) {
        //         return $query->whereIn('brand_id', $brand_array);
        //     });
        // }
        // if ($request->message != null) {
        //     $message = $request->message;
        //     $data = $data->whereHas('messages', function ($query) use ($message) {
        //         return $query->where('message', 'like', '%' . $message . '%');
        //     });
        // }
        // if($request->client_name != null){
        //     $client_name = $request->client_name;
        //     $data = $data->whereHas('client', function ($query) use ($client_name) {
        //         return $query->where('name', 'like', '%'.$client_name.'%')->orWhere('last_name', 'like', '%'.$client_name.'%')->orWhere('email', 'like', '%'.$client_name.'%');
        //     });
        // }
        // $data = $data->orderBy('id', 'desc')->paginate(20);
        
        return view('admin.messageshow', compact('brands', 'filter', 'data'));
    }
    
    public function ObjectionData(Request $request)
    {

        $objections = ProjectObjection::where('support_id', '=', $request->support_id)
            ->where('project_id', '=', $request->project_id)->get();
        // dd($objections);
        foreach ($objections as $obj) {
            $support = User::select('name')->where('id', '=', $obj->support_id)->first();
            $obj->support_name = $support->name;
            $user = User::select('name')->where('id', '=', $obj->user_id)->first();
            $obj->user_name = $user->name;
            if ($obj->resolved_by != null) {
                $resolved = User::select('name')->where('id', '=', $obj->resolved_by)->first();
                $obj->resolved = $resolved->name;
            } else {
                $obj->resolved = '';
            }
        }

        return response()->json(['success' => true, 'data' => $objections]);
    }
    public function CreateObjectionData(Request $request)
    {

        $objections = new ProjectObjection();
        $objections->message = $request->message;
        $objections->user_id = $request->user_id;
        $objections->support_id = $request->support_id;
        $objections->project_id = $request->project_id;
        $objections->status = 0;
        $objections->save();

        // Fetch the support name
        $support = User::select('name')->where('id', '=', $request->support_id)->first();
        $objections->support_name = $support ? $support->name : '';

        // Fetch the user name
        $user = User::select('name')->where('id', '=', $request->user_id)->first();
        $objections->user_name = $user ? $user->name : '';

        // Check if the objection was resolved and get the name of the user who resolved it
        if ($objections->resolved_by != null) {
            $resolved = User::select('name')->where('id', '=', $objections->resolved_by)->first();
            $objections->resolved = $resolved ? $resolved->name : '';
        } else {
            $objections->resolved = '';
        }

        $messageData = [
            'id' => Auth()->user()->id,
            'task_id' => '',
            'project_id' => $request->project_id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => Auth()->user()->name . ' ' . Auth()->user()->last_name . ' has raised an objection on a project',
            'details' => Str::limit(filter_var($request->message, FILTER_SANITIZE_STRING), 40),
            'url' => '#',
        ];

        $support = User::find($request->support_id);
        $support->notify(new ObjectionNotification($messageData));

        return response()->json(['success' => true, 'data' => $objections]);
    }

    public function updateObjectionStatus(Request $request){
        $objections = ProjectObjection::find($request->id);

        if($objections->status == 0){
            $objections->status = 1;
            $objections->resolved_by = Auth::user()->id;
            $objections->save();
        }else if($objections->status == 1){
            $objections->status = 0;
            $objections->resolved_by = Auth::user()->id;
            $objections->save();
        }

        return response()->json(['success' => true, 'resolved_by' => Auth::user()->name, 'status' => $objections->status]);
    }

    public function getObjectionDetails(Request $request){
        $objections = ProjectObjection::find($request->id);

        $support = User::select('name')->where('id', '=', $objections->support_id)->first();
        $objections->support_name = $support ? $support->name : '';

        // Fetch the user name
        $user = User::select('name')->where('id', '=', $objections->user_id)->first();
        $objections->user_name = $user ? $user->name : '';

        // Check if the objection was resolved and get the name of the user who resolved it
        if ($objections->resolved_by != null) {
            $resolved = User::select('name')->where('id', '=', $objections->resolved_by)->first();
            $objections->resolved = $resolved ? $resolved->name : '';
        } else {
            $objections->resolved = '';
        }
        return response()->json(['success' => true, 'data' => $objections]);
    }
    public function supportReplyObjection(Request $request){
        
        $objections = ProjectObjection::find($request->objection_id);
        $objections->support_reply = $request->message;
        $objections->save();
        
        return response()->json(['success' => true, 'data' => $objections]);
    }
}
