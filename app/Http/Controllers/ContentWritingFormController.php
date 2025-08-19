<?php

namespace App\Http\Controllers;

use App\Models\ContentWritingForm;
use Illuminate\Http\Request;
use Auth;
use App\Models\FormFiles;

class ContentWritingFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $content_form = ContentWritingForm::find($id);
        if($content_form->user_id == Auth::user()->id){
            return view('client.content', compact('content_form'));
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
     * @param  \App\Models\ContentWritingForm  $contentWritingForm
     * @return \Illuminate\Http\Response
     */
    public function show(ContentWritingForm $contentWritingForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContentWritingForm  $contentWritingForm
     * @return \Illuminate\Http\Response
     */
    public function edit(ContentWritingForm $contentWritingForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentWritingForm  $contentWritingForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $content_form = ContentWritingForm::find($id);
        if($content_form->user_id == Auth::user()->id){
            $content_form->company_name = $request->company_name;
            $content_form->company_details = $request->company_details;
            $content_form->company_industry = $request->company_industry;
            $content_form->company_reason = $request->company_reason;
            $content_form->company_products = $request->company_products;
            $content_form->short_description = $request->short_description;
            $content_form->mission_statement = $request->mission_statement;
            $content_form->keywords = $request->keywords;
            $content_form->competitor = $request->competitor;
            $content_form->company_business = $request->company_business;
            $content_form->customers_accomplish = $request->customers_accomplish;
            $content_form->company_sets = $request->company_sets;
            $content_form->existing_taglines = $request->existing_taglines;
            $content_form->save();
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
                    $form_files->logo_form_id = $content_form->id;
                    $form_files->form_code = 4;
                    $form_files->save();
                }
            }
            return redirect()->back()->with('success', 'Content Writing Form Created');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContentWritingForm  $contentWritingForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContentWritingForm $contentWritingForm)
    {
        //
    }
}
