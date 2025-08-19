<?php

namespace App\Http\Controllers;
use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index(){
        $data = Merchant::orderBy('id', 'desc')->get();
        return view('admin.merchant.index', compact('data'));
    }

    public function create(){
        return view('admin.merchant.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'public_key' => 'required',
            'secret_key' => 'required',
            'status' => 'required',
        ]);
        $merchant = new Merchant();
        $merchant->name = $request->name;
        $merchant->public_key = $request->public_key;
        $merchant->secret_key = $request->secret_key;
        $merchant->status = $request->status;
        $merchant->login_id = $request->login_id;
        $merchant->is_authorized = $request->is_authorized;
        $merchant->live_mode = $request->live_mode;
        $merchant->save();
        return redirect()->route('admin.merchant.index')->with('success','Merchant created Successfully.');
    }

    public function edit($id){
        $data = Merchant::find($id);
        return view('admin.merchant.edit', compact('data'));
    }

    public function update(Request $request, Merchant $merchant){
        $request->validate([
            'name' => 'required',
            'public_key' => 'required',
            'secret_key' => 'required',
            'status' => 'required',
        ]);
        $merchant->update($request->except('_method', '_token'));
        return redirect()->route('admin.merchant.edit', $merchant->id)->with('success','Merchant Updated Successfully.');

    }
}
