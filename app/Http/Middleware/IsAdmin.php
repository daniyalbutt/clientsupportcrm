<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;
use Mail;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->is_employee == 2){
            $ip_address = $request->ip();
            $current_ip = Session::get('login_ip');
            $ip_address_array = ['110.93.227.186', '103.125.71.39', '139.135.57.22','144.126.137.16','103.125.71.60','206.42.123.38'];
            if($current_ip != null){
                array_push($ip_address_array, $current_ip);
            }
            Session::put('ip_address', $ip_address);
            $valid_user = Session::get('valid_user');
            if($valid_user == true){
                if (in_array($ip_address, $ip_address_array)){
                    Session::put('valid_user', true);
                }else{
                    $valid_user = Session::get('valid_user');
                    if($valid_user == true){
                        Session::put('valid_user', true);
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
                        Session::put('valid_user', false);
                        Auth::logout();
                        return redirect()->route('salemanager.verify');
                    }
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
                $newmail = Mail::send('mail', $details, function($message) use ($bytes){
                    $message->to('kashan.azam.khan@gmail.com','shakeel_sattar@outlook.com','george@marketingnotch.com')->subject
                        ('Verfication Code');
                    $message->from('info@yourprojectcamp.com', config('app.name'));
                });
                Auth::logout();
                return redirect()->back();
                Session::put('valid_user', false);
            }

            return $next($request);
        }

        return redirect()->back()->with("error","You don't have admin access.");
    }
}
