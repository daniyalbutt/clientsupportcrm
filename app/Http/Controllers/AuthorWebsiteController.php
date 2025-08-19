<?php

namespace App\Http\Controllers;

use App\Models\AuthorWebsite;
use Illuminate\Http\Request;
use Auth;

class AuthorWebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\AuthorWebsite  $authorWebsite
     * @return \Illuminate\Http\Response
     */
    public function show(AuthorWebsite $authorWebsite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AuthorWebsite  $authorWebsite
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthorWebsite $authorWebsite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuthorWebsite  $authorWebsite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $author_website_form = AuthorWebsite::find($id);
        if($author_website_form->user_id == Auth::user()->id){
            $author_website_form->author_name = $request->author_name;
            $author_website_form->email_address = $request->email_address;
            $author_website_form->contact_number = $request->contact_number;
            $author_website_form->address = $request->address;
            $author_website_form->postal_code = $request->postal_code;
            $author_website_form->city = $request->city;
            $author_website_form->desired_domain = $request->desired_domain;
            $author_website_form->own_domain = $request->own_domain;
            $author_website_form->login_ip = $request->login_ip; 
            $author_website_form->brief_overview = $request->brief_overview;
            $author_website_form->purpose = json_encode($request->purpose);
            $author_website_form->purpose_other = $request->purpose_other;
            $author_website_form->user_perform = json_encode($request->user_perform);
            $author_website_form->user_perform_other = $request->user_perform_other;
            $author_website_form->feel_website = $request->feel_website;
            $author_website_form->have_logo = $request->have_logo;
            $author_website_form->specific_look = $request->specific_look;
            $author_website_form->competitor_website_link_1 = $request->competitor_website_link_1;
            $author_website_form->competitor_website_link_2 = $request->competitor_website_link_2;
            $author_website_form->competitor_website_link_3 = $request->competitor_website_link_3;
            $author_website_form->pages_sections = json_encode($request->pages_sections);
            $author_website_form->written_content = $request->written_content;
            $author_website_form->need_copywriting = $request->need_copywriting;
            $author_website_form->cms_site = $request->cms_site;
            $author_website_form->existing_site = $request->existing_site;
            $author_website_form->about_your_book = $request->about_your_book;
            $author_website_form->social_networks = $request->social_networks;
            $author_website_form->social_linked = $request->social_linked;
            $author_website_form->social_marketing = $request->social_marketing;
            $author_website_form->advertising_book = $request->advertising_book;
            $author_website_form->regular_updating = $request->regular_updating;
            $author_website_form->updating_yourself = $request->updating_yourself;
            $author_website_form->already_written = $request->already_written;
            $author_website_form->features_pages = $request->features_pages;
            $author_website_form->typical_homepage = json_encode($request->typical_homepage);
            $author_website_form->save();

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
                    $form_files->logo_form_id = $author_website_form->id;
                    $form_files->form_code = 6;
                    $form_files->save();
                }
            }
            return redirect()->back()->with('success', 'Author Website Form Created');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuthorWebsite  $authorWebsite
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthorWebsite $authorWebsite)
    {
        //
    }
}
