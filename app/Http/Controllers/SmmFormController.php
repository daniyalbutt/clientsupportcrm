<?php

namespace App\Http\Controllers;

use App\Models\SmmForm;
use Illuminate\Http\Request;
use Auth;
use App\Models\FormFiles;

class SmmFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $smm_form = SmmForm::find($id);
        if($smm_form->user_id == Auth::user()->id){
            return view('client.smm', compact('smm_form'));
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
     * @param  \App\Models\SmmForm  $smmForm
     * @return \Illuminate\Http\Response
     */
    public function show(SmmForm $smmForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SmmForm  $smmForm
     * @return \Illuminate\Http\Response
     */
    public function edit(SmmForm $smmForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SmmForm  $smmForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $smm_form = SmmForm::find($id);
        if($smm_form->user_id == Auth::user()->id){
            $smm_form->desired_results = json_encode($request->desired_results);
            $smm_form->business_name = $request->business_name;
            $smm_form->business_email_address = $request->business_email_address;
            $smm_form->business_phone_number = $request->business_phone_number;
            $smm_form->business_mailing_address = $request->business_mailing_address;
            $smm_form->business_website_address = $request->business_website_address;
            $smm_form->business_working_hours = $request->business_working_hours;
            $smm_form->business_location = $request->business_location;
            $smm_form->business_category = $request->business_category;
            $smm_form->facebook_page = $request->facebook_page;
            $smm_form->instagram_page = $request->instagram_page;
            $smm_form->instagram_password = $request->instagram_password;
            $smm_form->twitter_page = $request->twitter_page;
            $smm_form->twitter_password = $request->twitter_password;
            $smm_form->linkedin_page = $request->linkedin_page;
            $smm_form->pinterest_page = $request->pinterest_page;
            $smm_form->pinterest_password = $request->pinterest_password;
            $smm_form->youtube_page = $request->youtube_page;
            $smm_form->gmail_address_youtube = $request->gmail_address_youtube;
            $smm_form->gmail_password_youtube = $request->gmail_password_youtube;
            $smm_form->social_media_platforms = json_encode($request->social_media_platforms);
            $smm_form->target_audience = json_encode($request->target_audience);
            $smm_form->target_locations = $request->target_locations;
            $smm_form->age_bracket = $request->age_bracket;
            $smm_form->represent_your_business = $request->represent_your_business;
            $smm_form->business_usp = $request->business_usp;
            $smm_form->do_not_want_us_to_use = $request->do_not_want_us_to_use;
            $smm_form->competitors = $request->competitors;
            $smm_form->additional_comments = $request->additional_comments;
            $smm_form->save();
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
                    $form_files->logo_form_id = $smm_form->id;
                    $form_files->form_code = 3;
                    $form_files->save();
                }
            }
            return redirect()->back()->with('success', 'SMM Form Created');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SmmForm  $smmForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmmForm $smmForm)
    {
        //
    }
}
