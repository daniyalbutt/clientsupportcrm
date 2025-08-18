<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use App\Models\ClientStripe;
use App\Models\Brand;
use App\Models\Merchant;
use App\Models\Currency;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Exception\ApiErrorException;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    function __construct(){
        $this->middleware('permission:view payment|create payment|edit payment|delete payment', ['only' => ['index','show']]);
        $this->middleware('permission:create payment', ['only' => ['create','store']]);
        $this->middleware('permission:edit payment', ['only' => ['edit','update']]);
        $this->middleware('permission:delete payment', ['only' => ['destroy']]);
        $this->middleware('permission:download invoice', ['only' => ['invoiceDownload']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = null;
        $id = $request->id;
        if($id != null){
            $data = Client::find($id);
        }
        $brand = Brand::where('status', 0)->orderby('id', 'desc')->get();
        $merchant = Merchant::where('status', 0)->get();
        $currency = Currency::where('status', 0)->get();
        return view('payment.create', compact('data', 'brand', 'merchant', 'currency'));
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
            'email' => 'required|email',
            'phone' => 'required',
            'brand_name' => 'required',
            'package' => 'required',
            'price' => 'required',
            'currency' => 'required'
        ]);

        $client = Client::where('email', $request->email)->first();
        $client_id = 0;

        if($client == null){
            $client = Client::create($request->all());
            $client_id = $client->id;
        }else{
            $client_id = $client->id;
        }

        $payment = new Payment();
        $payment->package = $request->package;
        $payment->price = $request->price;
        $payment->description = $request->description;
        $payment->client_id = $client_id;
        $payment->unique_id = bin2hex(random_bytes(14));
        $payment->merchant = $request->merchant;
        $payment->currency_id = $request->currency;
        $payment->save();

        return redirect()->route('payment.show', [$payment->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Payment::find($id);
        $client_id = $data->client_id;
        $public_key = null;
        if($data->merchants != null){
            if($data->merchants->merchant == 0){
                $public_key = $data->merchants->public_key;
                \Stripe\Stripe::setApiKey($data->merchants->private_key);
            }
        }else{
            $public_key = env('STRIPE_KEY');
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        }

        $payment_array = [];
        $get_payment = Payment::where('client_id', $client_id)->whereNotNull('payment_method')->where('public_key', $public_key)->get();
        foreach($get_payment as $key => $value){
            try {
                $paymentMethod = PaymentMethod::retrieve($value->payment_method); // Possibly bad ID
                if ($paymentMethod && $paymentMethod->card) {
                    $last4 = $paymentMethod->card->last4;
                    $brand = $paymentMethod->card->brand;
                    $expMonth = $paymentMethod->card->exp_month;
                    $expYear = $paymentMethod->card->exp_year;
                    $cardholderName = $paymentMethod->billing_details->name ?? null;
                    array_push($payment_array, ['last4' => $last4, 'brand' => $brand, 'month' => $expMonth, 'year' => $expYear, 'id' => $value->payment_method, 'cardholderName' => $cardholderName]);
                }

            } catch (ApiErrorException $e) {
                // Log or handle Stripe error safely
                
            }
        }
        $payment_array = array_map("unserialize", array_unique(array_map("serialize", $payment_array)));
        return view('payment.show', compact('data', 'payment_array'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
    
    public function delete($id){
        $payment = Payment::find($id);
        $payment->show_status = 1;
        $payment->save();
        return redirect()->back()->with('success', 'Invoice Deleted Successfully');   
    }
    
    public function invoiceDownload($id){
        $payment = Payment::find($id);
        if($payment->status == 2){
         
            $pdf = Pdf::loadView('pdf', [
                'brand_image' => $payment->client->brand->image,
                'brand_name' => $payment->client->brand->name,
                'invoice_id' => $payment->id,
                'client_name' => $payment->client->name,
                'paid_date' => $payment->updated_at->format('F d, Y'),
                'currency' => $payment->currency != null ? $payment->currency->sign : '$',
                'amount' => $payment->price,
                'item' => $payment->package
            ]);
            
            return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="invoice_' . $payment->id . '.pdf"');
         
            return $pdf->download();
            dump($payment);
        }else{
            return redirect()->back();
        }
    }
    
}
