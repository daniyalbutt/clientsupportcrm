<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Mail;
use DB;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

   /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {

        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))){
            if(auth()->user()->status == 0){
                Auth::logout();
                return redirect()->back()->with('error', 'Email-Address And Password Are Wrong.');
            }else if(auth()->user()->is_employee == 0){
                return redirect()->route('sale.home');
            }else if (auth()->user()->is_employee == 1) {
                $data = $this->checkUserValid($request);
                return redirect()->to($data);
            }else if(auth()->user()->is_employee == 2){
                $data = $this->checkUserValid($request);
                return redirect()->to($data);
            }elseif(auth()->user()->is_employee == 3){
                return redirect()->route('client.home');
            }elseif(auth()->user()->is_employee == 4){
                $data = $this->checkUserValid($request);
                return redirect()->to($data);
                // $ip_address_array = ['202.47.36.97', '202.47.32.44', '113.203.241.253', '139.190.235.87', '111.88.58.18'];
                // $ip_address = $request->ip();
                // Session::put('ip_address', $ip_address);
                // Session::put('login_ip', $ip_address);
                // if (in_array($ip_address, $ip_address_array)){

                // }else{
                //     $bytes = bin2hex(random_bytes(3));
                //     DB::table('users')
                //     ->where('id', auth()->user()->id)
                //     ->update(['verfication_code' => $bytes, 'verfication_datetime' => date('Y-m-d H:i:s')]);

                //     $details = [
                //         'title' => 'Verfication Code',
                //         'body' => 'Your one time use Verfication code for email ' . auth()->user()->email . ' is ' . $bytes
                //     ];
                //     $sender_emails = ['daniyalbutt785@gmail.com'];
                //     $newmail = Mail::send('mail', $details, function($message) use ($bytes, $sender_emails){
                //         $message->to($sender_emails)->subject('Verfication Code');
                //         $message->from('info@domain.net', config('app.name'));
                //     });
                //     Session::put('valid_user', true);
                //     return redirect()->route('salemanager.verify');
                // }
            }elseif(auth()->user()->is_employee == 5){
                $data = $this->checkUserValid($request);
                return redirect()->to($data);
            }else{
                Session::put('valid_user', true);
                return redirect()->route('salemanager.dashboard');
                // $ip_address_array = ['202.47.32.22', '113.203.241.253', '206.42.123.75', '139.190.235.87', '202.47.34.48', '202.47.32.22', '39.48.194.97', '39.48.195.213', '182.184.119.166', '127.0.0.1'];
                // $ip_address = $request->ip();
                // Session::put('ip_address', $ip_address);
                // Session::put('login_ip', $ip_address);
                // if (in_array($ip_address, $ip_address_array)){
                //     Session::put('valid_user', true);
                //     return redirect()->route('salemanager.dashboard');
                // }else{
                //     $bytes = bin2hex(random_bytes(3));
                //     DB::table('users')
                //     ->where('id', auth()->user()->id)
                //     ->update(['verfication_code' => $bytes, 'verfication_datetime' => date('Y-m-d H:i:s')]);

                //     $details = [
                //         'title' => 'Verfication Code',
                //         'body' => 'Your one time use Verfication code for email ' . auth()->user()->email . ' is ' . $bytes
                //     ];
                //     $sender_emails = ['daniyalbutt785@gmail.com', 's4s.mohsin@gmail.com'];
                //     $newmail = Mail::send('mail', $details, function($message) use ($bytes, $sender_emails){
                //         $message->to($sender_emails)->subject('Verfication Code');
                //         $message->from('info@domain.net', config('app.name'));
                //     });
                //     Session::put('valid_user', false);
                //     return redirect()->route('salemanager.verify');
                // }
            }
        }else{
            return redirect()->back()->with('error', 'Email-Address And Password Are Wrong.');
        }
    }

    public function checkUserValid(Request $request){
        Session::put('valid_user', true);
        if(auth()->user()->is_employee == 4){
            return route('support.home');
        }else if(auth()->user()->is_employee == 2){
            return route('admin.home');
        }else if(auth()->user()->is_employee == 1){
            return route('production.dashboard');
        }else if(auth()->user()->is_employee == 5){
            return route('member.dashboard');
        }

        die();


        Session::put('valid_user', true);
        $ip_address_array = ['110.93.227.186', '103.125.71.39', '139.135.57.22','144.126.137.16','103.125.71.60','206.42.123.38'];
        $ip_address = $request->ip();
        Session::put('ip_address', $ip_address);
        Session::put('login_ip', $ip_address);
        if (in_array($ip_address, $ip_address_array)){
            Session::put('valid_user', true);
            if(auth()->user()->is_employee == 4){
                return route('support.home');
            }else if(auth()->user()->is_employee == 2){
                return route('admin.home');
            }else if(auth()->user()->is_employee == 1){
                return route('production.dashboard');
            }else if(auth()->user()->is_employee == 5){
                return route('member.dashboard');
            }
        }else{
            $bytes = bin2hex(random_bytes(3));
            DB::table('users')
            ->where('id', auth()->user()->id)
            ->update(['verfication_code' => $bytes, 'verfication_datetime' => date('Y-m-d H:i:s')]);

            $details = [
                'title' => 'Verfication Code',
                'body' => 'Your one time use Verfication code for email ' . auth()->user()->email . ' is ' . $bytes
            ];
            $sender_emails = ['kashan.azam.khan@gmail.com','shakeel_sattar@outlook.com','george@marketingnotch.com'];
            $newmail = Mail::send('mail', $details, function($message) use ($bytes, $sender_emails){
                $message->to($sender_emails)->subject('Verfication Code');
                $message->from('info@yourprojectcamp.com', config('app.name'));
            });
            // $mail = \Mail::to('daniyalbutt785@gmail.com')->send(new \App\Mail\ClientNotifyMail($details));
            Session::put('valid_user', false);
            return route('salemanager.verify');
            // return redirect()->route('salemanager.verify');
        }
    }

}
