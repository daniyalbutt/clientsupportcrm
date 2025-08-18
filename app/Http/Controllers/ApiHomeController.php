<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Notifications\LeadNotification;
use App\Notifications\PaymentNotification;
use DB;
use Notification;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Client;

use Pusher\Pusher;

class ApiHomeController extends Controller{

    public function checkAuthBrandKey($brand_key){
        if($brand_key == ''){
            return false;
        }
        $brandKey = DB::table('brands')->where('auth_code', $brand_key)->first();
        if($brandKey == null){
            return false;
        }else{
            return true;
        }
    }
    
    public function submitPayment(Request $request){
        $return_value = $this->checkAuthBrandKey($request->header('custom-auth'));
        if($return_value){
            $invoice = new Payment();
            $invoice->package = $request->package_name;
            $invoice->price = $request->amount;
            $invoice->client_id = $request->crm_id;
            $invoice->unique_id = bin2hex(random_bytes(14));
            $invoice->return_response = $request->charge_object;
            $invoice->status = 2;
            $invoice->payment_data = json_encode($request->input());
            $invoice->merchant = 0;
            $invoice->is_website = 1;
            $invoice->save();
            return response()->json(['status' => true]);
        }
    }
    
    public function logoBrief(Request $request){
        $return_value = $this->checkAuthBrandKey($request->header('custom-auth'));
        if($return_value){
            $validator = Validator::make($request->all(), [
                'logo_info' => 'required',
                'brief_text' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()]);
            }
            $logo_info = $request->logo_info;
            $brief_text = $request->brief_text;
            $selected_logo = $request->selected_logo;
            $brief_text = $request->brief_text;
            $brief_tagline = $request->brief_tagline;
            $brief_description = $request->brief_description;
            $design_concept = $request->design_concept;
            $existing_website = $request->existing_website;
            $client_id = $request->client_id;
            $client_email = $request->email;
            DB::table('logo_brief')->insert(
                [
                    'logo_info' => $logo_info,
                    'selected_logo' => $selected_logo,
                    'brief_text' => $brief_text,
                    'brief_tagline' => $brief_tagline,
                    'brief_description' => $brief_description,
                    'design_concept' => $design_concept,
                    'existing_website' => $existing_website,
                    'client_id' => $client_id,
                    'client_email' => $client_email
                ]
            );
            return response()->json(['status' => true]);
        }
    }

    public function leadStore(Request $request){
        $return_value = $this->checkAuthBrandKey($request->header('custom-auth'));
        if($return_value){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'contact' => 'required',
                'url' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()]);
            }
            $f_name = $request->name;
            $email = $request->email;
            $phone = $request->contact;
            if($request->l_name != null){
                $l_name = $request->l_name;
            }
            if($request->services != null){
                $services = $request->services;
            }
            if($request->message != null){
                $message = $request->message;
            }
            $brand = DB::table('brands')->where('auth_code', $request->header('custom-auth'))->first();

            $get_client =  DB::table('clients')->where('email', $email)->where('phone', $phone)->first();
            if($get_client == null){
                $client = new Client();
                $client->name = $f_name;
                $client->email = $email;
                $client->phone = $phone;
                $client->brand_name  =  $brand->id;
                $client->sender_response  =  json_encode($request->input());
                $client->is_website = 1;
                $client->created_at = new \DateTime();
                $client->save();
                // $this->sendLeadNotification($client->id, 2);
                return response()->json(['status' => true, 'message' => $client->id, 'email' => $client->email, 'name' => $client->name, 'phone' => $client->phone]);
            }else{
                return response()->json(['status' => true, 'message' => $get_client->id, 'email' => $get_client->email, 'name' => $get_client->name, 'phone' => $get_client->phone]);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Error has been Occured']);
        }
    }

    public function sendLeadNotification($client, $role) {
        //role define woh gets notification
        if($role == 2){
            $client_data = Client::with('brand')->find($client);
            $adminusers = User::where('is_employee', 2)->get();
            $leadData = [
                'name' => $client_data->name,
                'email' => $client_data->email,
                'contact' => $client_data->contact,
                'text' => 'Lead Generated',
                'url' => url('/'),
                'id' => $client
            ];

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );
            $managers = User::where('is_employee', 6)->whereHas('brands', function ($query) use ($client_data) {
                return $query->where('brand_id', $client_data->brand_id);
            })->get();
            foreach($adminusers as $adminuser){
                $pusher->trigger('private.' . $adminuser->id, 'send-lead-notifiction', ['data'=>$client_data->toJson(), 'title' => 'New Client Arrival', 'message' => $client_data->name.' arrived from '. $client_data->brand->name.' Brand', 'image' => 'new-customer.png', 'link' => route('admin.client.show',$client_data)]);
                Notification::send($adminuser, new LeadNotification($leadData));
            }

            foreach($managers as $adminuser){
                $pusher->trigger('private.' . $adminuser->id, 'send-lead-notifiction', ['data'=>$client_data->toJson(), 'title' => 'New Client Arrival', 'message' => $client_data->name.' arrived from '. $client_data->brand->name.' Brand', 'image' => 'new-customer.png', 'link' => route('admin.client.show',$client_data)]);
                Notification::send($adminuser, new LeadNotification($leadData));
            }
        }
    }

    public function paymentStore(Request $request){
        $return_value = $this->checkAuthBrandKey($request->header('custom-auth'));
        if($return_value){
            $brand = DB::table('brands')->where('auth_code', $request->header('custom-auth'))->first();
            $currencies = DB::table('currencies')->where('sign', $brand->sign)->first();
            $latest = Invoice::latest()->first();
            if (! $latest) {
                $nextInvoiceNumber = date('Y').'-1';
            }else{
                $expNum = explode('-', $latest->invoice_number);
                $expIncrement = (int)$expNum[1] + 1;
                $nextInvoiceNumber = $expNum[0].'-'.$expIncrement;
            }
            $invoice = new Invoice();
            $invoice->name = $request->name;
            $invoice->email = $request->email;
            $invoice->contact = $request->contact;
            $invoice->brand = $brand->id;
            $invoice->package = $request->package;
            $invoice->currency = $currencies->id;
            $invoice->client_id = $request->crm_cus_id;
            $invoice->invoice_number = $nextInvoiceNumber;
            $invoice->sales_agent_id = 0;
            $invoice->amount = $request->amount;
            $invoice->payment_status = 2;
            $invoice->payment_type = 0;
            $invoice->custom_package = $request->custom_package;
            $invoice->transaction_id = $request->transaction_id;
            $invoice->save();
            $this->sendInvoiceNotification($invoice->id, 2);
            return response()->json(['status' => true, 'message' => 'Payment Successfully']);
        }else{
            return response()->json(['status' => false, 'message' => 'Error has been Occured']);
        }
    }

    public function sendInvoiceNotification($invoice, $role) {
        //role define woh gets notification
        if($role == 2){
            $invoice_data = DB::table('invoices')->where('id', $invoice)->first();
            $adminusers = User::where('is_employee', 2)->get();
            $leadData = [
                'name' => $invoice_data->name,
                'email' => $invoice_data->email,
                'text' => 'Payment Successfully',
                'url' => url('/'),
                'id' => $invoice
            ];
            foreach($adminusers as $adminuser){

                Notification::send($adminuser, new PaymentNotification($leadData));
            }
        }
    }


}
