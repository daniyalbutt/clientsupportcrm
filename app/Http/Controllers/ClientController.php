<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Brand;
use App\Models\Task;
use App\Models\Category;
use App\Models\Message;
use App\Models\Merchant;
use App\Models\Service;
use App\Models\LogoForm;
use App\Models\WebForm;
use App\Models\SmmForm;
use App\Models\ContentWritingForm;
use App\Models\SeoForm;
use App\Models\BookFormatting;
use App\Models\BookCover;
use App\Models\BookWriting;
use App\Models\AuthorWebsite;
use App\Models\BookMarketing;
use App\Models\Proofreading;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use App\Models\Currency;
use DB;
use Pusher\Pusher;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Client;
        $data = $data->where('user_id', Auth()->user()->id);
        $data = $data->orderBy('id', 'desc');
        if ($request->name != '') {
            $data = $data->whereRaw(
                "TRIM(CONCAT(name, ' ', last_name)) like '%{$request->name}%'"
            );
        }
        if ($request->email != '') {
            $data = $data->where('email', 'LIKE', "%$request->email%");
        }
        if ($request->contact != '') {
            $data = $data->where('contact', 'LIKE', "%$request->contact%");
        }
        if ($request->status != '') {
            $data = $data->where('status', $request->status);
        }
        $data = $data->paginate(10);
        return view('sale.client.index', compact('data'));
    }

    public function managerClient(Request $request)
    {
        $data = new Client;
        $data = $data->whereIn('brand_id', Auth()->user()->brand_list());
        $data = $data->orderBy('id', 'desc');
        if ($request->name != '') {
            $data = $data->whereRaw(
                "TRIM(CONCAT(name, ' ', last_name)) like '%{$request->name}%'"
            );
        }
        if ($request->email != '') {
            $data = $data->where('email', 'LIKE', "%$request->email%");
        }
        if ($request->contact != '') {
            $data = $data->where('contact', 'LIKE', "%$request->contact%");
        }
        if ($request->status != '') {
            $data = $data->where('status', $request->status);
        }
        if ($request->brand != '') {
            $data = $data->where('brand_id', $request->brand);
        }

        $data = $data->paginate(20);
        return view('manager.client.index', compact('data'));
    }

    public function markAsRead()
    {
        $user = User::find(Auth()->user()->id);
        $user->notifications->markAsRead();
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sale.client.create');
    }

    public function managerClientCreate()
    {
        return view('manager.client.create');
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
        $request->request->add(['assign_id' => auth()->user()->id]);
        $client = Client::create($request->all());
        return redirect()->route('client.generate.payment', $client->id);
    }

    public function managerClientStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:clients,email',
            'status' => 'required',
            'brand_id' => 'required',
        ]);
        $request->request->add(['assign_id' => auth()->user()->id]);
        $client = Client::create($request->all());
        return redirect()->route('manager.generate.payment', $client->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Client::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if ($data == null) {
            return redirect()->back();
        } else {
            return view('sale.client.edit', compact('data'));
        }
    }

    public function managerClientEdit($id)
    {
        $data = Client::where('id', $id)->whereIn('brand_id', Auth::user()->brand_list())->first();
        if ($data == null) {
            return redirect()->back();
        } else {
            return view('manager.client.edit', compact('data'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */

    public function managerClientUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'email' => 'required|unique:clients,email,$id',
        ]);
        $client = Client::find($id);
        $client->name = $request->name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->brand_id = $request->brand_id;
        $client->contact = $request->contact;
        $client->save();
        $user = User::where('client_id', $id)->first();
        if ($user != null) {
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->save();
        }
        return redirect()->back()->with('success', 'Client Updated Successfully.');
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'status' => 'required',
        ]);
        $client->update($request->all());
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
        //
    }

    public function paymentLink($id)
    {
        $user = Client::find($id);
        $brand = Brand::whereIn('id', Auth()->user()->brand_list())->get();;
        $services = Service::all();
        $currencies =  Currency::all();
        $merchant = Merchant::orderBy('id', 'desc')->get();
        return view('sale.payment.create', compact('user', 'brand', 'currencies', 'services', 'merchant'));
    }

    public function managerPaymentLink($id)
    {
        $user = Client::find($id);
        $brand = Brand::whereIn('id', Auth()->user()->brand_list())->get();;
        $services = Service::all();
        $currencies =  Currency::all();
        $merchant = Merchant::where('status', 1)->where('hold_merchant', 0)->orderBy('id', 'desc')->get();
        return view('manager.payment.create', compact('user', 'brand', 'currencies', 'services', 'merchant'));
    }

    public function getClientBrief()
    {
        $data = array();
        if (count(Auth()->user()->logoForm) != 0) {
            foreach (Auth()->user()->logoForm as $logoForm) {
                $logo_form = LogoForm::find($logoForm->id);
                $logo_form->option = $logo_form->logo_name;
                $logo_form->form_type = 1;
                $logo_form->form_name = 'Logo';
                array_push($data, $logo_form);
            }
        }
        if (count(Auth()->user()->webForm) != 0) {
            foreach (Auth()->user()->webForm as $webForm) {
                $web_form = WebForm::find($webForm->id);
                $web_form->option = $web_form->business_name;
                $web_form->form_type = 2;
                $web_form->form_name = 'Web';
                array_push($data, $web_form);
            }
        }
        if (count(Auth()->user()->smmForm) != 0) {
            foreach (Auth()->user()->smmForm as $smmForm) {
                $smm_form = SmmForm::find($smmForm->id);
                $smm_form->option = $smm_form->business_name;
                $smm_form->form_type = 3;
                $smm_form->form_name = 'SMM';
                array_push($data, $smm_form);
            }
        }
        if (count(Auth()->user()->contentWritingForm) != 0) {
            foreach (Auth()->user()->contentWritingForm as $contentWritingForm) {
                $content_form = ContentWritingForm::find($contentWritingForm->id);
                $content_form->option = $content_form->company_name;
                $content_form->form_type = 4;
                $content_form->form_name = 'Content Writing';
                array_push($data, $content_form);
            }
        }
        if (count(Auth()->user()->soeForm) != 0) {
            foreach (Auth()->user()->soeForm as $soeForm) {
                $seo_form = SeoForm::find($soeForm->id);
                $seo_form->option = $seo_form->company_name;
                $seo_form->form_type = 5;
                $seo_form->form_name = 'SEO';
                array_push($data, $seo_form);
            }
        }
        if (count(Auth()->user()->bookFormattingForm) != 0) {
            foreach (Auth()->user()->bookFormattingForm as $bookFormatting) {
                $bookFormattingForm = BookFormatting::find($bookFormatting->id);
                $bookFormattingForm->option = $bookFormatting->book_title;
                $bookFormattingForm->form_type = 6;
                $bookFormattingForm->form_name = 'Book Formatting & Publishing Form';
                array_push($data, $bookFormattingForm);
            }
        }
        if (count(Auth()->user()->bookWritingForm) != 0) {
            foreach (Auth()->user()->bookWritingForm as $bookWriting) {
                $bookWritingForm = BookWriting::find($bookWriting->id);
                $bookWritingForm->option = $bookWriting->book_title;
                $bookWritingForm->form_type = 7;
                $bookWritingForm->form_name = 'Book Writing Form';
                array_push($data, $bookWritingForm);
            }
        }

        if (count(Auth()->user()->authorWesbiteForm) != 0) {
            foreach (Auth()->user()->authorWesbiteForm as $authorWesbiteForm) {
                $authorWebsiteForm = AuthorWebsite::find($authorWesbiteForm->id);
                $authorWebsiteForm->option = $authorWesbiteForm->author_name;
                $authorWebsiteForm->form_type = 8;
                $authorWebsiteForm->form_name = 'Author Website Form';
                array_push($data, $authorWebsiteForm);
            }
        }

        if (count(Auth()->user()->proofreading) != 0) {
            foreach (Auth()->user()->proofreading as $proofreading) {
                $proofreadingForm = Proofreading::find($proofreading->id);
                $proofreadingForm->option = $proofreading->author_name;
                $proofreadingForm->form_type = 9;
                $proofreadingForm->form_name = 'Editing & Proofreading Form';
                array_push($data, $proofreadingForm);
            }
        }

        if (count(Auth()->user()->bookcover) != 0) {
            foreach (Auth()->user()->bookcover as $bookcover) {
                $bookcover = BookCover::find($bookcover->id);
                $bookcover->option = $bookcover->author_name;
                $bookcover->form_type = 10;
                $bookcover->form_name = 'Book Cover Design Form';
                array_push($data, $bookcover);
            }
        }

        if (count(Auth()->user()->bookmarketing) != 0) {
            foreach (Auth()->user()->bookmarketing as $bookmarket) {
                $bookmarket = BookMarketing::find($bookmarket->id);
                $bookmarket->option = $bookmarket->author_name;
                $bookmarket->form_type = 11;
                $bookmarket->form_name = 'Book Marketing Form';
                array_push($data, $bookmarket);
            }
        }

        return view('client.brief', compact('data'));
    }

    public function getAssignedClient()
    {
        $data = Client::where('assign_id', Auth()->user()->id)->get();
        return view('sale.client.assigned', compact('data'));
    }

    public function clientProject()
    {
        $data = Task::whereHas('projects', function ($query) {
            return $query->whereNotNull('user_id')->where('client_id', Auth::user()->id);
        })->get();
        return view('client.project', compact('data'));
    }

    public function clientTaskshow($id, $notify = null)
    {
        // $notifications = Auth::user()->Notifications->markAsRead();
        if ($id != null) {
            $Notification = Auth::user()->Notifications->find($id);
            if ($Notification) {
                $Notification->markAsRead();
            }
        }
        $messages = Message::where('user_id', Auth::user()->id)->orWhere('sender_id', Auth::user()->id)->get();

        DB::table('messages')
            ->where('user_id', Auth::user()->id)
            ->orWhere('sender_id', Auth::user()->id)
            ->where('receiver_seen', 0)
            ->update([
                'receiver_seen' => 1,
            ]);

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $get_data = DB::table('messages')
            ->where('user_id', Auth::user()->id)
            ->where('role_id', '!=', 3)
            ->orWhere('sender_id', Auth::user()->id)
            ->first();


        if ($get_data) {
            $pusher->trigger('private.' .  $get_data->user_id . '-' . Auth::user()->id, 'seenmessage', [
                'user_id' => Auth::user()->id
            ]);
        }

        return view('client.task-show', compact('messages'));
    }

    public function messageSeen(Request $request){
        
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $pusher->trigger('private.' .  $request->id . '-' . Auth::user()->id, 'seenmessage', [
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['pusher' => $pusher]);

    }

    public function managerClientById($id, $name)
    {
        $user = User::find($id);
        if (in_array($user->client->brand->id, Auth()->user()->brand_list())) {
            $messages = Message::where('client_id', $id)->orderBy('id', 'desc')->limit(3)->get();
            return view('manager.client.show', compact('user', 'messages'));
        } else {
            return redirect()->back();
        }
    }

    public function clientDashboard()
    {
        return view('client.dashboard');
    }

    public function clientProfile(){
        return view('client.profile');
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
}
