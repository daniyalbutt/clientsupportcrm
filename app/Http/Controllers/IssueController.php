<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Client;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
use DateTimeZone;
use Pion\Laravel\ChunkUpload\Exceptions\UploadFailedException;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class IssueController extends Controller
{

    public function getTickets()
    {
        $issues = Issue::with('brands', 'user', 'ticket_user','client')->get();
        $brands = Brand::all();

        return view('admin.issue.index', compact('issues', 'brands'));
    }

    public function create()
    {
        return view('issues.create');
    }

    public function generateTicket(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'brand' => 'required|integer',
            'user_id' => 'required|array',
            'client_id' => 'required|integer',
            'level' => 'required|string',
            'status' => 'required|string',
        ]);

        // ISSUES LISTING AND FORMATTING--
        $issues = [
            'deliverable',
            'agent_related',
            'production_related',
            'communication',
            'customer_legal',
            'service_delivery',
            'operational',
            'special_case',
            'financial',
            'qa_varified'
        ];

        $filter_issues = [];
    
        foreach ($issues as $key) {
            if ($request->has($key)) {
                $filter_issues[$key] = $request->input($key);
            }
        }

        // FILE DATA EXTRACTION--
        $fileDataArray = json_decode($request->input('fileData'), true);

        $fileNames = '';
        $fileKeys = '';

        if (is_array($fileDataArray) && count($fileDataArray) > 0) {
            foreach ($fileDataArray as $file) {
                $fileNames = $file['name'] ?? null;
                $fileKeys = $file['file'] ?? null;
            }
        }

        // GENERATE TICKET--
        $issue = new Issue();
        $issue->ticket_no = 'Ticket# '.rand(1000, 9999);
        $issue->brand_id = $request->brand;
        $issue->user_id = json_encode($request->user_id);
        $issue->client_id = $request->client_id;
        $issue->level = $request->level;
        $issue->status = $request->status;
        $issue->description = $request->description;
        $issue->issue = json_encode($filter_issues);
        $issue->generated_by = Auth::user()->id;
        $issue->file_path = isset($fileDataArray) ? $fileDataArray[0]['file'] : null;
        $issue->filename = isset($fileDataArray) ? $fileDataArray[0]['name'] : null;
        $issue->save();


        return redirect()->back()->with('success', 'Issue reported successfully.');
    }

    public function getUserBrands(Request $request)
    {
        $brand_id = $request->brand_id;
        $users = User::select('id', 'name', 'last_name','is_employee')->whereHas('brands', function ($query) use ($brand_id) {
                    return $query->where('brand_id', $brand_id);
                })->where('is_employee',4)->orWhere('is_employee',6)->get();
        
        $clients = Client::where('brand_id', $brand_id)->get();

        return response()->json(['success' => true , 'data' => $users , 'client' => $clients ]);
    }

    protected function createFilename(UploadedFile $file){
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(".".$extension, "", $file->getClientOriginalName());
        $mytime = Carbon::now();
        $set_time = str_replace(' ', '-', $mytime->toDateTimeString());
        $filename .= "_" . $set_time . "." . $extension;
        return $filename;
    }

    public function sendTicketChunks(Request $request)
    {
        // dd($request->file->getSize());
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        $save = $receiver->receive();
        if ($save->isFinished()) {
            $qa_id = Auth::user()->id;
            $set_email = strtolower(Auth::user()->email);
            return $this->saveFileToS3($save->getFile(), $set_email);
        }

        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    protected function saveFileToS3($file, $email){

        $fileName = $this->createFilename($file);
        $file_actual_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $disk = Storage::disk('wasabi');
        $data = $disk->putFileAs('tickets/'.$email, $file, $fileName);
        $disk->setVisibility($data, 'public');
        $mime = str_replace('/', '-', $file->getMimeType());
        unlink($file->getPathname());
        
        return response()->json([
            'path' => $disk,
            'name' => $fileName,
            'mime_type' =>$mime,
            'file' => $data,
            'actual_name' => $file_actual_name
        ]);
    }

    public function edit($id)
    {
        $issue = Issue::findOrFail($id);
        $brands = Brand::all();
        $agents = User::all();
        $clients = Client::all();

        return view('admin.issue.edit', compact('issue', 'brands', 'agents', 'clients'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            'brand' => 'required',
            'user_id' => 'required|array',
            'client_id' => 'required',
            'level' => 'required',
            'status' => 'required',
        ]);


        // FILE DATA EXTRACTION--
        $fileDataArray = json_decode($request->input('fileData'), true);

        $fileNames = '';
        $fileKeys = '';

        if (is_array($fileDataArray) && count($fileDataArray) > 0) {
            foreach ($fileDataArray as $file) {
                $fileNames = $file['name'] ?? null;
                $fileKeys = $file['file'] ?? null;
            }
        }

        // ISSUES LISTING AND FORMATTING--
        $issues = [
            'deliverable',
            'agent_related',
            'production_related',
            'communication',
            'customer_legal',
            'service_delivery',
            'operational',
            'special_case',
            'financial',
            'qa_varified'
        ];

        $filter_issues = [];
    
        foreach ($issues as $key) {
            if ($request->has($key)) {
                $filter_issues[$key] = $request->input($key);
            }
        }

        // UPDATE TICKET--
        $issue = Issue::findOrFail($id);
        $issue->brand_id = $request->brand;
        $issue->user_id = json_encode($request->user_id);
        $issue->client_id = $request->client_id;
        $issue->level = $request->level;
        $issue->status = $request->status;
        $issue->description = $request->description;
        $issue->issue = json_encode($filter_issues);
        if(isset($fileDataArray[0]['file'])){
            $issue->file_path = $fileDataArray[0]['file'];
            $issue->filename = $fileDataArray[0]['name'];
        }
        $issue->save();

        return redirect()->route('admin.tickets')->with('success', 'Issue updated successfully');
    }

    public function show($id){
        $issue = Issue::with('brands', 'user', 'ticket_user','client')->findOrFail($id);
        $brands = Brand::all();
        $agents = User::all();
        $clients = Client::all();

        return view('admin.issue.show', compact('issue', 'brands', 'agents', 'clients'));
    }
    public function getTicketsSupport(){
        $issues = Issue::with('brands', 'user', 'ticket_user','client')->whereJsonContains('user_id', (string) Auth::user()->id)->get();
        $brands = Brand::all();

        return view('support.issue.index', compact('issues', 'brands'));
    }

    public function showTicketSupport($id){
        $issue = Issue::with('brands', 'user', 'ticket_user','client')->whereJsonContains('user_id', (string) Auth::user()->id)->findOrFail($id);
        $brands = Brand::all();
        $agents = User::all();
        $clients = Client::all();

        return view('support.issue.show', compact('issue', 'brands', 'agents', 'clients'));
    }

    public function updateTicketStatus(Request $request){
        $issue = Issue::findOrFail($request->ticket_id);
        $issue->status = 'In Progress';
        $issue->save();

        return response()->json(['status' => true, 'message' => 'Ticket set to In Progress successfully']);
    }

    public function getTicketsSale(){
        $issues = Issue::with('brands', 'user', 'ticket_user','client')->whereJsonContains('user_id', (string) Auth::user()->id)->get();
        $brands = Brand::all();

        return view('sale.issue.index', compact('issues', 'brands'));
    }

    public function showTicketSale($id){
        $issue = Issue::with('brands', 'user', 'ticket_user','client')->whereJsonContains('user_id', (string) Auth::user()->id)->findOrFail($id);
        $brands = Brand::all();
        $agents = User::all();
        $clients = Client::all();

        return view('sale.issue.show', compact('issue', 'brands', 'agents', 'clients'));
    }

    public function getTicketsManager(){
        $issues = Issue::with('brands', 'user', 'ticket_user','client')->whereJsonContains('user_id', (string) Auth::user()->id)->get();
        $brands = Brand::all();

        return view('manager.issue.index', compact('issues', 'brands'));
    }

    public function showTicketManager($id){
        $issue = Issue::with('brands', 'user', 'ticket_user','client')->whereJsonContains('user_id', (string) Auth::user()->id)->findOrFail($id);
        $brands = Brand::all();
        $agents = User::all();
        $clients = Client::all();

        return view('manager.issue.show', compact('issue', 'brands', 'agents', 'clients'));
    }
}
