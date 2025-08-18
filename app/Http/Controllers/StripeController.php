<?php

namespace App\Http\Controllers;

use Session;
use Stripe;
use Exception;
use Stripe\PaymentIntent;
use App\Models\Payment;
use App\Models\ClientStripe;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function stripe()
    {
        return view('stripe');
    }

    public function stripePost(Request $request)
    {
        $data = Payment::find($request->input('id'));
        if ($data->status == 0) {
            try {
                $stripe_public = null;
                if($data->merchants == null){
                    $stripe_public = env('STRIPE_KEY');
                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                }else{
                    $stripe_public = $data->merchants->public_key;
                    \Stripe\Stripe::setApiKey($data->merchants->private_key);
                }
                $get_client_stripe = ClientStripe::where('client_id', $data->client_id)->where('public_key', $stripe_public)->first();
                $customer_id = null;
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
                    $client_stripe->public_key = $stripe_public;
                    $client_stripe->customer_id = $set_customer->id;
                    $client_stripe->save();
                    $customer_id = $set_customer->id;
                }else{
                    $customer_id = $get_client_stripe->customer_id;
                }

                try {
                    \Stripe\PaymentMethod::retrieve($request->payment_method)
                        ->attach(['customer' => $customer_id]);
                } catch (\Exception $e) {
                    
                }

                \Stripe\Customer::update($customer_id, [
                    'invoice_settings' => [
                        'default_payment_method' => $request->payment_method,
                    ],
                ]);

                $intent = PaymentIntent::create([
                    'amount' => $data->price * 100,
                    'currency' => $data->currency != null ? $data->currency->name : 'usd',
                    'description' => $data->package . ' - ' . $data->client->brand->name,
                    'customer' => $customer_id,
                    'payment_method' => $request->payment_method,
                    'off_session' => true,
                    'confirm' => true,
                ]);


                if ($intent->status === 'succeeded') {
                    // dd(json_encode($intent->toArray()));
                    $data->update([
                        'payment_method' => $request->payment_method,
                        'status'=> 2,
                        'return_response'=> json_encode($intent->toArray()),
                        'payment_data'=>$request->except(['amount','_token','id'])
                    ]);
                    return redirect()->route('success.payment', ['id' => $data->id]);
                }

            } catch (\Stripe\Exception\CardException $e) {
                $data->update(['status'=>1,'return_response'=> $e->getError()->message,'payment_data'=>$request->except(['amount','_token','id'])]);
                return redirect()->route('declined.payment', ['id' => $data->id]);
            } catch (\Stripe\Exception\RateLimitException $e) {
                $data->update(['status'=>1,'return_response'=> $e->getError()->message,'payment_data'=>$request->except(['amount','_token','id'])]);
                return redirect()->route('declined.payment', ['id' => $data->id]);
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $data->update(['status'=>1,'return_response'=> $e->getError()->message,'payment_data'=>$request->except(['amount','_token','id'])]);
                return redirect()->route('declined.payment', ['id' => $data->id]);
            } catch (\Stripe\Exception\AuthenticationException $e) {
                $data->update(['status'=>1,'return_response'=> $e->getError()->message,'payment_data'=>$request->except(['amount','_token','id'])]);
                return redirect()->route('declined.payment', ['id' => $data->id]);
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                $data->update(['status'=>1,'return_response'=> $e->getError()->message,'payment_data'=>$request->except(['amount','_token','id'])]);
                return redirect()->route('declined.payment', ['id' => $data->id]);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $data->update(['status'=>1,'return_response'=> $e->getError()->message,'payment_data'=>$request->except(['amount','_token','id'])]);
                return redirect()->route('declined.payment', ['id' => $data->id]);
            } catch (Exception $e) {
                $data->update(['status'=>1,'return_response'=> $e->getMessage(),'payment_data'=>$request->except(['amount','_token','id'])]);
                return redirect()->route('declined.payment', ['id' => $data->id]);
            }
            Session::flash('success', 'Payment Successful !');
        }
    }
    
    public function successPayment($id){
        $data = Payment::find($id);
        $transaction_id = '';
        if($data->merchant == 0){
            if($data->status == 2){
                $transaction_id = json_decode($data->return_response)->id;
            }
        }
        return view('payment-success', compact('id', 'transaction_id'));
    }
    
    public function declinedPayment($id){
        $data = Payment::find($id);
        $transaction_id = '';
        return view('payment-declined', compact('id', 'transaction_id'));
    }
    
    public function processPayment(Request $request)
    {
        $payments_id = $request->id;
        $payments = Payment::find($payments_id);
        if ($payments->status == 0) {
            $name = $request->ssl_first_name . ' ' . $request->ssl_last_name;
            $email = $request->ssl_email;
            $address = $request->ssl_avs_address;
            $accessToken = env('SQUARE_ACCESS_TOKEN');
            $this->locationId = env('SQUARE_LOCATION_ID');
            $defaultApiConfig = new \SquareConnect\Configuration();
            if (env('SQUARE_ENVIRONMENT') == 'sandbox') {
                $defaultApiConfig->setHost("https://connect.squareupsandbox.com");
            } else {
                $defaultApiConfig->setHost("https://connect.squareup.com");
            }
            $defaultApiConfig->setAccessToken($accessToken);
            $this->defaultApiClient = new \SquareConnect\ApiClient($defaultApiConfig);
            $cardNonce = $request->token;
            $customersApi = new \SquareConnect\Api\CustomersApi($this->defaultApiClient);
            $customerId = $this->addCustomer($name, $email, $address);
            $body = new \SquareConnect\Model\CreateCustomerCardRequest();
            $body->setCardNonce($cardNonce);
            try {
                $result = $customersApi->createCustomerCard($customerId, $body);
                $card_id = $result->getCard()->getId();
                $card_brand = $result->getCard()->getCardBrand();
                $card_last_four = $result->getCard()->getLast4();
                $card_exp_month = $result->getCard()->getExpMonth();
                $card_exp_year = $result->getCard()->getExpYear();
                $data_return = $this->charge($customerId, $card_id, $payments->price);
                $update_payments = Payment::find($payments->id);
                if ($data_return[0] != 0) {
                    $converted = json_encode(serialize($data_return[1]));
                    $update_payments->square_response = $converted;
                    if ($data_return[1]->getPayment()->getStatus() == 'COMPLETED') {
                        $update_payments->status = 2;
                        $update_payments->return_response = 'Payment Successfully - ' . $data_return[1]->getPayment()->getStatus();
                        $update_payments->save();
                        return redirect()->route('success.payment', ['id' => $payments->id]);
                    } else {
                        $update_payments->status = 1;
                        $update_payments->return_response = 'Card Declined';
                        $update_payments->save();
                        return redirect()->route('declined.payment', ['id' => $payments->id]);
                    }
                } else {
                    $response = $data_return[1];
                    $error_string = "";
                    foreach ($response->errors as &$error) {
                        $error_string .= $error->detail . "<br>";
                    }
                    $update_payments = Payment::find($payments->id);
                    $update_payments->status = 1;
                    $update_payments->return_response = $error_string;
                    $update_payments->save();
                    return redirect()->route('declined.payment', ['id' => $payments->id]);
                }
                $update_payments->save();

                return response()->json([
                    'status' => 'declined',
                    'data' => 'Checker'
                ], 200);
            } catch (Exception $e) {
                $response = $e->getResponseBody();
                $error_string = "";
                foreach ($response->errors as &$error) {
                    $error_string .= $error->detail . "<br>";
                }
                $update_payments = Payment::find($payments->id);
                $update_payments->status = 1;
                $update_payments->return_response = $error_string;
                $update_payments->save();
                return redirect()->route('declined.payment', ['id' => $payments->id]);
                return response()->json([
                    'status' => 'declined',
                    'data' => $error_string
                ], 200);
            } catch (\SquareConnect\ApiException $e) {
                $response = $e->getResponseBody();
                $error_string = "";
                foreach ($response->errors as &$error) {
                    $error_string .= $error->detail . "<br>";
                }
                $update_payments = Payment::find($payments->id);
                $update_payments->status = 1;
                $update_payments->return_response = $error_string;
                $update_payments->save();
                return redirect()->route('declined.payment', ['id' => $payments->id]);
                return response()->json([
                    'status' => 'declined',
                    'data' => $error_string
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 'declined',
                'data' => 'Already Used'
            ], 200);
        }
    }


    public function addCustomer($customer_name, $customer_email, $customer_address)
    {

        $name = $customer_name;
        $email = $customer_email;

        $customer = new \SquareConnect\Model\CreateCustomerRequest();
        $customer->setGivenName($name);
        $customer->setEmailAddress($email);

        $customer_address = new \SquareConnect\Model\Address();
        $customer_address->setAddressLine1($customer_address);

        $customer->setAddress = $customer_address;


        $customersApi = new \SquareConnect\Api\CustomersApi($this->defaultApiClient);

        try {
            $result = $customersApi->createCustomer($customer);
            $id = $result->getCustomer()->getId();
            return $id;
        } catch (Exception $e) {
            dump($e->getMessage());
            return "";
        }
        return "";
    }

    public function charge($customerId, $cardId, $price)
    {

        $payments_api = new \SquareConnect\Api\PaymentsApi($this->defaultApiClient);
        $payment_body = new \SquareConnect\Model\CreatePaymentRequest();

        $amountMoney = new \SquareConnect\Model\Money();

        # Monetary amounts are specified in the smallest unit of the applicable currency.
        # This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
        $amountMoney->setAmount($price * 100);
        $amountMoney->setCurrency("USD");
        $payment_body->setCustomerId($customerId);
        $payment_body->setSourceId($cardId);
        $payment_body->setAmountMoney($amountMoney);
        $payment_body->setLocationId($this->locationId);

        # Every payment you process with the SDK must have a unique idempotency key.
        # If you're unsure whether a particular payment succeeded, you can reattempt
        # it with the same idempotency key without worrying about double charging
        # the buyer.
        $payment_body->setIdempotencyKey(uniqid());

        try {
            $result = $payments_api->createPayment($payment_body);
            $transaction_id = $result->getPayment()->getId();
            return [$transaction_id, $result];
        } catch (\SquareConnect\ApiException $e) {
            return [0, $e->getResponseBody()];
        }
    }


    public function saleFront(Request $request){
        $id = $request->payment_id;
        $data = Payment::find($id);
        try {
            \Stripe\Stripe::setApiKey($data->merchants->private_key);
            if ($data->status == 0) {
                $get_client_stripe = ClientStripe::where('client_id', $data->client_id)->where('public_key', $data->merchants->public_key)->first();
                $intent = PaymentIntent::create([
                    'amount' => $data->price * 100,
                    'currency' => $data->currency != null ? $data->currency->name : 'usd',
                    'customer' => $get_client_stripe->customer_id,
                    'payment_method' => $request->payment_method,
                    'off_session' => true,
                    'confirm' => true,
                ]);
                if ($intent->status === 'succeeded') {
                    $data->update([
                        'payment_method' => $request->payment_method,
                        'status'=> 2,
                        'return_response'=> json_encode($intent->toArray()),
                        'payment_data'=>$request->except(['amount','_token','id'])
                    ]);
                    return redirect()->route('success.payment', ['id' => $data->id]);
                }
            }
        } catch (\Stripe\Exception\CardException $e) {
            $data->update([
                'status'=> 1,
                'return_response'=> $e->getError()->message
            ]);
            return redirect()->route('declined.payment', ['id' => $data->id]);
        } catch (\Stripe\Exception\RateLimitException $e) {
            $data->update([
                'status' => 1,
                'return_response'=> $e->getError()->message
            ]);
            return redirect()->route('declined.payment', ['id' => $data->id]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $data->update(['status'=>1,'return_response'=> $e->getError()->message,'payment_data'=>$request->except(['amount','_token','id'])]);
            return redirect()->route('declined.payment', ['id' => $data->id]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            $data->update([
                'status' => 1,
                'return_response' => $e->getError()->message
            ]);
            return redirect()->route('declined.payment', ['id' => $data->id]);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $data->update([
                'status' => 1,
                'return_response' => $e->getError()->message
            ]);
            return redirect()->route('declined.payment', ['id' => $data->id]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $data->update([
                'status' => 1,
                'return_response' => $e->getError()->message
            ]);
            return redirect()->route('declined.payment', ['id' => $data->id]);
        } catch (Exception $e) {
            $data->update([
                'status' => 1,
                'return_response' => $e->getMessage()
            ]);
            return redirect()->route('declined.payment', ['id' => $data->id]);
        }
    }
}
