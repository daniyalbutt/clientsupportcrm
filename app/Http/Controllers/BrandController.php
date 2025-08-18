<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Currency;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    function __construct(){
        $this->middleware('permission:view brand|create brand|edit brand|delete brand', ['only' => ['index','show']]);
        $this->middleware('permission:create brand', ['only' => ['create','store']]);
        $this->middleware('permission:edit brand', ['only' => ['edit','update']]);
        $this->middleware('permission:delete brand', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Brand::orderBy('id', 'desc')->get();
        return view('brand.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currency = Currency::where('status', 0)->get();
        return view('brand.create', compact('currency'));
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
            'image' => 'required',
            'url' => 'required',
            'currency_id' => 'required'
        ]);
        $data = new Brand();
        $data->name = $request->name;
        $data->status = $request->status;
        $data->url = $request->url;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('brands'), $imageName);
            $data->image = 'brands/'.$imageName;
        }
        $data->auth_code = uniqid();
        $data->currency_id = $request->currency_id;
        $data->save();
        return redirect()->back()->with('success', 'Brand Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Brand::find($id);
        $currency = Currency::where('status', 0)->get();
        return view('brand.edit', compact('data', 'currency'));
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
            'url' => 'required'
        ]);
        $data = Brand::find($id);
        $data->name = $request->name;
        $data->url = $request->url;
        $data->status = $request->status;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('brands'), $imageName);
            $data->image = 'brands/'.$imageName;
        }
        $data->currency_id = $request->currency_id;
        $data->save();
        return redirect()->back()->with('success', 'Brand Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        Brand::find($id)->delete();
        return redirect()->back()->with('success', 'Brand Deleted Successfully');   
    }
}
