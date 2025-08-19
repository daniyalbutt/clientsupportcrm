<?php

namespace App\Http\Controllers;

use App\Models\SeoForm;
use Illuminate\Http\Request;
use Auth;
use App\Models\FormFiles;

class SeoFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $seo_form = SeoForm::find($id);
        if($seo_form->user_id == Auth::user()->id){
            return view('client.seo', compact('seo_form'));
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
     * @param  \App\Models\SeoForm  $seoForm
     * @return \Illuminate\Http\Response
     */
    public function show(SeoForm $seoForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SeoForm  $seoForm
     * @return \Illuminate\Http\Response
     */
    public function edit(SeoForm $seoForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SeoForm  $seoForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seo_form = SeoForm::find($id);
        if($seo_form->user_id == Auth::user()->id){
            $seo_form->company_name = $request->company_name;
            $seo_form->business_established = $request->business_established;
            $seo_form->original_owner = $request->original_owner;
            $seo_form->age_current_site = $request->age_current_site;
            $seo_form->top_goals = $request->top_goals;
            $seo_form->core_offer = $request->core_offer;
            $seo_form->average_order_value = $request->average_order_value;
            $seo_form->selling_per_month = $request->selling_per_month;
            $seo_form->client_lifetime_value = $request->client_lifetime_value;
            $seo_form->supplementary_offers = $request->supplementary_offers;
            $seo_form->getting_clients = $request->getting_clients;
            $seo_form->currently_spending = $request->currently_spending;
            $seo_form->monthly_visitors = $request->monthly_visitors;
            $seo_form->people_adding = $request->people_adding;
            $seo_form->monthly_financial = $request->monthly_financial;
            $seo_form->that_much = $request->that_much;
            $seo_form->specific_target = $request->specific_target;
            $seo_form->competitors = $request->competitors;
            $seo_form->third_party_marketing = $request->third_party_marketing;
            $seo_form->current_monthly_sales = $request->current_monthly_sales;
            $seo_form->current_monthly_revenue = $request->current_monthly_revenue;
            $seo_form->target_region = $request->target_region;
            $seo_form->looking_to_execute = $request->looking_to_execute;
            $seo_form->time_zone = $request->time_zone;
            $seo_form->save();
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
                    $form_files->logo_form_id = $seo_form->id;
                    $form_files->form_code = 5;
                    $form_files->save();
                }
            }
            return redirect()->back()->with('success', 'SEO Form Created');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SeoForm  $seoForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(SeoForm $seoForm)
    {
        //
    }
}
