<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Haruncpi\LaravelUserActivity\Models\Log;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Carbon\Carbon;
use Session;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard()
    {         
        $category_count = DB::table('create_categories')->count();
        $brand_count = DB::table('brands')->count();
        $currency_count = DB::table('currencies')->count();
        $production_count = DB::table('users')->where('is_employee', 1)->count();
        $member_count = DB::table('users')->where('is_employee', 0)->count();
        $leads_count = DB::table('clients')->count();
        $project_count = DB::table('projects')->count();
        $paid_invoice = DB::table('invoices')->where('payment_status', 2)->count();
        $un_paid_invoice = DB::table('invoices')->where('payment_status', 1)->count();
        $invoice_month = Carbon::now()->format('F');
        $invoice_year = Carbon::now()->format('Y');
        $data = DB::table('invoices')
            ->select(DB::raw('SUM(amount) as amount'),  'invoice_date')
            ->whereRaw('MONTH(invoice_date) = ?',[date('m')])
            ->where('payment_status', 2)
            ->where('currency', 1)
            ->groupBy('invoice_date')
            ->orderBy('invoice_date', 'asc')
            ->get();
        
        $tickets_open = DB::table('issues')->where('status', 'Open')->count();
        $tickets_total = DB::table('issues')->count();
            
        return view('admin.dashboard', compact('category_count', 'brand_count', 'production_count', 'member_count', 'currency_count', 'leads_count', 'project_count', 'paid_invoice', 'un_paid_invoice', 'data', 'invoice_year', 'invoice_month','tickets_open', 'tickets_total'));
    }

    public function editProfile(){
        return view('admin.edit-profile');
    }

    public function verifyCode(Request $request){
        $user = DB::table('users')->where('email', Auth::user()->email)->where('verfication_code', $request->code)->first();
        if($user == null){
            return redirect()->back()->with('error', 'No Code Found in this Email.');   
        }else{
            $now_date = date('Y-m-d h:i:s');
            $verfication_code = date('Y-m-d H:i:s', strtotime($user->verfication_datetime . ' +1 day'));
            if ($verfication_code < $now_date) {
                // Vericiation Expire
                return redirect()->back()->with('error', 'Vericiation Expire.');   
            }else{
                Session::put('valid_user', true);
                if(Auth::user()->is_employee == 2){
                    return redirect()->route('admin.home');
                }else if(Auth::user()->is_employee == 4){
                    return redirect()->route('support.home');
                }else if(Auth::user()->is_employee == 6){
                    return redirect()->route('salemanager.dashboard');
                }else if(Auth::user()->is_employee == 1){
                    return redirect()->route('production.dashboard');
                }else if(Auth::user()->is_employee == 5){
                    return redirect()->route('member.dashboard');
                }
            }
            
        }
    }

    public function updateProfile(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'contact' => 'required'
        ]);
        $user = User::find($id);
        if($request->has('file')){
            $file = $request->file('file');
            $name = $file->getClientOriginalName();
            $file->move('uploads/users', $name);
            $path = 'uploads/users/'.$name;
            if($user->image != ''  && $user->image != null){
                $file_old = $user->image;
                unlink($file_old);
           } 
           $user->image = $path;   
        }
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->contact = $request->contact;
        $user->update();
        return redirect()->back()->with('success', 'Profile Updated Successfully.');   
    }

    public function changePassword(){
        return view('admin.change-password');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return redirect()->back()->with('success', 'Password Change Successfully.');
    }
}
