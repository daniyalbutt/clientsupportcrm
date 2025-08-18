<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    function __construct(){
        $this->middleware('permission:view client|create client|edit client|delete client', ['only' => ['index','show']]);
        $this->middleware('permission:create client', ['only' => ['create','store']]);
        $this->middleware('permission:edit client', ['only' => ['edit','update']]);
        $this->middleware('permission:delete client', ['only' => ['destroy']]);
        $this->middleware('permission:logo form', ['only' => ['logoBrief']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Client::orderBy('id', 'desc');
        if($request->name != null){
            $client_name = $request->name;
            $data = $data->where('name', 'like', '%' . $client_name . '%');
        }
        if($request->email != null){
            $client_email = $request->email;
            $data = $data->where('email', 'like', '%' . $client_email . '%');
        }
        if($request->phone != null){
            $client_phone = $request->phone;
            $data = $data->where('phone', 'like', '%' . $client_phone . '%');
        }
        if($request->brand_name != null){
            $client_brand_name = $request->brand_name;
            $data = $data->where('brand_name', 'like', '%' . $client_brand_name . '%');
        }
        $data = $data->paginate(20);
        return view('client.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create');
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
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required|email|unique:clients',
            'email' => 'required',
            'phone' => 'required',
            'brand_name' => 'required',
        ]);
        $data = Client::create($request->all());
        return redirect()->route('payment.show', $data->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('client.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
    
    public function logoBrief($id){
        $data = Client::find($id);
        return view('logo-brief.index', compact('data'));
    }
}
