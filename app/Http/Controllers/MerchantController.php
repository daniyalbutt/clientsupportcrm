<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{

    function __construct(){
        $this->middleware('permission:view merchant|create merchant|edit merchant|delete merchant', ['only' => ['index','show']]);
        $this->middleware('permission:create merchant', ['only' => ['create','store']]);
        $this->middleware('permission:edit merchant', ['only' => ['edit','update']]);
        $this->middleware('permission:delete merchant', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Merchant::orderBy('id', 'desc');
        if($request->name != null){
            $data = $data->where('name', 'like', '%'.$request->name.'%');
        }
        if($request->merchant != null){
            $data = $data->where('merchant', $request->merchant);
        }
        if($request->status != null){
            $data = $data->where('status', $request->status);
        }
        $data = $data->get();
        return view('merchant.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchant.create');
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
            'merchant' => 'required',
            'sandbox' => 'required',
            'status' => 'required',
            'public_key' => 'required',
            'private_key' => 'required'
        ]);
        $data = new Merchant();
        $data->name = $request->name;
        $data->merchant = $request->merchant;
        $data->sandbox = $request->sandbox;
        $data->status = $request->status;
        $data->public_key = $request->public_key;
        $data->private_key = $request->private_key;
        $data->save();
        return redirect()->back()->with('success', 'Merchant Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function show(Merchant $merchant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Merchant::find($id);
        return view('merchant.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'merchant' => 'required',
            'sandbox' => 'required',
            'status' => 'required',
            'public_key' => 'required',
            'private_key' => 'required'
        ]);
        $data = Merchant::find($id);
        $data->name = $request->name;
        $data->merchant = $request->merchant;
        $data->sandbox = $request->sandbox;
        $data->status = $request->status;
        $data->public_key = $request->public_key;
        $data->private_key = $request->private_key;
        $data->save();
        return redirect()->back()->with('success', 'Merchant Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        Merchant::find($id)->delete();
        return redirect()->back()->with('success', 'Merchant Deleted Successfully');   
    }
}
