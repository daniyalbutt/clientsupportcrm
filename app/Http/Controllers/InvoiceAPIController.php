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

class InvoiceAPIController extends Controller
{
    public function managerStoreAPI(Request $request)
    {
        $apiToken = $request->header('X-API-TOKEN');
        if (!$apiToken || !hash_equals($apiToken, env('API_TOKEN'))) {
            return response()->json(['error' => 'Invalid API token'], 401);
        }

        dd($request->all());

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
		return response()->json(['success' => 'Invoice Created Successfully!']);
    }

    public function managerStore(Request $request)
    {
        $url = route('auto.store.api'); // Replace with your API endpoint
        $apiToken = env('API_TOKEN'); // Replace with your actual API token
        // dd($apiToken);
        // Data to send in the request
        $data = array(
            'client_id' => $request->client_id,
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'brand' => $request->brand,
            'service' => $request->service,
            'package' => $request->package,
            'createform' => $request->createform,
            'custom_package' => $request->custom_package,
            'currency' => $request->currency,
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'merchant' => $request->merchant,
            'discription' => $request->discription,
        );
        
        // Initialize cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
            'Content-Type: application/json',
            'X-API-TOKEN:' . $apiToken
            )
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        dd($curl);
        
        $response = curl_exec($curl);
        if(curl_errno($curl)) {
            dd('cURL error: ' . curl_error($curl));
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Debug the response and HTTP code
        dd('HTTP Status Code: ' . $httpCode, $response);
        
        $responseData = json_decode($response, true);
        
        
        curl_close($curl);

        dd($response);
        exit;

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
        
        $currentDate = date('d-m-Y');

        $formattedDate = str_replace('-', '', $currentDate);
        
        if (! $latest) {
            $nextInvoiceNumber = $formattedDate.'-1';
        }else{
            $expNum = explode('-', $latest->invoice_number);
            $expIncrement = (int)$expNum[1] + 1;
            $nextInvoiceNumber = $formattedDate.'-'.$expIncrement;
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
        
        $id = base64_encode($id);
		$invoiceId = base64_decode($id);
		$_getInvoiceData = Invoice::findOrFail($invoiceId);
		$_getBrand = Brand::where('id',$_getInvoiceData->brand)->first();
        $package_name = '';
        if($_getInvoiceData->package == 0){
            $package_name = strip_tags($_getInvoiceData->custom_package);
        }
        // $sendemail = $request->sendemail;
        $sendemail = 0;
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

    public function sendApiRequest($request)
    {
        
        

        // $curl = curl_init();

        // // Set cURL options
        // curl_setopt_array($curl, [
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_HTTPHEADER => [
        //         'Content-Type: application/json',
        //         'X-API-TOKEN: ' . $apiToken,
        //     ],
        //     CURLOPT_POST => true,
        //     CURLOPT_POSTFIELDS => json_encode($data),
        // ]);

        // Execute the request
        // $response = curl_exec($curl);
        
        // Check for errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);

            // Handle the error
            return response()->json(['error' => $error], 500);
        }

        // Close the cURL session
        curl_close($curl);

        // Convert the response to an array (if JSON)
        $responseArray = json_decode($response, true);

        dd($responseArray);
        // Return the response
        return response()->json($responseArray);
    }
}
