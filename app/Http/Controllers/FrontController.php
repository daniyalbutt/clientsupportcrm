<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\ClientStripe;
use Session;
use Exception;
use Stripe\Stripe;
use Stripe\SetupIntent;

class FrontController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function payNow($id)
    {
        $data = Payment::where('unique_id', $id)->first();
        if($data->show_status == 1){
            return abort(404);
        }
        if($data->status == 1){
            return redirect()->route('declined.payment', ['id' => $data->id]);
        }
        if($data->status == 2){
            return redirect()->route('success.payment', ['id' => $data->id]);
        }
        if($data->merchants == null){
            if($data->merchant == 0){
                return view('stripe', compact('data'));
            }else{
                return view('square', compact('data'));
            }
        }else{
            if($data->merchants->merchant == 0){
                \Stripe\Stripe::setApiKey($data->merchants->private_key);
                $customer_id = null;
                $get_client_stripe = ClientStripe::where('client_id', $data->client_id)->where('public_key', $data->merchants->public_key)->first();
                if($get_client_stripe == null){
                    $set_customer = \Stripe\Customer::create([
                        'name' => $data->client->name,
                        'email' => $data->client->email,
                        'phone' => $data->client->phone,
                        'description' => $data->client->brand->name,
                        'metadata' => [
                            'internal_id' => $data->client->id,
                            'signup_source' => url()->current(),
                        ],
                    ]);
                    $client_stripe = new ClientStripe();
                    $client_stripe->client_id = $data->client->id;
                    $client_stripe->public_key = $data->merchants->public_key;
                    $client_stripe->customer_id = $set_customer->id;
                    $client_stripe->save();
                    $customer_id = $set_customer->id;
                }

                if($data->public_key == null){
                    $setupIntent = SetupIntent::create([
                        'customer' => $customer_id,
                    ]);
                    $data->update(
                        ['public_key' => $data->merchants->public_key, 'client_secret' => $setupIntent->client_secret]
                    );
                }
                return view('stripe', compact('data'));
            }else{
                return view('square', compact('data'));
            }
        }
    }

    public function invoice($id){
        $data = Payment::where('unique_id', $id)->first();
        return view('invoice', compact('data'));
    }
}
