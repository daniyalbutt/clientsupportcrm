<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:view payment|create payment|edit payment|delete payment', ['only' => ['index','show']]);
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $month_paid = DB::table('payments')
            ->whereRaw('MONTH(updated_at) = ?',[date('m')])
            ->where('status', 2)
            ->sum('price');
        $last = DB::table('payments')->where('status', 2)->orderBy('updated_at', 'desc')->first();
        $data = Payment::orderBy('id', 'desc')->where('show_status', 0);
        if($request->name != null){
            $client_name = $request->name;
            $data = $data->whereHas('client', function($q) use ($client_name){
                $q->where('name', 'like', '%' . $client_name . '%');
            });
        }
        if($request->email != null){
            $client_email = $request->email;
            $data = $data->whereHas('client', function($q) use ($client_email){
                $q->where('email', 'like', '%' . $client_email . '%');
            });
        }
        if($request->phone != null){
            $client_phone = $request->phone;
            $data = $data->whereHas('client', function($q) use ($client_phone){
                $q->where('phone', 'like', '%' . $client_phone . '%');
            });
        }
        if($request->status != null){
            $data = $data->where('status', $request->status);
        }

        if($request->brand != null){
            $client_brand = $request->brand;
            $data = $data->whereHas('client', function($q) use ($client_brand){
                $q->where('brand_name', $client_brand);
            });
        }
        $data = $data->orderBy('id', 'desc')->paginate(20);
        
        $brands = DB::table('brands')->where('status', 0)->get();

        return view('home', compact('data', 'month_paid', 'last', 'brands'));
    }

    public function showResponse($id){
        $data = Payment::find($id);
        return view('show-response', compact('data'));
    }
    
    public function changePassword(){
        return view('change-password');
    }
    
    public function changePasswordStore(Request $request){
        $request->validate([
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return redirect()->back()->with('success', 'Password Updated Successfully');   
    }
}
