<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    function __construct(){
        $this->middleware('permission:view currency|create currency|edit currency|delete currency', ['only' => ['index','show']]);
        $this->middleware('permission:create currency', ['only' => ['create','store']]);
        $this->middleware('permission:edit currency', ['only' => ['edit','update']]);
        $this->middleware('permission:delete currency', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Currency::orderBy('id', 'desc');
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
        return view('currency.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currency.create');
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
            'sign' => 'required',
            'name' => 'required'
        ]);
        $data = new Currency();
        $data->sign = $request->sign;
        $data->name = $request->name;
        $data->status = $request->status;
        $data->save();
        return redirect()->back()->with('success', 'Currency Created Successfully');
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
        $data = Currency::find($id);
        return view('currency.edit', compact('data'));
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
            'sign' => 'required'
        ]);
        $data = Currency::find($id);
        $data->sign = $request->sign;
        $data->name = $request->name;
        $data->status = $request->status;
        $data->save();
        return redirect()->back()->with('success', 'Currency Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        Currency::find($id)->delete();
        return redirect()->back()->with('success', 'Currency Deleted Successfully');   
    }
}
