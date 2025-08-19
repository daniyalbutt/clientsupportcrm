<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Merchant;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Brand::all();
        $merchant = Merchant::where('status', 1)->get();
        return view('admin.brand.index', compact('data', 'merchant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'url' => 'required',
            'image' => 'required',
            'phone' => 'required',
            'phone_tel' => 'required',
            'email' => 'required',
            'address' => 'required',
            'address_link' => 'required',
            'sign' => 'required'
        ]);

        $merchants = $request->merchant;

        $request->request->add(['auth_key' => sha1(time())]);
        if($request->has('image')){
            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $file->move('uploads/brands', $name);
            $path = 'uploads/brands/'.$name;
            $request->request->add(['logo' => $path]);
        }
        $brand = Brand::create($request->all());
        $brand->merchants()->attach($merchants);
        
        return redirect()->route('brand.index')->with('success','Brand created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        $client_datas = Client::where('brand_id', $brand->id)->orderBy('id', 'desc')->paginate(20);
        $invoice_datas = Invoice::where('brand', $brand->id)->orderBy('id', 'desc')->where('payment_status', 2)->paginate(20);
        $un_paid_invoice_datas = Invoice::where('brand', $brand->id)->orderBy('id', 'desc')->where('payment_status', 1)->paginate(20);
        $project_datas = Project::where('brand_id', $brand->id)->orderBy('id', 'desc')->paginate(20);
        $task_datas = Task::where('brand_id', $brand->id)->paginate(20);
        return view('admin.brand.show', compact('brand', 'client_datas', 'invoice_datas', 'un_paid_invoice_datas', 'project_datas', 'task_datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Brand::find($id);
        $merchant = Merchant::where('status', 1)->get();
        return view('admin.brand.edit', compact('data', 'merchant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
            'phone' => 'required',
            'phone_tel' => 'required',
            'email' => 'required',
            'address' => 'required',
            'address_link' => 'required',
            'sign' => 'required'
        ]);
        $merchants = $request->merchant;
        if($request->has('image')){
            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $file->move('uploads/brands', $name);
            $path = 'uploads/brands/'.$name;
            $request->request->add(['logo' => $path]);
            if($brand->logo != ''  && $brand->logo != null){
                $file_old = $brand->logo;
                unlink($file_old);
           } 
        }
        $brand->update($request->all());
        $brand->merchants()->sync($merchants);
        return redirect()->route('brand.edit', $brand->id)->with('success','Brand Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }

    public function brandMerchant(Request $request){
        $merchant = Brand::find($request->id)->merchants;
        return response()->json(['data' => $merchant]);
    }
}
