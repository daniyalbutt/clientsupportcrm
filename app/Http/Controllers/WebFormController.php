<?php

namespace App\Http\Controllers;

use App\Models\WebForm;
use Illuminate\Http\Request;
use App\Models\FormFiles;
use Auth;
use File;

class WebFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $web_form = WebForm::find($id);
        if($web_form->user_id == Auth::user()->id){
            return view('client.web', compact('web_form'));
        }else{
            return redirect()->back();
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WebForm  $webForm
     * @return \Illuminate\Http\Response
     */
    public function show(WebForm $webForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WebForm  $webForm
     * @return \Illuminate\Http\Response
     */
    public function edit(WebForm $webForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WebForm  $webForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $web_form = WebForm::find($id);
        if($web_form->user_id == Auth::user()->id){
            $web_form->business_name = $request->business_name;
            $web_form->website_address = $request->website_address;
            $web_form->address = $request->address;
            $web_form->decision_makers = $request->decision_makers;
            $web_form->about_company = $request->about_company;
            $web_form->purpose = json_encode($request->purpose);
            $web_form->deadline = $request->deadline;
            $web_form->potential_clients = $request->potential_clients;
            $web_form->competitor = $request->competitor;
            $web_form->user_perform = json_encode($request->user_perform);
            $web_form->pages = json_encode($request->page);
            $web_form->written_content = $request->written_content;
            $web_form->copywriting_photography_services = $request->copywriting_photography_services;
            $web_form->cms_site = $request->cms_site;
            $web_form->re_design = $request->re_design;
            $web_form->working_current_site = $request->working_current_site;
            $web_form->going_to_need = json_encode($request->going_to_need);
            $web_form->additional_features = $request->additional_features;
            $web_form->feel_about_company = $request->feel_about_company;
            $web_form->incorporated = $request->incorporated;
            $web_form->need_designed = $request->need_designed;
            $web_form->specific_look = $request->specific_look;
            $web_form->competition = json_encode($request->competition);
            $web_form->websites_link = json_encode($request->websites_link);
            $web_form->people_find_business = $request->people_find_business;
            $web_form->market_site = $request->market_site;
            $web_form->accounts_setup = $request->accounts_setup;
            $web_form->links_accounts_setup = $request->links_accounts_setup;
            $web_form->service_account = $request->service_account;
            $web_form->use_advertising = $request->use_advertising;
            $web_form->printed_materials = $request->printed_materials;
            $web_form->domain_name = $request->domain_name;
            $web_form->hosting_account = $request->hosting_account;
            $web_form->login_ip = $request->login_ip;
            $web_form->domain_like_name = $request->domain_like_name;
            $web_form->section_regular_updating = $request->section_regular_updating;
            $web_form->updating_yourself = $request->updating_yourself;
            $web_form->blog_written = $request->blog_written;
            $web_form->regular_basis = $request->regular_basis;
            $web_form->fugure_pages = $request->fugure_pages;
            $web_form->additional_information = $request->additional_information;
            $web_form->save();
            if($request->hasfile('attachment'))
                {
                    $i = 0;
                    foreach($request->file('attachment') as $file)
                    {
                        $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $name = strtolower(str_replace(' ', '-', $file_name)) . '_' . $i . '_' .time().'.'.$file->extension();
                        $file->move(public_path().'/files/form', $name);
                        $i++;
                        $form_files = new FormFiles();
                        $form_files->name = $file_name;
                        $form_files->path = $name;
                        $form_files->logo_form_id = $web_form->id;
                        $form_files->form_code = 2;
                        $form_files->save();
                    }
                }
                return redirect()->back()->with('success', 'Web Form Created');
            }else{
                return redirect()->back();
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WebForm  $webForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebForm $webForm)
    {
        //
    }
}
