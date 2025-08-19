<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoiceController;
use App\Models\Client;
use App\Models\Brand;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\LogoForm;
use App\Models\NoForm;
use App\Models\WebForm;
use App\Models\SmmForm;
use App\Models\BookFormatting;
use App\Models\BookWriting;
use App\Models\ContentWritingForm;
use App\Models\SeoForm;
use App\Models\AuthorWebsite;
use App\Models\Proofreading;
use App\Models\BookCover;
use App\Models\Project;
use Hash;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Notifications\AssignProjectNotification;
use Mail;
use App\Mail\WelcomeEmail;
use App\Models\BookMarketing;
use Carbon\Carbon;

class AdminClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = new Client;
        $data = $data->orderBy('id', 'desc');
        if($request->name != ''){
            $data = $data->where(DB::raw('concat(name," ",last_name)'), 'like', '%'.$request->name.'%');
        }
        if($request->email != ''){
            $data = $data->where('email', 'LIKE', "%$request->email%");
        }
        if($request->brand != ''){
            $data = $data->where('brand_id', $request->brand);
        }
        if($request->status != ''){
            $data = $data->where('status', $request->status);
        }
        $data = $data->paginate(20);
        $brands = DB::table('brands')->get();
        return view('admin.client.index', compact('data', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        return view('admin.client.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:clients,email',
            'status' => 'required',
            'brand_id' => 'required',
        ]);
        $request->request->add(['user_id' => auth()->user()->id]);
        $request->request->add(['assign_id' => auth()->user()->id]);
        Client::create($request->all());
        return redirect()->back()->with('success', 'Client created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */

    public function showNotification(Client $client, $id){

        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();
        return view('admin.client.show', compact('client'));
    }

    public function show(Client $client)
    {
        return view('admin.client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Client::find($id);
        $brands = Brand::all();
        return view('admin.client.edit', compact('data', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'brand_id' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,'.$client->id,
            'status' => 'required',
        ]);
        $client->update($request->all());
        $user = User::where('client_id', $client->id)->first();
        if($user != null){
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->save();
        }
        return redirect()->back()->with('success', 'Client Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->back()->with('success', 'Client Deleted Successfully.');
    }

    public function paymentLink($id){
        $user = Client::find($id);
        $brand = Brand::whereIn('id', Auth()->user()->brand_list())->get();;
        return view('admin.payment.create', compact('user', 'brand'));
    }

    public function createAuthManager(Request $request){
        $invoices = Invoice::where('client_id', $request->id)->get();
        $pass = $request->pass;
        $id = $request->id;
        $client = Client::find($id);
        $user = new User();
        $user->name = $client->name;
        $user->last_name = $client->last_name;
        $user->email = $client->email;
        $user->contact = $client->contact;
        $user->status = 1;
        $user->password = Hash::make($pass);
        $user->is_employee = 3;
        $user->client_id = $id;
        $user->save();
        foreach($invoices as $invoice){
            $invoice_controller = new InvoiceController;
            $invoice_controller->afterPaymentCheckForms($invoice->id);
        }
        $send_email_data = [
            'logo' => asset('global/img/logo.png'),
            'current_date' => Carbon::now(),
            'heading' => 'Welcome to ' . env('APP_NAME') . ' – Access Your Projects Today!',
            'content' => '<p>Dear '. $client->name . ' ' . $client->last_name .'</p><p>Welcome to '.env('APP_NAME').'!</p><p>We are thrilled to have you on board. YourProjectCamp is designed to give you seamless access and comprehensive oversight of your projects. To get started, we have set up your account with the following credentials:</p><p><b>Username:</b> '.$client->email.'<br><b>Password:</b> ' . $pass . '</p><p>You can log in using the credentials above at the following link: <a href="https://yourprojectcamp.com/">https://yourprojectcamp.com/</a></p><br><p>Once logged in, please follow these steps to get started:</p><ul><li><p>You will see a couple of forms related to the services you have opted for. Please fill these out to ensure we have all the necessary information.</p></li><li><p>A dedicated project manager will reach out to you in due course to further guide you through the process and help you manage your project better.</p></li></ul><p>Thank you for choosing ' . $client->brand->name . '. We look forward to supporting your needs and helping make your project a success story.</p>',
            'company_email' => env('APP_EMAIL'),
            'brand_name' => $client->brand->name
        ];
        Mail::to($client->email)->send(new WelcomeEmail($send_email_data, 'Welcome to ' . env('APP_NAME') . ' – Access Your Projects Today!'));
        return response()->json(['success' => true , 'message' => 'Login Created', 'password' => Hash::make($pass)]);
    }


    public function createAuth(Request $request){
        $invoices = Invoice::where('client_id', $request->id)->get();
        $pass = $request->pass;
        $id = $request->id;
        $client = Client::find($id);
        $user = new User();
        $user->name = $client->name;
        $user->last_name = $client->last_name;
        $user->email = $client->email;
        $user->contact = $client->contact;
        $user->status = 1;
        $user->password = Hash::make($pass);
        $user->is_employee = 3;
        $user->client_id = $id;
        $user->save();
        $client->user_id = $user->id;
        $client->save();
        foreach($invoices as $invoice){
            $invoice_controller = new InvoiceController;
            $invoice_controller->afterPaymentCheckForms($invoice->id);
        }
        $send_email_data = [
            'logo' => asset('global/img/logo.png'),
            'current_date' => Carbon::now(),
            'heading' => 'Welcome to ' . env('APP_NAME') . ' – Access Your Projects Today!',
            'content' => '<p>Dear '. $client->name . ' ' . $client->last_name .'</p><p>Welcome to '.env('APP_NAME').'!</p><p>We are thrilled to have you on board. YourProjectCamp is designed to give you seamless access and comprehensive oversight of your projects. To get started, we have set up your account with the following credentials:</p><p><b>Username:</b> '.$client->email.'<br><b>Password:</b> ' . $pass . '</p><p>You can log in using the credentials above at the following link: <a href="https://yourprojectcamp.com/">https://yourprojectcamp.com/</a></p><br><p>Once logged in, please follow these steps to get started:</p><ul><li><p>You will see a couple of forms related to the services you have opted for. Please fill these out to ensure we have all the necessary information.</p></li><li><p>A dedicated project manager will reach out to you in due course to further guide you through the process and help you manage your project better.</p></li></ul><p>Thank you for choosing ' . $client->brand->name . '. We look forward to supporting your needs and helping make your project a success story.</p>',
            'company_email' => env('APP_EMAIL'),
            'brand_name' => $client->brand->name
        ];
        Mail::to($client->email)->send(new WelcomeEmail($send_email_data, 'Welcome to ' . env('APP_NAME') . ' – Access Your Projects Today!'));
        return response()->json(['success' => true , 'message' => 'Login Created']);
    }

    public function updateAuthManager(Request $request){
        $id = $request->id;
        $pass = $request->pass;
        $user = User::where('client_id', $id)->first();
        $user->password = Hash::make($pass);
        $user->save();
        return response()->json(['success' => true , 'message' => 'Password Reset']);
    }

    public function updateAuth(Request $request){
        $id = $request->id;
        $pass = $request->pass;
        $user = User::where('client_id', $id)->first();
        $user->password = Hash::make($pass);
        $user->save();
        return response()->json(['success' => true , 'message' => 'Password Reset']);
    }

    public function getAgent($brand_id = null){
        $user = User::select('id', 'name', 'last_name')->where('is_employee', 4)->get();
        return response()->json(['success' => true , 'data' => $user]);
    }

    public function getAgentManager($brand_id = null){
        $user = User::select('id', 'name', 'last_name')->where('is_employee', 4)->whereHas('brands', function ($query) use ($brand_id) {
                    return $query->where('brand_id', $brand_id);
                })->get();
        return response()->json(['success' => true , 'data' => $user]);
    }

    public function updateAgent(Request $request){
        $client = Client::find($request->id);
        $client->assign_id = $request->agent_id;
        $client->save();
        return response()->json(['success' => true , 'message' => 'Agent Added Successfully']);
    }

    public function reassignSupportManager(Request $request){
        $project = Project::find($request->id);
        $project->user_id = $request->agent_id;
        $project->save();
        return redirect()->back()->with('success', $project->name . ' Reassigned Successfully');
    }

    public function assignSupportManager(Request $request){
        $form_id  = $request->id;
        $agent_id  = $request->agent_id;
        $form_checker  = $request->form;
        $name = '';
        $client_id = 0;
        $brand_id = 0;
        $description = '';
        if($form_checker == 0){
            $no_form = NoForm::find($form_id);
            if($no_form->name != null){
                $name = $no_form->name . ' - OTHER';
            }else{
                $name = $no_form->name . ' - OTHER';
            }
            $client_id = $no_form->user->id;
            $brand_id = $no_form->invoice->brand;
            $description = $no_form->business;

        }elseif($form_checker == 1){
            // Logo form
            $logo_form = LogoForm::find($form_id);
            if($logo_form->logo_name != null){
                $name = $logo_form->logo_name . ' - LOGO';
            }else{
                $name = $logo_form->user->name . ' - LOGO';
            }
            $client_id = $logo_form->user->id;
            $brand_id = $logo_form->invoice->brand;
            $description = $logo_form->business;
        }elseif($form_checker == 2){
            // Web form
            $web_form = WebForm::find($form_id);
            if($web_form->business_name != null){
                $name = $web_form->business_name . ' - WEBSITE';
            }else{
                $name = $web_form->user->name . ' - WEBSITE';
            }
            $client_id = $web_form->user->id;
            $brand_id = $web_form->invoice->brand;
            $description = $web_form->about_companys;
        }elseif($form_checker == 3){
            // Social Media Marketing Form
            $smm_form = SmmForm::find($form_id);
            if($smm_form->business_name != null){
                $name = $smm_form->business_name . ' - SMM';
            }else{
                $name = $smm_form->user->name . ' - SMM';
            }
            $client_id = $smm_form->user->id;
            $brand_id = $smm_form->invoice->brand;
            $description = $smm_form->business_category;
        }elseif($form_checker == 4){
            // Content Writing Form
            $content_form = ContentWritingForm::find($form_id);
            if($content_form->company_name != null){
                $name = $content_form->company_name . ' - CONTENT WRITING';
            }else{
                $name = $content_form->user->name . ' - CONTENT WRITING';
            }
            $client_id = $content_form->user->id;
            $brand_id = $content_form->invoice->brand;
            $description = $content_form->company_details;
        }elseif($form_checker == 5){
            // Search Engine Optimization Form
            $seo_form = SeoForm::find($form_id);
            if($seo_form->company_name != null){
                $name = $seo_form->company_name . ' - SEO';
            }else{
                $name = $seo_form->user->name . ' - SEO';
            }
            $client_id = $seo_form->user->id;
            $brand_id = $seo_form->invoice->brand;
            $description = $seo_form->top_goals;
        }elseif($form_checker == 6){
            // Book Formatting & Publishing Form
            $book_formatting_form = BookFormatting::find($form_id);
            if($book_formatting_form->book_title != null){
                $name = $book_formatting_form->book_title . ' - Book Formatting & Publishing';
            }else{
                $name = $book_formatting_form->user->name . ' - Book Formatting & Publishing';
            }
            $client_id = $book_formatting_form->user->id;
            $brand_id = $book_formatting_form->invoice->brand;
            $description = $book_formatting_form->additional_instructions;
        }elseif($form_checker == 7){
            // Book Writing Form
            $book_writing_form = BookWriting::find($form_id);
            if($book_writing_form->book_title != null){
                $name = $book_writing_form->book_title . ' - Book Writing';
            }else{
                $name = $book_writing_form->user->name . ' - Book Writing';
            }
            $client_id = $book_writing_form->user->id;
            $brand_id = $book_writing_form->invoice->brand;
            $description = $book_writing_form->brief_summary;
        }elseif($form_checker == 8){
            // Author Website Form
            $author_website_form = AuthorWebsite::find($form_id);
            if($author_website_form->author_name != null){
                $name = $author_website_form->author_name . ' - Author Website';
            }else{
                $name = $author_website_form->user->name . ' - Author Website';
            }
            $client_id = $author_website_form->user->id;
            $brand_id = $author_website_form->invoice->brand;
            $description = $author_website_form->brief_overview;
        }elseif($form_checker == 9){
            // Editing & Proofreading Form
            $proofreading_form = Proofreading::find($form_id);
            if($proofreading_form->author_name != null){
                $name = $proofreading_form->description . ' - Editing & Proofreading';
            }else{
                $name = $proofreading_form->user->name . ' - Editing & Proofreading';
            }
            $client_id = $proofreading_form->user->id;
            $brand_id = $proofreading_form->invoice->brand;
            $description = $proofreading_form->guide;
        }elseif($form_checker == 10){
            // Cover Design Form
            $bookcover_form = BookCover::find($form_id);
            if($bookcover_form->author_name != null){
                $name = $bookcover_form->title . ' - Cover Design';
            }else{
                $name = $bookcover_form->user->name . ' - Cover Design';
            }
            $client_id = $bookcover_form->user->id;
            $brand_id = $bookcover_form->invoice->brand;
            $description = $bookcover_form->information;
        }elseif($form_checker == 11){
            // Cover Design Form
            $bookmarketing_form = BookMarketing::find($form_id);
            if($bookmarketing_form->title != null){
                $name = $bookmarketing_form->title . ' - Book Marketing';
            }else{
                $name = $bookmarketing_form->user->name . ' - Book Marketing';
            }
            $client_id = $bookmarketing_form->user->id;
            $brand_id = $bookmarketing_form->invoice->brand;
            $description = $bookmarketing_form->information;
        }

        $project = new Project();
        $project->name = $name;
        $project->description = $description;
        $project->status = 1;
        $project->user_id = $agent_id;
        $project->client_id = $client_id;
        $project->brand_id = $brand_id;
        $project->form_id = $form_id;
        $project->form_checker = $form_checker;
        $project->save();
        $assignData = [
            'id' => Auth()->user()->id,
            'project_id' => $project->id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => $project->name . ' has assign. ('.Auth()->user()->name.')',
            'url' => '',
        ];
        $user = User::find($agent_id);
        $user->notify(new AssignProjectNotification($assignData));
        return redirect()->back()->with('success', $user->name . ' ' . $user->last_name . ' Assigned Successfully');
    }

    public function assignSupport(Request $request){
        $form_id  = $request->id;
        $agent_id  = $request->agent_id;
        $form_checker  = $request->form;
        $name = '';
        $client_id = 0;
        $brand_id = 0;
        $description = '';
        if($form_checker == 1){
            // Logo form
            $logo_form = LogoForm::find($form_id);
            $name = $logo_form->logo_name . ' - LOGO';
            $client_id = $logo_form->user->id;
            $brand_id = $logo_form->invoice->brand;
            $description = $logo_form->business;
        }elseif($form_checker == 2){
            // Web form
            $web_form = WebForm::find($form_id);
            $name = $web_form->business_name . ' - WEBSITE';
            $client_id = $web_form->user->id;
            $brand_id = $web_form->invoice->brand;
            $description = $web_form->about_companys;
        }elseif($form_checker == 3){
            // Social Media Marketing Form
            $smm_form = SmmForm::find($form_id);
            $name = $smm_form->business_name . ' - SMM';
            $client_id = $smm_form->user->id;
            $brand_id = $smm_form->invoice->brand;
            $description = $smm_form->business_category;
        }elseif($form_checker == 4){
            // Content Writing Form
            $content_form = ContentWritingForm::find($form_id);
            $name = $content_form->company_name . ' - CONTENT WRITING';
            $client_id = $content_form->user->id;
            $brand_id = $content_form->invoice->brand;
            $description = $content_form->company_details;
        }elseif($form_checker == 5){
            // Search Engine Optimization Form
            $seo_form = SeoForm::find($form_id);
            $name = $seo_form->company_name . ' - SEO';
            $client_id = $seo_form->user->id;
            $brand_id = $seo_form->invoice->brand;
            $description = $seo_form->top_goals;
        }
        $project = new Project();
        $project->name = $name;
        $project->description = $description;
        $project->status = 1;
        $project->user_id = $agent_id;
        $project->client_id = $client_id;
        $project->brand_id = $brand_id;
        $project->form_id = $form_id;
        $project->form_checker = $form_checker;
        $project->save();
        $assignData = [
            'id' => Auth()->user()->id,
            'project_id' => $project->id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => $project->name . ' has assign. ('.Auth()->user()->name.')',
            'url' => '',
        ];
        $user = User::find($agent_id);
        $user->notify(new AssignProjectNotification($assignData));
        return response()->json(['success' => true , 'message' => 'Support Assigned Successfully']);
    }
}
