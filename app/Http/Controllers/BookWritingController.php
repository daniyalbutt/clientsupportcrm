<?php

namespace App\Http\Controllers;

use App\Models\BookWriting;
use Illuminate\Http\Request;
use Auth;

class BookWritingController extends Controller
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
     * @param  \App\Models\BookWriting  $bookWriting
     * @return \Illuminate\Http\Response
     */
    public function show(BookWriting $bookWriting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookWriting  $bookWriting
     * @return \Illuminate\Http\Response
     */
    public function edit(BookWriting $bookWriting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookWriting  $bookWriting
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $book_writing_form = BookWriting::find($id);
        if($book_writing_form->user_id == Auth::user()->id){
            $book_writing_form->book_title = $request->book_title;
            $book_writing_form->genre_book = $request->genre_book;
            $book_writing_form->brief_summary = $request->brief_summary;
            $book_writing_form->purpose = $request->purpose;
            $book_writing_form->target_audience = $request->target_audience;
            $book_writing_form->desired_length = $request->desired_length;
            $book_writing_form->specific_characters = $request->specific_characters;
            $book_writing_form->specific_themes = $request->specific_themes;
            $book_writing_form->writing_style = $request->writing_style; 
            $book_writing_form->specific_tone = $request->specific_tone;
            $book_writing_form->existing_materials = $request->existing_materials;
            $book_writing_form->existing_books = $request->existing_books;
            $book_writing_form->specific_deadlines = $request->specific_deadlines;
            $book_writing_form->specific_instructions = $request->specific_instructions;
            $book_writing_form->research = $request->research;
            $book_writing_form->specific_chapter = $request->specific_chapter;
            $book_writing_form->save();
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
                    $form_files->logo_form_id = $book_writing_form->id;
                    $form_files->form_code = 6;
                    $form_files->save();
                }
            }
            return redirect()->back()->with('success', 'Book Writing Form Created');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookWriting  $bookWriting
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookWriting $bookWriting)
    {
        //
    }
}
