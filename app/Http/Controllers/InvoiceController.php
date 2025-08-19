<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Models\Invoice;
use App\Models\InvoiceLogs;
use App\Models\Client;
use App\Models\ClientAuthorizeCustomer;
use App\Models\ClientAuthorize;
use App\Models\User;
use App\Models\Brand;
use App\Models\NoForm;
use App\Models\Merchant;
use App\Models\LogoForm;
use App\Models\WebForm;
use App\Models\SmmForm;
use App\Models\ContentWritingForm;
use App\Models\SeoForm;
use App\Models\BookFormatting;
use App\Models\BookWriting;
use App\Models\AuthorWebsite;
use App\Models\Proofreading;
use App\Models\BookCover;
use App\Models\BookMarketing;
use App\Models\Currency;
use App\Models\Service;
use Illuminate\Http\Request;
use Auth;
use Stripe;
use Illuminate\Support\Facades\DB;
use Notification;
use App\Notifications\PaymentNotification;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Pusher\Pusher;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = Client::find($id);
        $brand = Brand::all();
        $services = Service::all();
        $currencies =  Currency::all();
        return view('admin.invoice.create', compact('user', 'brand', 'currencies', 'services'));
    }

    public function invoiceAll(Request $request){
        $data = new Invoice();
        $brands = Brand::all();
        $merchants = Merchant::where('status', 1)->get();
        $data = $data->orderBy('id', 'desc');
        if($request->package != ''){
            $data = $data->where('custom_package', 'LIKE', "%$request->package%");
        }
        if($request->invoice != ''){
            $data = $data->where('invoice_number', 'LIKE', "%$request->invoice%");
        }
        if($request->customer != ''){
            $customer = $request->customer;
            $data = $data->whereHas(
                'client', function($q) use($customer){
                    $q->whereRaw(
                        "TRIM(CONCAT(name, ' ', last_name)) like '%{$customer}%'"
                    );
                }
            );
        }
        if($request->agent != ''){
            $agent = $request->agent;
            $data = $data->whereHas(
                'sale', function($q) use($agent){
                    $q->whereRaw(
                        "TRIM(CONCAT(name, ' ', last_name)) like '%{$agent}%'"
                    );
                }
            );
        }
        if($request->status != 0){
            $data = $data->where('payment_status', $request->status);
        }
        if($request->brand != 0){
            $brand = $request->brand;
            $data = $data->whereHas('brands', function($q) use($brand){
                        $q->where('id', $brand);
                    });
        }

        if($request->merchant != ''){
            $data = $data->where('merchant_id', $request->merchant);
        }

        $data = $data->paginate(10);
        $display = '';
        if ($request->ajax()) {
            foreach ($data as $rander) {
                $form = '';
                if($rander->payment_status == 1){
                    $form = '<form method="post" action="'.route('admin.invoice.paid', $rander->id).'">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <button type="submit" class="mark-paid btn btn-danger p-0">Mark As Paid</button>
                    </form>';
                }
                $display .=
                '<tr>
                    <td><span class="btn btn-primary btn-sm">#'.$rander->invoice_number.'</span></td>
                    <td>'. ($rander->package == 0 ? $rander->custom_package : $rander->package) .'</td>
                    <td>'. $rander->client->name . ' ' . $rander->client->last_name . '<br>' . $rander->client->email .'</td>
                    <td>'. ($rander->sales_agent_id != 0 ? $rander->sale->name . ' ' . $rander->sale->last_name : 'From Website') .'</td>
                    <td><button class="btn btn-sm btn-secondary">'. $rander->brands->name .'</button></td>
                    <td>'. $rander->currency_show->sign .''. $rander->amount.'</td>
                    <td>
                        <span class="btn btn-'.\App\Models\Invoice::STATUS_COLOR[$rander->payment_status].' btn-sm">
                            '.\App\Models\Invoice::PAYMENT_STATUS[$rander->payment_status].
                            $form.'
                        </span>
                    </td>
                    <td>'. $rander->merchant->name .'<br><button class="btn btn-sm btn-secondary">'.$rander->merchant->get_merchant_name().'</button></td>
                    <td><button class="btn btn-sm btn-secondary">'.date('g:i a - d M, Y', strtotime($rander->created_at)).'</button></td>
                    <td>
                        <a href="'. route('admin.invoice.edit', ['id' => $rander->id]).'" class="btn btn-blue btn-icon">
                            <span class="ul-btn__icon"><i class="i-Edit"></i></span>
                        </a>
                        <a href="'.route('admin.link', $rander->id).'" class="btn btn-info btn-icon">
                            <span class="ul-btn__icon"><i class="i-Eye-Visible"></i></span>
                        </a>
                        <form method="POST" action="'. route('admin.invoice.delete', $rander->id).'" style="display: inline-block;" onsubmit="return confirm("Are you sure you want to submit?");">
                            '. method_field("DELETE") .'
                            '. csrf_field() .'
                            <button class="btn btn-danger btn-icon" type="submit">
                                <span class="ul-btn__icon"><i class="i-Folder-Trash"></i></span>
                            </button>
                        </form>
                    </td>
                </tr>';
            }
            return $display;
        }
        return view('admin.invoice.index', compact('data', 'brands', 'merchants'));
    }

    public function getInvoice(){

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $get_brand = Brand::find($request->brand);
        $get_short_brand = implode('', array_map(function($v) { return $v[0]; }, explode(' ', $get_brand->name)));
        $invoice_number = date('ymd').$get_short_brand.$request->amount;
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'brand' => 'required',
            'service' => 'required',
            'package' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'merchant' => 'required'
        ]);
        $latest = Invoice::latest()->first();
        if (! $latest) {
            $numPadded = sprintf("%04d", 1);
            $nextInvoiceNumber = $invoice_number . $numPadded;
        }else{
            $numPadded = sprintf("%04d", $latest->id + 1);
            $nextInvoiceNumber = $invoice_number . $numPadded;
        }
        $contact = $request->contact;
        if($contact == null){
            $contact = '#';
        }

		$invoice = new Invoice;
        $invoice->createform = $request->createform;
        $invoice->name = $request->name;
        $invoice->email = $request->email;
        $invoice->contact = $contact;
        $invoice->brand = $request->brand;
        $invoice->package = $request->package;
        $invoice->currency = $request->currency;
        $invoice->client_id = $request->client_id;
        $invoice->invoice_number = $nextInvoiceNumber;
        $invoice->sales_agent_id = Auth()->user()->id;
        $invoice->discription = $request->discription;
        $invoice->amount = $request->amount;
        $invoice->payment_status = '1';
        $invoice->custom_package = $request->custom_package;
        $invoice->payment_type = $request->payment_type;
		$service = implode(",",$request->service);
		$invoice->service = $service;
        $invoice->merchant_id = $request->merchant;
        $invoice->invoice_id = bin2hex(random_bytes(24));
        $invoice->save();
		$id = $invoice->id;

        $id = Crypt::encrypt($id);
		$invoiceId = Crypt::decrypt($id);
		$_getInvoiceData = Invoice::findOrFail($invoiceId);
		$_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        $package_name = '';
        if($_getInvoiceData->package == 0){
            $package_name = strip_tags($_getInvoiceData->custom_package);
        }
        $sendemail = $request->sendemail;
        if($sendemail == 1){
            // Send Invoice Link To Email
            $details = [
                'brand_name' => $_getBrand->name,
                'brand_logo' => $_getBrand->logo,
                'brand_phone' => $_getBrand->phone,
                'brand_email' => $_getBrand->email,
                'brand_address' => $_getBrand->address,
                'invoice_number' => $_getInvoiceData->invoice_number,
                'currency_sign' => $_getInvoiceData->currency_show->sign,
                'amount' => $_getInvoiceData->amount,
                'name' => $_getInvoiceData->name,
                'email' => $_getInvoiceData->email,
                'contact' => $_getInvoiceData->contact,
                'date' => $_getInvoiceData->created_at->format('jS M, Y'),
                'link' => route('client.paynow', $id),
                'package_name' => $package_name,
                'discription' => $_getInvoiceData->discription
            ];
            // \Mail::to($_getInvoiceData->email)->send(new \App\Mail\InoviceMail($details));
        }
		return redirect()->route('admin.link',($invoice->id));
    }

    public function invoiceEdit($id){
        $data = Invoice::find($id);
        $user = Client::find($data->client_id);
        $brand = Brand::all();
        $services = Service::all();
        $currencies =  Currency::all();
        return view('admin.invoice.edit', compact('data', 'user', 'brand', 'services', 'currencies'));
    }

    public function linkPage($id){
		$id = Crypt::encrypt($id);
		$invoiceId = Crypt::decrypt($id);
		$_getInvoiceData = Invoice::findOrFail($invoiceId);
		$_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        return view('admin.invoice.link-page', compact('_getInvoiceData', 'id', '_getInvoiceData', '_getBrand'));
    }

    public function updateInvoice($id, Request $request){
        $invoice = Invoice::find($id);
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'brand' => 'required',
            'service' => 'required',
            'package' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'merchant' => 'required'
        ]);
        $contact = '#';
        if($request->contact != null){
            $contact = $request->contact;
        }
        $invoice->createform = $request->createform;
        $invoice->name = $request->name;
        $invoice->email = $request->email;
        $invoice->contact = $contact;
        $invoice->brand = $request->brand;
        $invoice->package = $request->package;
        $invoice->currency = $request->currency;
        $invoice->client_id = $request->client_id;
        $invoice->discription = $request->discription;
        $invoice->amount = $request->amount;
        $invoice->custom_package = $request->custom_package;
        $invoice->payment_type = $request->payment_type;
        $service = implode(",",$request->service);
        $invoice->service = $service;
        $invoice->merchant_id = $request->merchant;
        $invoice->invoice_id = bin2hex(random_bytes(24));
        $invoice->save();
        $id = $invoice->id;

        $id = Crypt::encrypt($id);
        $invoiceId = Crypt::decrypt($id);
        $_getInvoiceData = Invoice::findOrFail($invoiceId);
        $_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        $package_name = '';
        if($_getInvoiceData->package == 0){
            $package_name = strip_tags($_getInvoiceData->custom_package);
        }
        $sendemail = $request->sendemail;
        if($sendemail == 1){
            // Send Invoice Link To Email
            $details = [
                'brand_name' => $_getBrand->name,
                'brand_logo' => $_getBrand->logo,
                'brand_phone' => $_getBrand->phone,
                'brand_email' => $_getBrand->email,
                'brand_address' => $_getBrand->address,
                'invoice_number' => $_getInvoiceData->invoice_number,
                'currency_sign' => $_getInvoiceData->currency_show->sign,
                'amount' => $_getInvoiceData->amount,
                'name' => $_getInvoiceData->name,
                'email' => $_getInvoiceData->email,
                'contact' => $_getInvoiceData->contact,
                'date' => $_getInvoiceData->created_at->format('jS M, Y'),
                'link' => route('client.paynow', $id),
                'package_name' => $package_name,
                'discription' => $_getInvoiceData->discription
            ];
            // \Mail::to($_getInvoiceData->email)->send(new \App\Mail\InoviceMail($details));
        }
        return redirect()->route('admin.link',($invoice->id));
    }

    public function linkPageSale($id){
		$id = Crypt::encrypt($id);
		$invoiceId = Crypt::decrypt($id);
		$_getInvoiceData = Invoice::findOrFail($invoiceId);
		$_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        return view('sale.invoice.link-page', compact('_getInvoiceData', 'id', '_getInvoiceData', '_getBrand'));
    }

    public function linkPageManager($id){
		$id = Crypt::encrypt($id);
		$invoiceId = Crypt::decrypt($id);
		$_getInvoiceData = Invoice::findOrFail($invoiceId);
		$_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        return view('manager.invoice.link-page', compact('_getInvoiceData', 'id', '_getInvoiceData', '_getBrand'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoice)
    {
        $data = Invoice::find($invoice);
        $data->delete();
        return redirect()->back()->with('success','Invoice Deleted Successfully');
    }

    public function payNow($id){
		$_getInvoiceData = Invoice::where('invoice_id', $id)->first();
        if($_getInvoiceData->merchant->hold_merchant == 1){
            abort(404);
        }
        $_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        if($_getInvoiceData->merchant->is_authorized == 4){
            return view('invoice.thriftypayments', compact('_getInvoiceData','_getBrand'));
        }
        if($_getInvoiceData->merchant->is_authorized == 1){
            return view('invoice.stripe', compact('_getInvoiceData','_getBrand'));
        }
        if($_getInvoiceData->merchant->is_authorized == 5){
            return view('invoice.nexio', compact('_getInvoiceData','_getBrand'));
        }
        if($_getInvoiceData->merchant->is_authorized == 6){
            return view('invoice.paypal', compact('_getInvoiceData','_getBrand'));
        }
        if($_getInvoiceData->merchant->is_authorized == 7){
            return view('invoice.maverick', compact('_getInvoiceData','_getBrand'));
        }
        if($_getInvoiceData->merchant->is_authorized == 8){
            return view('invoice.square', compact('_getInvoiceData','_getBrand'));
        }
        if($_getInvoiceData->merchant->is_authorized == 9){
            return view('invoice.nmi', compact('_getInvoiceData','_getBrand'));
        }
        return view('invoice.paynow', compact('_getInvoiceData','_getBrand'));
    }

    public function managerPaymentAuto(Request $request){
        $invoice_id = $request->invoice_id;
        $profileid = $request->customer_profile_id;
        $paymentprofileid = $request->payment_profile_id;
        $invoiceData = Invoice::findOrFail($invoice_id);

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($invoiceData->merchant->public_key);
        $merchantAuthentication->setTransactionKey($invoiceData->merchant->secret_key);
        $refId = 'ref' . time();

        $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
        $profileToCharge->setCustomerProfileId($profileid);
        $paymentProfile = new AnetAPI\PaymentProfileType();
        $paymentProfile->setPaymentProfileId($paymentprofileid);
        $profileToCharge->setPaymentProfile($paymentProfile);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType( "authCaptureTransaction");
        $transactionRequestType->setAmount($invoiceData->amount);
        $transactionRequestType->setProfile($profileToCharge);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId( $refId);
        $request->setTransactionRequest( $transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);
        if($invoiceData->merchant->live_mode == 0){
            $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }else{
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }

        $invoice_logs = new InvoiceLogs();
        $invoice_logs->invoice_id = $invoice_id;
        $invoice_logs->return_response = json_encode($response);

        if ($response != null){
            if($response->getMessages()->getResultCode() == "Ok"){
                $tresponse = $response->getTransactionResponse();
                $invoice_logs->return_tresponse = json_encode($tresponse);
                $invoice_logs->save();
	            if ($tresponse != null && $tresponse->getMessages() != null){
                    $get_invoice = Invoice::findOrFail($invoice_id);
                    if($get_invoice){
                        $get_invoice->transaction_id = $tresponse->getTransId();
                        $get_invoice->payment_status = '2';
                        $get_invoice->invoice_date = Carbon::today()->toDateTimeString();
                        $get_invoice->save();
                    }
                    $this->afterPaymentCheckForms($get_invoice);
                    return response()->json(['success' => true , 'message' => $tresponse->getMessages()[0]->getDescription()]);
                }else{
                    if($tresponse->getErrors() != null){
                        return response()->json(['error' => true , 'message' => $tresponse->getErrors()[0]->getErrorCode() . ' - ' . $tresponse->getErrors()[0]->getErrorText()]);
                    }
                }
            }else{
                $tresponse = $response->getTransactionResponse();
                $invoice_logs->return_tresponse = json_encode($tresponse);
                $invoice_logs->save();
                if($tresponse != null && $tresponse->getErrors() != null){
                    return response()->json(['error' => true , 'message' => $tresponse->getErrors()[0]->getErrorCode() . ' - ' . $tresponse->getErrors()[0]->getErrorText()]);
                }else{
                    return response()->json(['error' => true , 'message' => $response->getMessages()->getMessage()[0]->getCode() . ' - ' . $response->getMessages()->getMessage()[0]->getText()]);
                }
            }
        }else{
            $invoice_logs->save();
            return response()->json(['error' => true , 'message' => 'No response returned']);
            echo  "No response returned \n";
        }

        // return response()->json(['success' => true , 'message' => $tresponse->getMessages()[0]->getDescription()]);
    }

    public function managerPaymentPaybynmi(Request $request){
        $invoice_id = $request->invoice_id;
        $invoiceData = Invoice::findOrFail($invoice_id);

        $data = ClientAuthorizeCustomer::find($request->client_authorize_customers_id);

        if($invoiceData->merchant->is_authorized == 7){
            $url = 'https://groovepay.transactiongateway.com/api/transact.php';
        }elseif($invoiceData->merchant->is_authorized == 4){
            $url = 'https://thriftypayments.transactiongateway.com/api/transact.php';
        }elseif($invoiceData->merchant->is_authorized == 5){
            $url = 'https://secure.expigate.com/api/transact.php';
        }

        $vars = "security_key=".$invoiceData->merchant->secret_key
        . "&type=sale"
        . "&amount=". $invoiceData->amount
        . "&first_name=". $invoiceData->client->name
        . "&last_name=". $invoiceData->client->last_name
        . "&email=". $invoiceData->client->email
        . "&ccnumber=". $data->get_ccnumber()
        . "&ccexp=" . $data->get_ccexp()
        . "&cvv=" . $data->get_cvv();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $output = $server_output;
        $output_data = explode('&', $output);
        $array = [];
        foreach($output_data as $key => $value){
            $data_output = explode('=', $value);
            $array[$data_output[0]] = $data_output[1];
        }
        $update_payment = Invoice::find($invoice_id);
        if($array['response'] == 1){
            $update_payment->payment_status = 2;
        }else{
            $update_payment->payment_status = 5;
        }
        $update_payment->invoice_date = Carbon::today()->toDateTimeString();
        $update_payment->return_response = $array['responsetext'];
        $update_payment->return_tresponse = json_encode($array);
        $update_payment->transaction_id = $array['transactionid'];
        $update_payment->save();

        if($array['response'] == 1){
            return response()->json(['success' => true , 'message' => $array['responsetext']]);
        }else{
            $message_text = $array['responsetext'];
            return response()->json(['success' => false , 'message' => $message_text]);
        }
        
    }

    public function paymentProcess(Request $request)
    {
        $invoiceId = $request->invoice_id;
	    $invoiceData = Invoice::findOrFail($invoiceId);

        if($invoiceData->payment_status != 1){
            return redirect()->back();
        }

        if($invoiceData->merchant->hold_merchant == 1){
            abort(404);
        }

        if($invoiceData->merchant == null){
            $merchant = DB::table('merchants')->where('secret_key', env('STRIPE_SECRET'))->first();
            $merchant_name = $merchant->name;
        }else{
            $merchant_name = $invoiceData->merchant->name;
        }
        $temp = explode(' ', $invoiceData->brands->name);
        $result = '';
        foreach($temp as $t){
            $result .= $t[0];
        }

	    $customerName = $request->user_name;
        $customerEmail = $request->user_email;
        $customerPhone = $request->user_phone;
        $customerAddress = $request->address;
        $ServiceAmount = $invoiceData->amount;
        $token = $request->stripeToken;
        $packageName = $invoiceData->package;
        if($invoiceData->package == 0){
            $packageName = $invoiceData->custom_package;
        }
        $merchant = 1;
        if($invoiceData->merchant_id == null){
            $merchant = 1;
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        }else{
            if($invoiceData->merchant->is_authorized == 2){
                // Authorize
                $merchant = 2;
            }elseif($invoiceData->merchant->is_authorized == 1){
                // STRIPE
                $merchant = 1;
                $stripe = new \Stripe\StripeClient($invoiceData->merchant->secret_key);
            }elseif($invoiceData->merchant->is_authorized == 3){
                $merchant = 3;
            }elseif($invoiceData->merchant->is_authorized == 4){
                // Thrifty Payments Inc.
                $merchant = 4;
            }elseif($invoiceData->merchant->is_authorized == 5){
                // Nexio Pay.
                $merchant = 5;
            }elseif($invoiceData->merchant->is_authorized == 6){
                // PayPal.
                $merchant = 6;
            }elseif($invoiceData->merchant->is_authorized == 7){
                // Maverick Pay.
                $merchant = 7;
            }elseif($invoiceData->merchant->is_authorized == 9){
                // Maverick Pay.
                $merchant = 9;
            }
        }

        if($merchant == 1){

            try{

                dd($request>input());

                $get_client = DB::table('clients')->where('id', $invoiceData->client->id)->first();
                
                $get_client_merchants = DB::table('client_merchants')->where('merchant_key', 'stripe')->where('merchant_id', $invoiceData->merchant_id)->where('client_id', $invoiceData->client->id)->first();

                if($get_client_merchants == null){
                    $cust_id =  $stripe->customers->create([
                        "name" => $customerName,
                        "email" => $customerEmail,
                        "phone" => $customerPhone,
                        "address" => [
                            "line1" => $request->address,
                            "postal_code" => $request->zip,
                            "city" => $request->city,
                            "state" => $request->set_state,
                            "country" => $request->country,
                        ],
                    ]);
                    $customer = $cust_id->id;
                    DB::table('client_merchants')->insert(
                        [
                            'merchant_key' => 'stripe',
                            'merchant_id' => $invoiceData->merchant_id,
                            'client_id' => $invoiceData->client->id,
                            'token' => $customer,
                            'additional_info' => json_encode($cust_id)
                        ]
                    );

                    $return_payment_methods = $stripe->paymentMethods->attach(
                        $request->paymentMethods,
                        ['customer' => $customer]
                    );
                    $source_id = $request->paymentMethods;

                }else{
                    $customer = $get_client_merchants->token;
                }

                $service_name = '';
                $service_array = explode(',', $invoiceData->service);
                for($i = 0; $i < count($service_array); $i++){
                    $service = Service::find($service_array[$i]);
                    $service_name .= $service->name;
                    if(($i + 1) == count($service_array)){

                    }else{
                        $service_name .=  ', ';
                    }
                }
                $transaction_id = '';

                /* Creating Customer In Stripe */
                if($invoiceData->payment_type == 0 ){
                    $mainAmount =  $ServiceAmount * 100 ;

                    $payment_intent_id = $stripe->paymentIntents->create([
                        'amount' => $mainAmount, 
                        'currency' => $invoiceData->currency_show->short_name, 
                        'description' => 'Payment for Invoice - ' . $invoiceData->invoice_number,
                        'customer' => $customer,
                        'payment_method_types' => [ 
                            'card' 
                        ] 
                    ]);

                    $paymentIntent = \Stripe\PaymentIntent::capture($payment_intent_id->id, [ 
                        'customer' => $customer 
                    ]); 

                    $transaction_id = $paymentIntent->id;
                }else{
                    $mainAmount =  $ServiceAmount - 5 ;
                    $paymnetOne = $mainAmount * 100;
                        $charge =  \Stripe\Charge::create(array(
                            "amount" => $paymnetOne,
                            "currency" => $invoiceData->currency_show->short_name,
                            "customer" => $customer,
                            "receipt_email" => $request->user_email,
                            "description" => 'Payment for invoice',
                            "shipping" => [
                                "name" => $customerName,
                                "address" => [
                                    "line1" => $request->address,
                                    "postal_code" => $request->zip,
                                    "city" => $request->city,
                                    "state" => $request->set_state,
                                    "country" => $request->country,
                                ],
                            ]
                            // "description" => $result . ' ' . $merchant_name . ' - ' . $service_name . ' ( ' . $invoiceData->discription . ' )',
                        ));

                        $devCharge =  \Stripe\Charge::create(array(
                            "amount" => '250',
                            "currency" => $invoiceData->currency_show->short_name,
                            "customer" => $customer,
                            "receipt_email" => $request->user_email,
                            "description" => 'Payment for invoice',
                            "shipping" => [
                                "name" => $customerName,
                                "address" => [
                                    "line1" => $request->address,
                                    "postal_code" => $request->zip,
                                    "city" => $request->city,
                                    "state" => $request->set_state,
                                    "country" => $request->country,
                                ],
                            ]
                            // "description" => $result . ' ' . $merchant_name . ' - ' . $service_name . ' ( ' . $invoiceData->discription . ' )',
                        ));

                        $devCharge =  \Stripe\Charge::create(array(
                            "amount" => '250',
                            "currency" => $invoiceData->currency_show->short_name,
                            "customer" => $customer,
                            "receipt_email" => $request->user_email,
                            "description" => 'Payment for invoice',
                            "shipping" => [
                                "name" => $customerName,
                                "address" => [
                                    "line1" => $request->address,
                                    "postal_code" => $request->zip,
                                    "city" => $request->city,
                                    "state" => $request->set_state,
                                    "country" => $request->country,
                                ],
                            ]
                            // "description" => $result . ' ' . $merchant_name . ' - ' . $service_name . ' ( ' . $invoiceData->discription . ' )',
                        ));
                    $transaction_id = $charge->id;
                }
                $is_error = 0;
            }catch(Stripe\Exception\CardException $e){
                $e_object = $e;
                $error_message = $e->getError()->message;
                $is_error = 1;
            }catch (\Stripe\Exception\RateLimitException $e) {
                $e_object = $e;
                $error_message = $e->getMessage();
                $is_error = 1;
                // Too many requests made to the API too quickly
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $e_object = $e;
                $error_message = $e->getMessage();
                $is_error = 1;
                // Invalid parameters were supplied to Stripe's API
            } catch (\Stripe\Exception\AuthenticationException $e) {
                $e_object = $e;
                $error_message = $e->getMessage();
                $is_error = 1;
                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                $e_object = $e;
                $error_message = $e->getMessage();
                $is_error = 1;
                // Network communication with Stripe failed
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $e_object = $e;
                $error_message = $e->getMessage();
                $is_error = 1;
                // Display a very generic error to the user, and maybe send
                // yourself an email
            } catch (Exception $e) {
                $e_object = $e;
                $error_message = $e->getMessage();
                $is_error = 1;
                // Something else happened, completely unrelated to Stripe
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

            if($is_error == 1){
                $get_invoice = Invoice::findOrFail($request->invoice_id);
                $get_invoice->payment_status = '5';
                $get_invoice->invoice_date = Carbon::today()->toDateTimeString();
                $get_invoice->save();

                $invoice_logs = new InvoiceLogs();
                $invoice_logs->invoice_id = $get_invoice->id;
                $invoice_logs->return_response = $error_message;
                $invoice_logs->save();

                $managers = User::where('is_employee', 6)->whereHas('brands', function ($query) use ($get_invoice) {
                    return $query->where('brand_id', $get_invoice->brand);
                })->get();

                foreach($managers as $manager){
                    $pusher->trigger('private.' . $manager->id, 'send-event', ['link' => route('manager.link', ['id' => $invoiceData->id]),'title' => $invoiceData->name . ' Card Declined' ,'message' => $error_message, 'sender' => $customerName, 'image' => 'card_declined.png']);
                }

                return redirect()->back();
            }

            if($paymentIntent->status == "succeeded"){
                dd($paymentIntent);
                $invoice = array();
                $invoice['request'] = $request;
                $get_invoice = Invoice::findOrFail($request->invoice_id);
                if($get_invoice){
                    $get_invoice->transaction_id = $transaction_id;
                    $get_invoice->payment_status = '2';
                    $get_invoice->invoice_date = Carbon::today()->toDateTimeString();
                    $get_invoice->save();
                }
                $this->afterPaymentCheckForms($get_invoice);
                // $user = Client::where('email', $get_invoice->client->email)->first();
                // $user_client = User::where('email', $get_invoice->client->email)->first();
                // if($user_client != null){
                //     $service_array = explode(',', $get_invoice->service);
                //     for($i = 0; $i < count($service_array); $i++){
                //         $service = Service::find($service_array[$i]);
                //         if($service->form == 0){
                //             //No Form
                //             if($get_invoice->createform == 1){
                //                 $no_form = new NoForm();
                //                 $no_form->name = $get_invoice->custom_package;
                //                 $no_form->invoice_id = $get_invoice->id;

                //                 if($user_client != null){
                //                     $no_form->user_id = $user_client->id;
                //                 }
                //                 $no_form->client_id = $user->id;
                //                 $no_form->agent_id = $get_invoice->sales_agent_id;
                //                 $no_form->save();
                //             }
                //         }elseif($service->form == 1){
                //             // Logo Form
                //             if($get_invoice->createform == 1){
                //                 $logo_form = new LogoForm();
                //                 $logo_form->invoice_id = $get_invoice->id;
                //                 if($user_client != null){
                //                     $logo_form->user_id = $user_client->id;
                //                 }
                //                 $logo_form->client_id = $user->id;
                //                 $logo_form->agent_id = $get_invoice->sales_agent_id;
                //                 $logo_form->save();
                //             }
                //         }elseif($service->form == 2){
                //             // Website Form
                //             if($get_invoice->createform == 1){
                //                 $web_form = new WebForm();
                //                 $web_form->invoice_id = $get_invoice->id;
                //                 if($user_client != null){
                //                     $web_form->user_id = $user_client->id;
                //                 }
                //                 $web_form->client_id = $user->id;
                //                 $web_form->agent_id = $get_invoice->sales_agent_id;
                //                 $web_form->save();
                //             }
                //         }elseif($service->form == 3){
                //             // Smm Form
                //             if($get_invoice->createform == 1){
                //                 $smm_form = new SmmForm();
                //                 $smm_form->invoice_id = $get_invoice->id;
                //                 if($user_client != null){
                //                     $smm_form->user_id = $user_client->id;
                //                 }
                //                 $smm_form->client_id = $user->id;
                //                 $smm_form->agent_id = $get_invoice->sales_agent_id;
                //                 $smm_form->save();
                //             }
                //         }elseif($service->form == 4){
                //             // Content Writing Form
                //             if($get_invoice->createform == 1){
                //                 $content_writing_form = new ContentWritingForm();
                //                 $content_writing_form->invoice_id = $get_invoice->id;
                //                 if($user_client != null){
                //                     $content_writing_form->user_id = $user_client->id;
                //                 }
                //                 $content_writing_form->client_id = $user->id;
                //                 $content_writing_form->agent_id = $get_invoice->sales_agent_id;
                //                 $content_writing_form->save();
                //             }
                //         }elseif($service->form == 5){
                //             // Search Engine Optimization Form
                //             if($get_invoice->createform == 1){
                //                 $seo_form = new SeoForm();
                //                 $seo_form->invoice_id = $get_invoice->id;
                //                 if($user_client != null){
                //                     $seo_form->user_id = $user_client->id;
                //                 }
                //                 $seo_form->client_id = $user->id;
                //                 $seo_form->agent_id = $get_invoice->sales_agent_id;
                //                 $seo_form->save();
                //             }
                //         }
                //     }
                // }
                $details = [
                    'title' =>  'Invoice Number #' . $get_invoice->id . ' has been paid by '. $customerName . ' - ' . $customerEmail,
                    'body' => 'Please Login into your Dashboard to view it..'
                ];
                // \Mail::to($get_invoice->sale->email)->send(new \App\Mail\ClientNotifyMail($details));

                $messageData = [
                    'id' => $get_invoice->id,
                    'name' => $customerName ,
                    'email' => $customerEmail,
                    'text' => 'Invoice Number #' . $get_invoice->id . ' has been paid by '. $customerName . ' - ' . $customerEmail,
                    'details' => '',
                    'url' => '',
                ];
                if(($get_invoice->sale->is_employee != 2) && ($get_invoice->sale->is_employee != 6)){
                    $get_invoice->sale->notify(new PaymentNotification($messageData));
                }
                // Message Notification sending to Admin & Managers
                $managers = User::where('is_employee', 6)->whereHas('brands', function ($query) use ($get_invoice) {
                                return $query->where('brand_id', $get_invoice->brand);
                            })->get();

                foreach($managers as $manager){
                    Notification::send($manager, new PaymentNotification($messageData));
                    $pusher->trigger('private.' . $manager->id, 'send-event', ['link' => route('manager.link', ['id' => $get_invoice->id]), 'title' => $get_invoice->name . ' Card Accepted ' . $get_invoice->currency_show->sign . $get_invoice->amount,'message' => 'Invoice Number #' . $get_invoice->id . ' has been paid by '. $customerName . ' - ' . $customerEmail, 'image' => 'card_accepted.png']);
                }

                $adminusers = User::where('is_employee', 2)->get();
                foreach($adminusers as $adminuser){
                    Notification::send($adminuser, new PaymentNotification($messageData));
                }

                return redirect()->route('thankYou',($get_invoice->id));
            }else{
                $get_invoice = Invoice::findOrFail($request->invoice_id);
                return redirect()->route('failed',($get_invoice->id));
            }
        }elseif($merchant == 2){
            // authorized.net
            $input = $request->input();
            $get_expiration = explode('/', $input['expiration']);
            $expirationMonth = $get_expiration[0];
            $expirationYear = $get_expiration[1];
            $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
            $merchantAuthentication->setName($invoiceData->merchant->public_key);
            $merchantAuthentication->setTransactionKey($invoiceData->merchant->secret_key);
            $refId = 'ref' . time();
            $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);
            $creditCard = new AnetAPI\CreditCardType();
            $creditCard->setCardNumber($cardNumber);
            $creditCard->setExpirationDate('20'.$expirationYear . "-" .$expirationMonth);
            $creditCard->setCardCode($input['cvv']);
            $paymentOne = new AnetAPI\PaymentType();
            $paymentOne->setCreditCard($creditCard);

            $order = new AnetAPI\OrderType();
            $order->setInvoiceNumber($invoiceData->invoice_number);
            $order->setDescription($invoiceData->discription);

            // Set the customer's Bill To address
            $customerAddress = new AnetAPI\CustomerAddressType();
            $customerAddress->setFirstName($invoiceData->name);
            $customerAddress->setAddress($request->address);
            $customerAddress->setCity($request->city);
            $customerAddress->setState($request->set_state);
            $customerAddress->setZip($request->zip);
            $customerAddress->setEmail($request->user_email);
            $customerAddress->setCountry($request->country);
            $customerAddress->setPhoneNumber($request->user_phone);

            $customerData = new AnetAPI\CustomerDataType();
            $customerData->setType("individual");
            $customerData->setEmail($request->user_email);

            $transactionRequestType = new AnetAPI\TransactionRequestType();
            $transactionRequestType->setTransactionType("authCaptureTransaction");
            $transactionRequestType->setAmount($invoiceData->amount);
            $transactionRequestType->setOrder($order);
            $transactionRequestType->setPayment($paymentOne);
            $transactionRequestType->setBillTo($customerAddress);
            $transactionRequestType->setCustomer($customerData);
            $transactionRequestType->setCurrencyCode('USD');
            $transactionRequestType->setCustomerIP($request->ip());
            $requests = new AnetAPI\CreateTransactionRequest();
            $requests->setMerchantAuthentication($merchantAuthentication);
            $requests->setRefId($refId);
            $requests->setTransactionRequest($transactionRequestType);
            $controller = new AnetController\CreateTransactionController($requests);
            if($invoiceData->merchant->live_mode == 0){
                $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
            }else{
                $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
            }

            $invoice_logs = new InvoiceLogs();
            $invoice_logs->invoice_id = $invoiceData->id;
            $invoice_logs->return_response = json_encode($response);

            if ($response != null) {
                if ($response->getMessages()->getResultCode() == "Ok") {
                    $tresponse = $response->getTransactionResponse();
                    $invoice_logs->return_tresponse = json_encode($tresponse);

                    if ($tresponse != null && $tresponse->getMessages() != null) {
                        $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                        $msg_type = "success_msg";
                        $get_account_number = $tresponse->getAccountNumber();
                        $get_account_type = $tresponse->getAccountType();
                        // Payment Done By Authorized
                        $get_invoice = Invoice::findOrFail($invoiceData->id);
                        if($get_invoice){
                            $get_invoice->transaction_id = $tresponse->getTransId();
                            $get_invoice->payment_status = '2';
                            $get_invoice->invoice_date = Carbon::today()->toDateTimeString();
                            $get_invoice->return_response = $tresponse->getMessages()[0]->getDescription();
                            $get_invoice->return_tresponse = json_encode($tresponse);
                            $get_invoice->save();

                            $get_auth_cusomter = ClientAuthorizeCustomer::where('client_id', $get_invoice->client->id)->where('merchant_id', $get_invoice->merchant_id)->first();

                            if($get_auth_cusomter == null){
                                $customerProfile = new AnetAPI\CustomerProfileBaseType();
                                $customerProfile->setMerchantCustomerId('merchant_' . time());
                                $customerProfile->setEmail($get_invoice->client->email);
                                $customerProfile->setDescription('Generated By Sync Wave CRM');
                            }
                            //Customer Profile Authorized
                            $request_customer = new AnetAPI\CreateCustomerProfileFromTransactionRequest();
                            $request_customer->setMerchantAuthentication($merchantAuthentication);
                            $request_customer->setTransId($tresponse->getTransId());

                            if($get_auth_cusomter == null){
                                $request_customer->setCustomer($customerProfile);
                            }else{
                                $request_customer->setCustomerProfileId($get_auth_cusomter->authorize_customer_profile_id);
                            }
                            $controller_customer = new AnetController\CreateCustomerProfileController($request_customer);

                            if($get_invoice->merchant->live_mode == 0){
                                $return_response = $controller_customer->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
                            }else{
                                $return_response = $controller_customer->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
                            }

                            if (($return_response != null) && ($return_response->getMessages()->getResultCode() == "Ok") ) {
                                $get_payment_profile_id = $return_response->getCustomerPaymentProfileIdList();

                                if($get_auth_cusomter == null){
                                    $set_auth_customer = new ClientAuthorizeCustomer();
                                    $set_auth_customer->client_id = $get_invoice->client->id;
                                    $set_auth_customer->merchant_id = $get_invoice->merchant_id;
                                    $set_auth_customer->authorize_customer_profile_id = $return_response->getCustomerProfileId();
                                    $set_auth_customer->save();
                                    $set_auth_customer_id = $set_auth_customer->id;
                                }else{
                                    $set_auth_customer_id = $get_auth_cusomter->id;
                                }

                                $payment_profile_id = $get_payment_profile_id[0];
                                $get_payment = ClientAuthorize::where('client_id', $get_invoice->client->id)->where('payment_profile_id', $payment_profile_id)->where('client_authorize_customer_id', $set_auth_customer_id)->first();
                                if($get_payment == null){
                                    $add_payment = new ClientAuthorize();
                                    $add_payment->client_id = $get_invoice->client->id;
                                    $add_payment->client_authorize_customer_id = $set_auth_customer_id;
                                    $add_payment->payment_profile_id = $payment_profile_id;
                                    $add_payment->account_number = $get_account_number;
                                    $add_payment->account_type = $get_account_type;
                                    $add_payment->save();
                                }
                            }
                        }
                        $user = Client::where('email', $get_invoice->client->email)->first();
                        $user_client = User::where('email', $get_invoice->client->email)->first();
                        if($user_client != null){
                            $service_array = explode(',', $get_invoice->service);
                            for($i = 0; $i < count($service_array); $i++){
                                $service = Service::find($service_array[$i]);
                                if($service->form == 0){
                                    //No Form
                                    if($get_invoice->createform == 1){
                                        $no_form = new NoForm();
                                        $no_form->name = $get_invoice->custom_package;
                                        $no_form->invoice_id = $get_invoice->id;

                                        if($user_client != null){
                                            $no_form->user_id = $user_client->id;
                                        }
                                        $no_form->client_id = $user->id;
                                        $no_form->agent_id = $get_invoice->sales_agent_id;
                                        $no_form->save();
                                    }
                                }elseif($service->form == 1){
                                    // Logo Form
                                    if($get_invoice->createform == 1){
                                        $logo_form = new LogoForm();
                                        $logo_form->invoice_id = $get_invoice->id;
                                        if($user_client != null){
                                            $logo_form->user_id = $user_client->id;
                                        }
                                        $logo_form->client_id = $user->id;
                                        $logo_form->agent_id = $get_invoice->sales_agent_id;
                                        $logo_form->save();
                                    }
                                }elseif($service->form == 2){
                                    // Website Form
                                    if($get_invoice->createform == 1){
                                        $web_form = new WebForm();
                                        $web_form->invoice_id = $get_invoice->id;
                                        if($user_client != null){
                                            $web_form->user_id = $user_client->id;
                                        }
                                        $web_form->client_id = $user->id;
                                        $web_form->agent_id = $get_invoice->sales_agent_id;
                                        $web_form->save();
                                    }
                                }elseif($service->form == 3){
                                    // Smm Form
                                    if($get_invoice->createform == 1){
                                        $smm_form = new SmmForm();
                                        $smm_form->invoice_id = $get_invoice->id;
                                        if($user_client != null){
                                            $smm_form->user_id = $user_client->id;
                                        }
                                        $smm_form->client_id = $user->id;
                                        $smm_form->agent_id = $get_invoice->sales_agent_id;
                                        $smm_form->save();
                                    }
                                }elseif($service->form == 4){
                                    // Content Writing Form
                                    if($get_invoice->createform == 1){
                                        $content_writing_form = new ContentWritingForm();
                                        $content_writing_form->invoice_id = $get_invoice->id;
                                        if($user_client != null){
                                            $content_writing_form->user_id = $user_client->id;
                                        }
                                        $content_writing_form->client_id = $user->id;
                                        $content_writing_form->agent_id = $get_invoice->sales_agent_id;
                                        $content_writing_form->save();
                                    }
                                }elseif($service->form == 5){
                                    // Search Engine Optimization Form
                                    if($get_invoice->createform == 1){
                                        $seo_form = new SeoForm();
                                        $seo_form->invoice_id = $get_invoice->id;
                                        if($user_client != null){
                                            $seo_form->user_id = $user_client->id;
                                        }
                                        $seo_form->client_id = $user->id;
                                        $seo_form->agent_id = $get_invoice->sales_agent_id;
                                        $seo_form->save();
                                    }
                                }
                            }
                        }
                        $details = [
                            'title' =>  'Invoice Number #' . $get_invoice->id . ' has been paid by '. $customerName . ' - ' . $customerEmail,
                            'body' => 'Please Login into your Dashboard to view it..'
                        ];
                        // \Mail::to($get_invoice->sale->email)->send(new \App\Mail\ClientNotifyMail($details));

                        $messageData = [
                            'id' => $get_invoice->id,
                            'name' => $customerName . ' - ' . $customerEmail ,
                            'email' => $customerEmail,
                            'text' => 'Invoice Number #' . $get_invoice->invoice_number . ' Paid.',
                            'details' => '',
                            'url' => '',
                        ];
                        if(($get_invoice->sale->is_employee != 2) && ($get_invoice->sale->is_employee != 6)){
                            $get_invoice->sale->notify(new PaymentNotification($messageData));
                        }
                        // Message Notification sending to Admin & Managers
                        $managers = User::where('is_employee', 6)->whereHas('brands', function ($query) use ($get_invoice) {
                                        return $query->where('brand_id', $get_invoice->brand);
                                    })->get();

                        foreach($managers as $manager){
                            Notification::send($manager, new PaymentNotification($messageData));
                        }

                        $adminusers = User::where('is_employee', 2)->get();
                        foreach($adminusers as $adminuser){
                            Notification::send($adminuser, new PaymentNotification($messageData));
                        }
                        $invoice_logs->save();
                        return redirect()->route('thankYou',($get_invoice->id));
                    } else {
                        $message_text = 'There were some issue with the payment. Please try again later.';
                        $msg_type = "error_msg";

                        if ($tresponse->getErrors() != null) {
                            $get_invoice = Invoice::findOrFail($invoiceData->id);
                            $get_invoice->payment_status = '5';
                            $get_invoice->return_response = $tresponse->getErrors()[0]->getErrorText();
                            $get_invoice->return_tresponse = json_encode($tresponse);
                            $get_invoice->save();
                            $message_text = $tresponse->getErrors()[0]->getErrorText();
                            $msg_type = "error_msg";
                        }
                    }
                    // Or, print errors if the API request wasn't successful
                } else {
                    $message_text = 'There were some issue with the payment. Please try again later.';
                    $msg_type = "error_msg";

                    $tresponse = $response->getTransactionResponse();

                    if ($tresponse != null && $tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";
                    } else {
                        $message_text = $response->getMessages()->getMessage()[0]->getText();
                        $msg_type = "error_msg";
                    }
                    $get_invoice = Invoice::findOrFail($invoiceData->id);
                    $get_invoice->payment_status = '5';
                    $get_invoice->return_response = $message_text;
                    $get_invoice->return_tresponse = json_encode($tresponse);
                    $get_invoice->save();
                }
            } else {
                $get_invoice = Invoice::findOrFail($invoiceData->id);
                $get_invoice->payment_status = '5';
                $get_invoice->return_response = 'No response returned';
                $get_invoice->return_tresponse = json_encode($response);
                $get_invoice->save();
                $message_text = "No response returned";
                $msg_type = "error_msg";
            }
            $invoice_logs->save();
            return back()->with($msg_type, $message_text);
        }elseif($merchant == 3){
            $CONVERGE_MERCHANT_ID = $invoiceData->merchant->public_key;
            $CONVERGE_USER_ID = $invoiceData->merchant->secret_key;
            $CONVERGE_PIN = $invoiceData->merchant->login_id;

            Config::set('converge-api.merchant_id', $CONVERGE_MERCHANT_ID);
            Config::set('converge-api.user_id', $CONVERGE_USER_ID);
            Config::set('converge-api.pin', $CONVERGE_PIN);

            $converge = app(\Treestoneit\LaravelConvergeApi\Converge::class);

            $name = $request->user_name;
            $full_name = explode(' ', $name);
            $first_name = $full_name[0];
            $last_name = '';
            if(count($full_name) > 1){
                $last_name = $full_name[1];
            }
            $card_number = str_replace(' ', '', $request->cardNumber);
            $exp_date = str_replace('/', '', $request->expiration);
            $cvv = $request->cvv;
            $address = $request->address;
            $zip = $request->zip;
            $amount = $invoiceData->amount;

            $payment_type = $invoiceData->payment_type;
            if($payment_type == 0){
                // $createSale = [
                //     'ssl_card_number' => $card_number,
                //     'ssl_exp_date' => $exp_date,
                //     'ssl_amount' => $amount,
                //     'ssl_card_short_description' => 'MC',
                //     'ssl_customer_code' => '',
                //     'ssl_salestax' => '',
                //     'ssl_invoice_number' => '',
                //     'ssl_description' => '',
                //     'ssl_get_token' => 'Y',
                //     'ssl_token_response' => '',
                //     'ssl_token' => '',
                //     'ssl_departure_date' => '',
                //     'ssl_completion_date' => '',
                //     'ssl_merchant_txn_id' => '',
                //     'ssl_result' => 1,
                //     'ssl_result_message' => 'INVALID CARD',
                //     'ssl_transaction_type' => 'SALE',
                //     'ssl_txn_id' => '120124C1A-6BD4E746-5385-48A6-BFA1-A8D8288A6B01',
                //     'ssl_approval_code' => '',
                //     'ssl_cvv2_response' => 'P',
                //     'ssl_avs_response' => 'R',
                //     'ssl_account_balance' => '0.00',
                //     'ssl_txn_time' => '01/12/2024 01:06:15 PM',
                //     'ssl_card_type' => 'CREDITCARD',
                //     'ssl_partner_app_id' => '01',
                //     'ssl_response_advicecode' => '',
                //     'success' => true,
                // ];

                $createSale = [
                    'ssl_add_token_response' => 'Card Added',
                    'ssl_card_number' => $card_number,
                    'ssl_exp_date' => $exp_date,
                    'ssl_amount' => $amount,
                    'ssl_card_short_description' => 'MC',
                    'ssl_customer_code' => '',
                    'ssl_salestax' => '',
                    'ssl_invoice_number' => '',
                    'ssl_description' => '',
                    'ssl_get_token' => 'Y',
                    'ssl_token_response' => 'SUCCESS',
                    'ssl_token' => '5911442605961459',
                    'ssl_departure_date' => '',
                    'ssl_completion_date' => '',
                    'ssl_merchant_txn_id' => '',
                    'ssl_result' => 0,
                    'ssl_result_message' => 'APPROVAL',
                    'ssl_transaction_type' => 'SALE',
                    'ssl_txn_id' => '120124O2D-139DB725-C9A0-4C49-8C38-80BA00A6D621',
                    'ssl_approval_code' => '161424',
                    'ssl_cvv2_response' => 'M',
                    'ssl_avs_response' => 'Y',
                    'ssl_account_balance' => '0.00',
                    'ssl_txn_time' => '01/12/2024 01:06:15 PM',
                    'ssl_card_type' => 'CREDITCARD',
                    'ssl_partner_app_id' => '01',
                    'success' => true,
                ];

                // $createSale = $converge->sale([
                //     'ssl_first_name' => $first_name,
                //     'ssl_last_name' => $last_name,
                //     'ssl_card_number' => $card_number,
                //     'ssl_exp_date' => $exp_date,
                //     'ssl_cvv2cvc2' => $cvv,
                //     'ssl_amount' => $amount,
                //     'ssl_add_token' => 'Y',
                //     'ssl_avs_address' => $address,
                //     'ssl_avs_zip' => $zip
                // ]);

                $invoice_logs = new InvoiceLogs();
                $invoice_logs->invoice_id = $invoiceData->id;
                $invoice_logs->return_response = json_encode($createSale);
                $invoice_logs->save();

            }else{
                $first_amount = $amount - 2;
                // $createSale = $converge->sale([
                //     'ssl_first_name' => $first_name,
                //     'ssl_last_name' => $last_name,
                //     'ssl_card_number' => $card_number,
                //     'ssl_exp_date' => $exp_date,
                //     'ssl_cvv2cvc2' => $cvv,
                //     'ssl_amount' => $first_amount,
                //     'ssl_add_token' => 'Y',
                //     'ssl_avs_address' => $address,
                //     'ssl_avs_zip' => $zip
                // ]);

                // $invoice_logs = new InvoiceLogs();
                // $invoice_logs->invoice_id = $invoiceData->id;
                // $invoice_logs->return_response = json_encode($createSale);
                // $invoice_logs->save();

                // if($createSale['success'] == true){
                //     if($createSale['ssl_result'] == 0){
                        // $createSale_1 = $converge->sale([
                        //     'ssl_first_name' => $first_name,
                        //     'ssl_last_name' => $last_name,
                        //     'ssl_card_number' => $card_number,
                        //     'ssl_exp_date' => $exp_date,
                        //     'ssl_cvv2cvc2' => $cvv,
                        //     'ssl_amount' => 1.00,
                        //     'ssl_add_token' => 'Y',
                        //     'ssl_avs_address' => $address,
                        //     'ssl_avs_zip' => $zip
                        // ]);
                        // $invoice_logs = new InvoiceLogs();
                        // $invoice_logs->invoice_id = $invoiceData->id;
                        // $invoice_logs->return_response = json_encode($createSale_1);
                        // $invoice_logs->save();
                        // $createSale_2 = $converge->sale([
                        //     'ssl_first_name' => $first_name,
                        //     'ssl_last_name' => $last_name,
                        //     'ssl_card_number' => $card_number,
                        //     'ssl_exp_date' => $exp_date,
                        //     'ssl_cvv2cvc2' => $cvv,
                        //     'ssl_amount' => 1.00,
                        //     'ssl_add_token' => 'Y',
                        //     'ssl_avs_address' => $address,
                        //     'ssl_avs_zip' => $zip
                        // ]);
                        // $invoice_logs = new InvoiceLogs();
                        // $invoice_logs->invoice_id = $invoiceData->id;
                        // $invoice_logs->return_response = json_encode($createSale_2);
                        // $invoice_logs->save();
                //     }
                // }
            }

            if($createSale['success'] == true){
                if($createSale['ssl_result'] == 0){
                    $get_invoice = Invoice::findOrFail($invoiceData->id);
                    $get_invoice->payment_status = '2';
                    $get_invoice->invoice_date = Carbon::today()->toDateTimeString();
                    $get_invoice->return_response = json_encode($createSale);
                    $get_invoice->transaction_id = $createSale['ssl_txn_id'];
                    $get_invoice->save();

                    $custom_card = ['ssl_first_name' =>  $first_name, 'ssl_last_name' => $last_name, 'ssl_card_number' => $card_number, 'ssl_exp_date' => $exp_date, 'ssl_cvv2cvc2' => $cvv];

                    $check_client_authorize_customer = ClientAuthorizeCustomer::where('merchant_id', $get_invoice->merchant_id)->where('client_id', $get_invoice->client->id)->get();
                    $check_card = 0;
                    foreach($check_client_authorize_customer as $key => $value){
                        $get_authorize_customer_profile = Crypt::decrypt($value->authorize_customer_profile_id);
                        $data_authorize_customer_profile = json_decode($get_authorize_customer_profile);
                        if($data_authorize_customer_profile->ssl_card_number == $card_number){
                            $check_card = 1;
                            break;
                        }
                    }

                    if($check_card == 0){
                        $set_auth_customer = new ClientAuthorizeCustomer();
                        $set_auth_customer->client_id = $get_invoice->client->id;
                        $set_auth_customer->merchant_id = $get_invoice->merchant_id;
                        $set_auth_customer->authorize_customer_profile_id = Crypt::encrypt(json_encode($custom_card));
                        $set_auth_customer->save();
                    }
                    $this->afterPaymentCheckForms($get_invoice);
                    return redirect()->route('thankYou',($get_invoice->id));
                }else{
                    $get_invoice = Invoice::findOrFail($invoiceData->id);
                    $get_invoice->payment_status = '5';
                    $get_invoice->invoice_date = Carbon::today()->toDateTimeString();
                    $get_invoice->return_response = json_encode($createSale);
                    $get_invoice->transaction_id = $createSale['ssl_txn_id'];
                    $get_invoice->save();
                    $message_text = 'PAYMENT DECLINED - ' . $createSale['ssl_result_message'];
                    $msg_type = "error_msg";
                }
            }else{
                $message_text = $createSale['errorName'];
                $msg_type = "error_msg";
            }
            return back()->with($msg_type, $message_text);
        }elseif($merchant == 4){
            $ccnumber = str_replace(' ', '', $request->ccnumber);
            $en_ccnumber = Crypt::encryptString($ccnumber);

            $ccexp = str_replace('/', '', $request->ccexp);
            $en_ccexp = Crypt::encryptString($ccexp);

            $cvv = $request->cvv;
            $en_cvv = Crypt::encryptString($cvv);

            $name = $request->user_name;
            $full_name = explode(' ', $name);
            $first_name = $full_name[0];
            $last_name = '';
            if(count($full_name) > 1){
                $last_name = $full_name[1];
            }
            $amount = $invoiceData->amount;
            $address = $request->address;
            $email = $request->user_email;
            $zip = $request->zip;

            $url = 'https://thriftypayments.transactiongateway.com/api/transact.php';
            $vars = "security_key=".$invoiceData->merchant->secret_key
            . "&type=sale"
            . "&amount=". $amount
            . "&first_name=". $first_name
            . "&last_name=". $last_name
            . "&email=". $email
            . "&address1=" . $address
            . "&zip=" . $zip
            . "&ccnumber=". $ccnumber
            . "&ccexp=" . $ccexp
            . "&cvv=" . $cvv;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $server_output = curl_exec($ch);
            curl_close($ch);
            $output = $server_output;
            $output_data = explode('&', $output);
            $array = [];
            foreach($output_data as $key => $value){
                $data_output = explode('=', $value);
                $array[$data_output[0]] = $data_output[1];
            }
            $update_payment = Invoice::find($request->invoice_id);
            if($array['response'] == 1){
                $update_payment->payment_status = 2;
            }else{
                $update_payment->payment_status = 5;
            }
            $update_payment->invoice_date = Carbon::today()->toDateTimeString();
            $update_payment->return_response = $array['responsetext'];
            $update_payment->return_tresponse = json_encode($array);
            $update_payment->transaction_id = $array['transactionid'];
            $update_payment->save();

            if($array['response'] == 1){
                $this->afterPaymentCheckForms($update_payment);
                $this->storeNMICardDetails($update_payment->client->id, $update_payment->merchant->id, $en_ccnumber, $en_ccexp, $en_cvv);
                return redirect()->route('thankYou',($update_payment->id));
            }else{
                $message_text = $array['responsetext'];
                $msg_type = "error_msg";
                return back()->with($msg_type, $message_text);
            }
        }elseif($merchant == 5){
            $ccnumber = str_replace(' ', '', $request->ccnumber);
            $en_ccnumber = Crypt::encryptString($ccnumber);

            $ccexp = str_replace('/', '', $request->ccexp);
            $en_ccexp = Crypt::encryptString($ccexp);

            $cvv = $request->cvv;
            $en_cvv = Crypt::encryptString($cvv);

            $name = $request->user_name;
            $full_name = explode(' ', $name);
            $first_name = $full_name[0];
            $last_name = '';
            if(count($full_name) > 1){
                $last_name = $full_name[1];
            }
            $amount = $invoiceData->amount;
            $address = $request->address;
            $email = $request->user_email;
            $zip = $request->zip;

            $url = 'https://secure.expigate.com/api/transact.php';
            $vars = "security_key=".$invoiceData->merchant->secret_key
            . "&type=sale"
            . "&amount=". $amount
            . "&first_name=". $first_name
            . "&last_name=". $last_name
            . "&email=". $email
            . "&address1=" . $address
            . "&zip=" . $zip
            . "&ccnumber=". $ccnumber
            . "&ccexp=" . $ccexp
            . "&cvv=" . $cvv;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $server_output = curl_exec($ch);
            curl_close($ch);
            $output = $server_output;
            $output_data = explode('&', $output);
            $array = [];
            foreach($output_data as $key => $value){
                $data_output = explode('=', $value);
                $array[$data_output[0]] = $data_output[1];
            }
            $update_payment = Invoice::find($request->invoice_id);
            if($array['response'] == 1){
                $update_payment->payment_status = 2;
            }else{
                $update_payment->payment_status = 5;
            }
            $update_payment->invoice_date = Carbon::today()->toDateTimeString();
            $update_payment->return_response = $array['responsetext'];
            $update_payment->return_tresponse = json_encode($array);
            $update_payment->transaction_id = $array['transactionid'];
            $update_payment->save();

            if($array['response'] == 1){
                $this->afterPaymentCheckForms($update_payment);
                $this->storeNMICardDetails($update_payment->client->id, $update_payment->merchant->id, $en_ccnumber, $en_ccexp, $en_cvv);
                return redirect()->route('thankYou',($update_payment->id));
            }else{
                $message_text = $array['responsetext'];
                $msg_type = "error_msg";
                return back()->with($msg_type, $message_text);
            }
        }elseif($merchant == 6){
            $update_payment = Invoice::find($request->invoice_id);
            $update_payment->payment_status = $request->payment_status;
            $update_payment->invoice_date = Carbon::today()->toDateTimeString();
            $update_payment->transaction_id = $request->transaction_id;
            $update_payment->return_response = $request->return_response;
            $update_payment->return_tresponse = $request->return_tresponse;
            $update_payment->save();
            if($request->payment_status == 2){
                $this->afterPaymentCheckForms($update_payment);
                return redirect()->route('thankYou',($update_payment->id));
            }else{
                return back();
            }
        }elseif($merchant == 7){
            $ccnumber = str_replace(' ', '', $request->ccnumber);
            $en_ccnumber = Crypt::encryptString($ccnumber);

            $ccexp = str_replace('/', '', $request->ccexp);
            $en_ccexp = Crypt::encryptString($ccexp);
            
            $cvv = $request->cvv;
            $en_cvv = Crypt::encryptString($cvv);
            
            $name = $request->user_name;
            $full_name = explode(' ', $name);
            $first_name = $full_name[0];
            $last_name = '';
            if(count($full_name) > 1){
                $last_name = $full_name[1];
            }
            $amount = $invoiceData->amount;
            $address = $request->address;
            $email = $request->user_email;
            $zip = $request->zip;

            $url = 'https://groovepay.transactiongateway.com/api/transact.php';
            $vars = "security_key=".$invoiceData->merchant->secret_key
            . "&type=sale"
            . "&amount=". $amount
            . "&first_name=". $first_name
            . "&last_name=". $last_name
            . "&email=". $email
            . "&address1=" . $address
            . "&zip=" . $zip
            . "&ccnumber=". $ccnumber
            . "&ccexp=" . $ccexp
            . "&cvv=" . $cvv;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $server_output = curl_exec($ch);
            curl_close($ch);
            $output = $server_output;
            $output_data = explode('&', $output);
            $array = [];
            foreach($output_data as $key => $value){
                $data_output = explode('=', $value);
                $array[$data_output[0]] = $data_output[1];
            }
            $update_payment = Invoice::find($request->invoice_id);
            if($array['response'] == 1){
                $update_payment->payment_status = 2;
            }else{
                $update_payment->payment_status = 5;
            }
            $update_payment->invoice_date = Carbon::today()->toDateTimeString();
            $update_payment->return_response = $array['responsetext'];
            $update_payment->return_tresponse = json_encode($array);
            $update_payment->transaction_id = $array['transactionid'];
            $update_payment->save();

            if($array['response'] == 1){
                $this->afterPaymentCheckForms($update_payment);
                $this->storeNMICardDetails($update_payment->client->id, $update_payment->merchant->id, $en_ccnumber, $en_ccexp, $en_cvv);
                return redirect()->route('thankYou',($update_payment->id));
            }else{
                $message_text = $array['responsetext'];
                $msg_type = "error_msg";
                return back()->with($msg_type, $message_text);
            }
        }elseif($merchant == 9){
            $ccnumber = str_replace(' ', '', $request->ccnumber);
            $en_ccnumber = Crypt::encryptString($ccnumber);

            $ccexp = str_replace('/', '', $request->ccexp);
            $en_ccexp = Crypt::encryptString($ccexp);
            
            $cvv = $request->cvv;
            $en_cvv = Crypt::encryptString($cvv);
            
            $name = $request->user_name;
            $full_name = explode(' ', $name);
            $first_name = $full_name[0];
            $last_name = '';
            if(count($full_name) > 1){
                $last_name = $full_name[1];
            }
            $amount = $invoiceData->amount;
            $address = $request->address;
            $email = $request->user_email;
            $zip = $request->zip;

            $url = 'https://secure.nmi.com/api/transact.php';
            $vars = "security_key=".$invoiceData->merchant->secret_key
            . "&type=sale"
            . "&amount=". $amount
            . "&first_name=". $first_name
            . "&last_name=". $last_name
            . "&email=". $email
            . "&address1=" . $address
            . "&zip=" . $zip
            . "&ccnumber=". $ccnumber
            . "&ccexp=" . $ccexp
            . "&cvv=" . $cvv;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $server_output = curl_exec($ch);
            curl_close($ch);
            $output = $server_output;
            $output_data = explode('&', $output);
            $array = [];
            foreach($output_data as $key => $value){
                $data_output = explode('=', $value);
                $array[$data_output[0]] = $data_output[1];
            }
            $update_payment = Invoice::find($request->invoice_id);
            if($array['response'] == 1){
                $update_payment->payment_status = 2;
            }else{
                $update_payment->payment_status = 5;
            }
            $update_payment->invoice_date = Carbon::today()->toDateTimeString();
            $update_payment->return_response = $array['responsetext'];
            $update_payment->return_tresponse = json_encode($array);
            $update_payment->transaction_id = $array['transactionid'];
            $update_payment->save();

            if($array['response'] == 1){
                $this->afterPaymentCheckForms($update_payment);
                $this->storeNMICardDetails($update_payment->client->id, $update_payment->merchant->id, $en_ccnumber, $en_ccexp, $en_cvv);
                return redirect()->route('thankYou',($update_payment->id));
            }else{
                $message_text = $array['responsetext'];
                $msg_type = "error_msg";
                return back()->with($msg_type, $message_text);
            }
        }
    }

    public function storeNMICardDetails($client_id, $merchant_id, $ccnumber, $ccexp, $cvv){
        $data = new ClientAuthorizeCustomer();
        $data->client_id = $client_id;
        $data->merchant_id = $merchant_id;
        $data->authorize_customer_profile_id = 'ccnumber='.$ccnumber.'&ccexp='.$ccexp.'&cvv='.$cvv;
        $data->save();
    }

    public function afterPaymentCheckForms($get_invoice){
        $get_invoice = Invoice::find($get_invoice);
        $user = Client::where('email', $get_invoice->client->email)->first();
        $user_client = User::where('email', $get_invoice->client->email)->first();

        $service_array = explode(',', $get_invoice->service);
        for($i = 0; $i < count($service_array); $i++){
            $service = Service::find($service_array[$i]);
            if($service->form == 0){
                //No Form
                if($get_invoice->createform == 1){
                    $no_form = new NoForm();
                    $no_form->name = $get_invoice->custom_package;
                    $no_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $no_form->user_id = $user_client->id;
                    }
                    $no_form->client_id = $user->id;
                    $no_form->agent_id = $get_invoice->sales_agent_id;
                    $no_form->save();
                }
            }elseif($service->form == 1){
                // Logo Form
                if($get_invoice->createform == 1){
                    $logo_form = new LogoForm();
                    $logo_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $logo_form->user_id = $user_client->id;
                    }
                    $logo_form->client_id = $user->id;
                    $logo_form->agent_id = $get_invoice->sales_agent_id;
                    $logo_form->save();
                }
            }elseif($service->form == 2){
                // Website Form
                if($get_invoice->createform == 1){
                    $web_form = new WebForm();
                    $web_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $web_form->user_id = $user_client->id;
                    }
                    $web_form->client_id = $user->id;
                    $web_form->agent_id = $get_invoice->sales_agent_id;
                    $web_form->save();
                }
            }elseif($service->form == 3){
                // Smm Form
                if($get_invoice->createform == 1){
                    $smm_form = new SmmForm();
                    $smm_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $smm_form->user_id = $user_client->id;
                    }
                    $smm_form->client_id = $user->id;
                    $smm_form->agent_id = $get_invoice->sales_agent_id;
                    $smm_form->save();
                }
            }elseif($service->form == 4){
                // Content Writing Form
                if($get_invoice->createform == 1){
                    $content_writing_form = new ContentWritingForm();
                    $content_writing_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $content_writing_form->user_id = $user_client->id;
                    }
                    $content_writing_form->client_id = $user->id;
                    $content_writing_form->agent_id = $get_invoice->sales_agent_id;
                    $content_writing_form->save();
                }
            }elseif($service->form == 5){
                // Search Engine Optimization Form
                if($get_invoice->createform == 1){
                    $seo_form = new SeoForm();
                    $seo_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $seo_form->user_id = $user_client->id;
                    }
                    $seo_form->client_id = $user->id;
                    $seo_form->agent_id = $get_invoice->sales_agent_id;
                    $seo_form->save();
                }
            }elseif($service->form == 6){
                // Book Formatting & Publishing
                if($get_invoice->createform == 1){
                    $book_formatting_form = new BookFormatting();
                    $book_formatting_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $book_formatting_form->user_id = $user_client->id;
                    }
                    $book_formatting_form->client_id = $user->id;
                    $book_formatting_form->agent_id = $get_invoice->sales_agent_id;
                    $book_formatting_form->save();
                }
            }elseif($service->form == 7){
                // Book Formatting & Publishing
                if($get_invoice->createform == 1){
                    $book_writing_form = new BookWriting();
                    $book_writing_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $book_writing_form->user_id = $user_client->id;
                    }
                    $book_writing_form->client_id = $user->id;
                    $book_writing_form->agent_id = $get_invoice->sales_agent_id;
                    $book_writing_form->save();
                }
            }elseif($service->form == 8){
                // Author Website
                if($get_invoice->createform == 1){
                    $author_website_form = new AuthorWebsite();
                    $author_website_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $author_website_form->user_id = $user_client->id;
                    }
                    $author_website_form->client_id = $user->id;
                    $author_website_form->agent_id = $get_invoice->sales_agent_id;
                    $author_website_form->save();
                }
            }elseif($service->form == 9){
                // Proofreading
                if($get_invoice->createform == 1){
                    $proofreading_form = new Proofreading();
                    $proofreading_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $proofreading_form->user_id = $user_client->id;
                    }
                    $proofreading_form->client_id = $user->id;
                    $proofreading_form->agent_id = $get_invoice->sales_agent_id;
                    $proofreading_form->save();
                }
            }elseif($service->form == 10){
                // Book Cover
                if($get_invoice->createform == 1){
                    $bookcover_form = new BookCover();
                    $bookcover_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $bookcover_form->user_id = $user_client->id;
                    }
                    $bookcover_form->client_id = $user->id;
                    $bookcover_form->agent_id = $get_invoice->sales_agent_id;
                    $bookcover_form->save();
                }
            }elseif($service->form == 11){
                // Book Cover
                if($get_invoice->createform == 1){
                    $bookmarketing_form = new BookMarketing();
                    $bookmarketing_form->invoice_id = $get_invoice->id;
                    if($user_client != null){
                        $bookmarketing_form->user_id = $user_client->id;
                    }
                    $bookmarketing_form->client_id = $user->id;
                    $bookmarketing_form->agent_id = $get_invoice->sales_agent_id;
                    $bookmarketing_form->save();
                }
            }
        }

        $customerName = $get_invoice->client->name . ' ' . $get_invoice->client->last_name;
        $customerEmail = $get_invoice->client->email;
        $details = [
            'title' =>  'Invoice Number #' . $get_invoice->id . ' has been paid by '. $customerName . ' - ' . $customerEmail,
            'body' => 'Please Login into your Dashboard to view it..'
        ];
        // \Mail::to($get_invoice->sale->email)->send(new \App\Mail\ClientNotifyMail($details));

        $messageData = [
            'id' => $get_invoice->id,
            'name' => $customerName . ' - ' . $customerEmail ,
            'email' => $customerEmail,
            'text' => 'Invoice Number #' . $get_invoice->invoice_number . ' Paid.',
            'details' => '',
            'url' => '',
        ];
        if(($get_invoice->sale->is_employee != 2) && ($get_invoice->sale->is_employee != 6)){
            $get_invoice->sale->notify(new PaymentNotification($messageData));
        }
        // Message Notification sending to Admin & Managers
        $managers = User::where('is_employee', 6)->whereHas('brands', function ($query) use ($get_invoice) {
                        return $query->where('brand_id', $get_invoice->brand);
                    })->get();

        foreach($managers as $manager){
            Notification::send($manager, new PaymentNotification($messageData));
        }

        $adminusers = User::where('is_employee', 2)->get();
        foreach($adminusers as $adminuser){
            Notification::send($adminuser, new PaymentNotification($messageData));
        }
    }

    public function thankYou($id)
    {
		$id = Crypt::encrypt($id);
		$invoiceId = Crypt::decrypt($id);
		$_getInvoiceData = Invoice::findOrFail($invoiceId);
		$_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        return view('invoice.thank-you')->with(compact('_getInvoiceData'))->with(compact('id','_getInvoiceData','_getBrand'));
    }

    public function failed($id)
    {
		$id = Crypt::encrypt($id);
		$invoiceId = Crypt::decrypt($id);
		$_getInvoiceData = Invoice::findOrFail($invoiceId);
		$_getBrand = Brand::where('brand_name',$_getInvoiceData->brand)->first();
        return view('invoice.failed')->with(compact('_getInvoiceData'))->with(compact('id','_getInvoiceData','_getBrand'));
    }

    public function managerStore(Request $request)
    {
        $get_brand = Brand::find($request->brand);
        $get_short_brand = implode('', array_map(function($v) { return $v[0]; }, explode(' ', $get_brand->name)));
        $invoice_number = date('ymd').$get_short_brand.$request->amount;
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'brand' => 'required',
            'service' => 'required',
            'package' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'merchant' => 'required'
        ]);
        $latest = Invoice::latest()->first();
        if (! $latest) {
            $numPadded = sprintf("%04d", 1);
            $nextInvoiceNumber = $invoice_number . $numPadded;
        }else{
            $numPadded = sprintf("%04d", $latest->id + 1);
            $nextInvoiceNumber = $invoice_number . $numPadded;
        }
        $contact = $request->contact;
        if($contact == null){
            $contact = '#';
        }
		$invoice = new Invoice;
        $invoice->createform = $request->createform;
        $invoice->name = $request->name;
        $invoice->email = $request->email;
        $invoice->contact = $contact;
        $invoice->brand = $request->brand;
        $invoice->package = $request->package;
        $invoice->currency = $request->currency;
        $invoice->client_id = $request->client_id;
        $invoice->invoice_number = $nextInvoiceNumber;
        $invoice->sales_agent_id = Auth()->user()->id;
        $invoice->discription = $request->discription;
        $invoice->amount = $request->amount;
        $invoice->payment_status = '1';
        $invoice->custom_package = $request->custom_package;
        $invoice->payment_type = $request->payment_type;
		$service = implode(",",$request->service);
		$invoice->service = $service;
        $invoice->merchant_id = $request->merchant;
        $invoice->invoice_id = bin2hex(random_bytes(24));
        $invoice->save();
		$id = $invoice->id;

        $id = Crypt::encrypt($id);
		$invoiceId = Crypt::decrypt($id);
		$_getInvoiceData = Invoice::findOrFail($invoiceId);
		$_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        $package_name = '';
        if($_getInvoiceData->package == 0){
            $package_name = strip_tags($_getInvoiceData->custom_package);
        }
        $sendemail = $request->sendemail;
        if($sendemail == 1){
            // Send Invoice Link To Email
            $details = [
                'brand_name' => $_getBrand->name,
                'brand_logo' => $_getBrand->logo,
                'brand_phone' => $_getBrand->phone,
                'brand_email' => $_getBrand->email,
                'brand_address' => $_getBrand->address,
                'invoice_number' => $_getInvoiceData->invoice_number,
                'currency_sign' => $_getInvoiceData->currency_show->sign,
                'amount' => $_getInvoiceData->amount,
                'name' => $_getInvoiceData->name,
                'email' => $_getInvoiceData->email,
                'contact' => $_getInvoiceData->contact,
                'date' => $_getInvoiceData->created_at->format('jS M, Y'),
                'link' => route('client.paynow', $id),
                'package_name' => $package_name,
                'discription' => $_getInvoiceData->discription
            ];
            // \Mail::to($_getInvoiceData->email)->send(new \App\Mail\InoviceMail($details));
        }
		return redirect()->route('manager.link',($invoice->id));
    }

    public function saleStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'brand' => 'required',
            'service' => 'required',
            'package' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'merchant' => 'required'
        ]);
        $latest = Invoice::latest()->first();
        if (! $latest) {
            $nextInvoiceNumber = date('Y').'-1';
        }else{
            $expNum = explode('-', $latest->invoice_number);
            $expIncrement = (int)$expNum[1] + 1;
            $nextInvoiceNumber = $expNum[0].'-'.$expIncrement;
        }
        $contact = $request->contact;
        if($contact == null){
            $contact = '#';
        }
		$invoice = new Invoice;
        if($request->createform != null){
            $invoice->createform = $request->createform;
        }else{
            $invoice->createform = 1;
        }
        $invoice->name = $request->name;
        $invoice->email = $request->email;
        $invoice->contact = $contact;
        $invoice->brand = $request->brand;
        $invoice->package = $request->package;
        $invoice->currency = $request->currency;
        $invoice->client_id = $request->client_id;
        $invoice->invoice_number = $nextInvoiceNumber;
        $invoice->sales_agent_id = Auth()->user()->id;
        $invoice->discription = $request->discription;
        $invoice->amount = $request->amount;
        $invoice->payment_status = '1';
        $invoice->custom_package = $request->custom_package;
        $invoice->payment_type = $request->payment_type;
		$service = implode(",",$request->service);
		$invoice->service = $service;
		$invoice->merchant_id = $request->merchant;

        $invoice->save();
		$id = $invoice->id;

        $id = Crypt::encrypt($id);
		$invoiceId = Crypt::decrypt($id);
		$_getInvoiceData = Invoice::findOrFail($invoiceId);
		$_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        $package_name = '';
        if($_getInvoiceData->package == 0){
            $package_name = strip_tags($_getInvoiceData->custom_package);
        }
        $sendemail = $request->sendemail;
        if($sendemail == 1){
            // Send Invoice Link To Email
            $details = [
                'brand_name' => $_getBrand->name,
                'brand_logo' => $_getBrand->logo,
                'brand_phone' => $_getBrand->phone,
                'brand_email' => $_getBrand->email,
                'brand_address' => $_getBrand->address,
                'invoice_number' => $_getInvoiceData->invoice_number,
                'currency_sign' => $_getInvoiceData->currency_show->sign,
                'amount' => $_getInvoiceData->amount,
                'name' => $_getInvoiceData->name,
                'email' => $_getInvoiceData->email,
                'contact' => $_getInvoiceData->contact,
                'date' => $_getInvoiceData->created_at->format('jS M, Y'),
                'link' => route('client.paynow', $id),
                'package_name' => $package_name,
                'discription' => $_getInvoiceData->discription
            ];
            // \Mail::to($_getInvoiceData->email)->send(new \App\Mail\InoviceMail($details));
        }
		return redirect()->route('sale.link',($invoice->id));
    }

    public function getInvoiceBySaleManager(Request $request){
        $data = new Invoice;
        $data = $data->whereIn('brand', Auth()->user()->brand_list());
        $data = $data->orderBy('id', 'desc');
        $perPage = 10;
        if($request->package != ''){
            $data = $data->where('custom_package', 'LIKE', "%$request->package%");
        }
        if($request->invoice != ''){
            $data = $data->where('invoice_number', 'LIKE', "%$request->invoice%");
        }
        if($request->user != ''){
            $data = $data->where('name', 'LIKE', "%$request->user%")->orWhere('email', 'LIKE', "%$request->user%");
        }
        if($request->status != 0){
            $data = $data->where('payment_status', $request->status);
        }
        if($request->brand != ''){
            $data = $data->where('brand', $request->brand);
        }
        $data = $data->paginate(10);
        return view('manager.invoice.index', compact('data'));
    }

    public function getInvoiceByUserId (Request $request){
        $data = new Invoice;
        $data = $data->where('sales_agent_id', Auth()->user()->id);
        $data = $data->orderBy('id', 'desc');
        $perPage = 10;
        if($request->package != ''){
            $data = $data->where('custom_package', 'LIKE', "%$request->package%");
        }
        if($request->invoice != ''){
            $data = $data->where('invoice_number', 'LIKE', "%$request->invoice%");
        }
        if($request->user != 0){
            $data = $data->where('name', 'LIKE', "%$request->user%");
            $data = $data->orWhere('email', 'LIKE', "%$request->user%");
        }
        if($request->status != 0){
            $data = $data->where('payment_status', $request->status);
        }
        $data = $data->paginate(10);
        return view('sale.invoice.index', compact('data'));
    }

    public function getSingleInvoice($id){
        $data = Invoice::where('id', $id)->where('sales_agent_id', Auth::user()->id)->first();
        if($data == null){
            return redirect()->back();
        }else{
            return view('sale.invoice.show', compact('data'));
        }
    }

    public function invoicePaidByIdManager($id){
        $invoice = Invoice::find($id);
        $user = Client::where('email', $invoice->client->email)->first();
        $user_client = User::where('email', $invoice->client->email)->first();
        if($user_client != null){
            $this->afterPaymentCheckForms($invoice->id);
        }
        $invoice->payment_status = 2;
        $invoice->invoice_date = Carbon::today()->toDateTimeString();
        $invoice->save();
        return redirect()->back()->with('success','Invoice# ' . $invoice->invoice_number . ' Mark as Paid.');
    }

    public function invoicePaidById($id){
        $invoice = Invoice::find($id);
        $invoice->payment_status = 2;
        $user = Client::where('email', $invoice->client->email)->first();
        $user_client = User::where('email', $invoice->client->email)->first();
        $invoice->save();
        if($user_client != null){
            $this->afterPaymentCheckForms($invoice->id);
        }
        return redirect()->back()->with('success','Invoice# ' . $invoice->invoice_number . ' Mark as Paid.');
    }

    public function editInvoice($id){
        $invoice = Invoice::find($id);
        $brand = Brand::whereIn('id', Auth()->user()->brand_list())->get();;
        $services = Service::all();
        $currencies =  Currency::all();
        $merchant =  Merchant::all();
        return view('sale.invoice.edit', compact('invoice', 'brand', 'services', 'currencies', 'merchant'));
    }

    public function editInvoiceManager($id){
        $invoice = Invoice::find($id);
        $brand = Brand::whereIn('id', Auth()->user()->brand_list())->get();;
        $services = Service::all();
        $currencies =  Currency::all();
        $merchant =  Merchant::all();
        return view('manager.invoice.edit', compact('invoice', 'brand', 'services', 'currencies', 'merchant'));
    }

    public function saleUpdateManager(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'brand' => 'required',
            'service' => 'required',
            'package' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'merchant' => 'required'
        ]);
        $contact = $request->contact;
        if($contact == null){
            $contact = '#';
        }
        $invoice = Invoice::find($request->invoice_id);
        $invoice->name = $request->name;
        $invoice->email = $request->email;
        $invoice->contact = $contact;
        $invoice->brand = $request->brand;
        $invoice->package = $request->package;
        $invoice->currency = $request->currency;
        $invoice->client_id = $request->client_id;
        $invoice->sales_agent_id = Auth()->user()->id;
        $invoice->discription = $request->discription;
        $invoice->amount = $request->amount;
        $invoice->custom_package = $request->custom_package;
        $invoice->payment_type = $request->payment_type;
		$service = implode(",",$request->service);
		$invoice->service = $service;
		$invoice->merchant_id = $request->merchant;
        $invoice->save();
        return redirect()->route('manager.link',($invoice->id));
    }

    public function saleUpdate(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'brand' => 'required',
            'service' => 'required',
            'package' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'payment_type' => 'required',
            'merchant' => 'required',
        ]);
        $contact = $request->contact;
        if($contact == null){
            $contact = '#';
        }
        $invoice = Invoice::find($request->invoice_id);
        $invoice->name = $request->name;
        $invoice->email = $request->email;
        $invoice->contact = $contact;
        $invoice->brand = $request->brand;
        $invoice->package = $request->package;
        $invoice->currency = $request->currency;
        $invoice->client_id = $request->client_id;
        $invoice->sales_agent_id = Auth()->user()->id;
        $invoice->discription = $request->discription;
        $invoice->amount = $request->amount;
        $invoice->custom_package = $request->custom_package;
        $invoice->payment_type = $request->payment_type;
		$service = implode(",",$request->service);
		$invoice->service = $service;
		$invoice->merchant_id = $request->merchant;
        $invoice->save();
        return redirect()->route('sale.link',($invoice->id));
    }
    
}
