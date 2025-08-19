<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use App\Models\Category;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::whereIn('brand_id', Auth()->user()->brand_list())->get();
        return view('sale.project.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::where('status', 1)->whereIn('brand_id', Auth()->user()->brand_list())->get();
        $category = Category::where('status', 1)->get();
        return view('sale.project.create', compact('clients', 'category'));
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
            'client' => 'required',
            'description' => 'required',
            'status' => 'required',
            'category' => 'required',
        ]);
        $get_client = Client::where('id', $request->input('client'))->first();
        $request->request->add(['brand_id' => $get_client->brand->id]);
        $request->request->add(['client_id' => $request->input('client')]);
        $request->request->add(['user_id' => auth()->user()->id]);
        $product = Project::create($request->all());
        $category = $request->input('category');
        for($i = 0; $i < count($category); $i++){
            $project_category = new ProjectCategory();
            $project_category->project_id = $product->id;
            $project_category->category_id = $category[$i];
            $project_category->save();
        }
        return redirect()->back()->with('success', 'Project created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients = Client::where('status', 1)->whereIn('brand_id', Auth()->user()->brand_list())->get();
        $data = Project::whereIn('brand_id', Auth()->user()->brand_list())->where('id', $id)->first();
        $category = Category::where('status', 1)->get();
        return view('sale.project.edit', compact('data', 'category', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required',
            'client' => 'required',
            'description' => 'required',
            'status' => 'required',
            'category' => 'required',
        ]);
        $get_client = Client::where('id', $request->input('client'))->first();
        $request->request->add(['brand_id' => $get_client->brand->id]);
        $request->request->add(['client_id' => $request->input('client')]);
        $request->request->add(['user_id' => auth()->user()->id]);
        $project->update($request->all());
        $category = $request->input('category');
        $project->project_category()->sync($category);
        return redirect()->back()->with('success', 'Project Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
