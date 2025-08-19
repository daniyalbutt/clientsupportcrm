<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if($data['is_employee'] == 0){

            return Validator::make($data, [
                'is_employee' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'contact' => ['required', 'string', 'max:11'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }else{
         
            return Validator::make($data, [
                'is_employee' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'res_add' => ['required', 'string', 'max:255'],
                'contact' => ['required', 'string', 'max:11'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'work_add' => ['required', 'string', 'max:255'],
                'work_add_lat' => ['required', 'string', 'max:255'],
                'work_add_log' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'work_cont' => ['required', 'string', 'max:255'],
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if($data['is_employee'] == 0){
            return User::create([
                'is_employee' => $data['is_employee'],
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'contact' => $data['contact'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }else{
          
            return User::create([
                'is_employee' => $data['is_employee'],
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'contact' => $data['contact'],
                'email' => $data['email'],
                'res_add' => $data['res_add'],
                'work_add' => $data['work_add'],
                'work_add_lat' => $data['work_add_lat'],
                'work_add_log' => $data['work_add_log'],
                'city' => $data['city'],
                'work_cont' => $data['work_cont'],
                'password' => Hash::make($data['password']),
                'status' => 0,
            ]);
        }
        
    }

}
