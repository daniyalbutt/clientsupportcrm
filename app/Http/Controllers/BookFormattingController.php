<?php

namespace App\Http\Controllers;

use App\Models\BookFormatting;
use Illuminate\Http\Request;
use Auth;
use App\Models\FormFiles;

class BookFormattingController extends Controller
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
     * @param  \App\Models\BookFormatting  $bookFormatting
     * @return \Illuminate\Http\Response
     */
    public function show(BookFormatting $bookFormatting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookFormatting  $bookFormatting
     * @return \Illuminate\Http\Response
     */
    public function edit(BookFormatting $bookFormatting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookFormatting  $bookFormatting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book_formatting_form = BookFormatting::find($id);
        if($book_formatting_form->user_id == Auth::user()->id){
            $book_formatting_form->book_title = $request->book_title;
            $book_formatting_form->book_subtitle = $request->book_subtitle;
            $book_formatting_form->author_name = $request->author_name;
            $book_formatting_form->contributors = $request->contributors;
            $book_formatting_form->publish_your_book = json_encode($request->publish_your_book);
            $book_formatting_form->book_formatted = json_encode($request->book_formatted);
            $book_formatting_form->trim_size = $request->trim_size;
            $book_formatting_form->other_trim_size = $request->other_trim_size;
            $book_formatting_form->additional_instructions = $request->additional_instructions; 
            $book_formatting_form->save();
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
                    $form_files->logo_form_id = $book_formatting_form->id;
                    $form_files->form_code = 6;
                    $form_files->save();
                }
            }
            return redirect()->back()->with('success', 'Book Formatting & Publishing Form Created');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookFormatting  $bookFormatting
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookFormatting $bookFormatting)
    {
        //
    }
}
