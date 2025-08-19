<?php

namespace App\Http\Controllers;

use App\Models\BookMarketing;
use Illuminate\Http\Request;
use App\Models\FormFiles;
use Auth;

class BookMarketingController extends Controller
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
     * @param  \App\Models\BookCover  $bookCover
     * @return \Illuminate\Http\Response
     */
    public function show(BookMarketing $bookCover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookCover  $bookCover
     * @return \Illuminate\Http\Response
     */
    public function edit(BookMarketing $bookCover)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookCover  $bookCover
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bookmarketing_form = BookMarketing::find($id);
        if($bookmarketing_form->user_id == Auth::user()->id){
            $bookmarketing_form->title = $request->title;
            $bookmarketing_form->behind_title = $request->behind_title;
            $bookmarketing_form->key_message = $request->key_message;
            $bookmarketing_form->giveaways = $request->giveaways;
            $bookmarketing_form->target_audience = $request->target_audience;
            $bookmarketing_form->launched = $request->launched;
            $bookmarketing_form->published_book = $request->published_book;
            $bookmarketing_form->sold_book = $request->sold_book;
            $bookmarketing_form->marketing = $request->marketing;
            $bookmarketing_form->author_name = $request->author_name;
            $bookmarketing_form->social_pages = $request->social_pages;
            $bookmarketing_form->basics = $request->basics;
            $bookmarketing_form->selling_point = $request->selling_point;
            $bookmarketing_form->keywords = $request->keywords;
            $bookmarketing_form->goals = $request->goals;
            $bookmarketing_form->book_stores = $request->book_stores;
            $bookmarketing_form->approach = $request->approach;
            $bookmarketing_form->motto = $request->motto;
            $bookmarketing_form->price_point = $request->price_point;
            $bookmarketing_form->number_pages = $request->number_pages;
            $bookmarketing_form->paper_back = $request->paper_back;
            $bookmarketing_form->advantages = $request->advantages;
            $bookmarketing_form->existing_website = $request->existing_website;
            $bookmarketing_form->call_action = $request->call_action;
            $bookmarketing_form->web_pages = $request->web_pages;
            $bookmarketing_form->achieve_goals = $request->achieve_goals;
            $bookmarketing_form->competitors = $request->competitors;
            $bookmarketing_form->relevant_information = $request->relevant_information;
            $bookmarketing_form->save();

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
                    $form_files->logo_form_id = $bookmarketing_form->id;
                    $form_files->form_code = 6;
                    $form_files->save();
                }
            }
            return redirect()->back()->with('success', 'Book Marketing Form Created');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookCover  $bookCover
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookCover $bookCover)
    {
        //
    }
}
