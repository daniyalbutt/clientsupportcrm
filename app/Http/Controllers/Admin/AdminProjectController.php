<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Category;
use App\Models\User;
use Auth;
use DB;

class AdminProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = new Project();
        $data = $data->select('id', 'name', 'status', 'product_status', 'user_id', 'client_id', 'brand_id');
        if($request->brand != null){
            $data = $data->where('brand_id', $request->brand);
        }
        if($request->client != null){
            $name = $request->client;
            $data = $data->whereHas('client', function ($query) use ($name){
                return $query->where('name', 'LIKE', "%{$name}%")->orWhere('last_name', 'LIKE', "%{$name}%")->orWhere('email', 'LIKE', "%{$name}%");
            });
        }
        if($request->user != null){
            $name = $request->user;
            $data = $data->whereHas('added_by', function ($query) use ($name){
                return $query->where('name', 'LIKE', "%{$name}%")->orWhere('last_name', 'LIKE', "%{$name}%")->orWhere('email', 'LIKE', "%{$name}%");
            });
        }
        $data = $data->orderBy('id', 'desc')->paginate(20);
        $brands = DB::table('brands')->select('id', 'name')->get();
        $categorys = DB::table('create_categories')->select('id', 'name')->get();
        return view('admin.project.index', compact('data', 'brands', 'categorys'));
    }

    public function indexManager()
    {
        $data = Project::whereIn('brand_id', Auth()->user()->brand_list())->get();
        $brands = Brand::whereIn('id', Auth()->user()->brand_list())->get();
        $clients = User::where('is_employee', 3)->whereHas('client', function ($query){
                        return $query->whereIn('brand_id', Auth()->user()->brand_list());
                    })->get();
        $users = User::where('is_employee', 0)->whereHas('brands', function ($query){
                    return $query->whereIn('brand_id', Auth()->user()->brand_list());
                })->get();
        $categorys = Category::all();
        return view('manager.project.index', compact('data', 'brands', 'clients', 'users', 'categorys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.project.create');
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
            'last_name' => 'required',
            'email' => 'required|unique:projects,email',
            'contact' => 'required',
            'status' => 'required',
            'brand_id' => 'required',
        ]);
        $request->request->add(['user_id' => auth()->user()->id]);
        Project::create($request->all());
        return redirect()->back()->with('success', 'Project created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */

    public function showNotification(Project $project, $id){
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        $notification->markAsRead();
        return view('admin.project.show', compact('project'));
    }

    public function show(Project $project)
    {
        return view('admin.project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function indexEdit($id)
    {
        $data = Project::find($id);
        $clients = Client::where('status', 1)->whereIn('brand_id', Auth()->user()->brand_list())->get();
        $category = Category::where('status', 1)->get();
        return view('manager.project.edit', compact('data', 'category', 'clients'));
    }

    public function edit($id)
    {
        $data = Project::find($id);
        $clients = Client::where('status', 1)->get();
        $category = Category::where('status', 1)->get();
        return view('admin.project.edit', compact('data', 'category', 'clients'));
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
            'last_name' => 'required',
            'email' => 'required|unique:users,email,'.$project->id,
            'contact' => 'required',
            'status' => 'required',
        ]);
        $request->request->add(['brand_id' => auth()->user()->brand_id]);
        $project->update($request->all());
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

    public function paymentLink($id){
        $user = Project::find($id);
        $brand = Brand::whereIn('id', Auth()->user()->brand_list())->get();;
        return view('sale.payment.create', compact('user', 'brand'));
    }
}
