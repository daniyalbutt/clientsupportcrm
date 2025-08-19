<?php

namespace App\Http\Controllers;
use App\Models\SubTask;
use App\Models\Task;
use App\Models\User;
use App\Models\SubtasKDueDate;
use App\Models\ProductionMessage;
use Illuminate\Http\Request;
use App\Notifications\TaskNotification;
use App\Notifications\SubTaskNotification;
use Auth;
use App\Models\ProductionMemberAssign;
use Pusher\Pusher;

class SubTaskController extends Controller
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
            'description' => 'required',
            'duedate' => 'required',
        ]);
        $request->request->add(['user_id' => auth()->user()->id]);
        $sub_task = SubTask::create($request->all());
        Task::where('id', $request->input('task_id'))
            ->update(['status' => 1]);
        $role_name = 'Sale Person';
        if($sub_task->user->is_employee == 1){
            $role_name = 'Production Member';
        }
        $duedate = date('d M, Y', strtotime($sub_task->duedate));
        $created_at = $sub_task->created_at->format('d-M-y h:i:s a');
        return response()->json(['success' => 'Sub Task created Successfully.', 'data' => SubTask::find($sub_task->id), 'user_name' => auth()->user()->name, 'role_name' => $role_name, 'duedate' => $duedate, 'created_at' => $created_at]);
    }

    public function producionSubtask(Request $request){
        $task = Task::find($request->task_id);
        $user = $task->user;
        $request->validate([
            'description' => 'required',
        ]);
        $request->request->add(['user_id' => auth()->user()->id]);
        $sub_task = SubTask::create($request->all());
        $assignData = [
            'id' => Auth()->user()->id,
            'task_id' => $task->id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => \Illuminate\Support\Str::limit(preg_replace("/<\/?a( [^>]*)?>/i", "", strip_tags($request->description)), 25, $end='...'),
            'details' => '',
        ];
        $created_at = $sub_task->created_at->format('d M, y | h:i A');

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        $pusher->trigger('private.' . $user->id, 'send-task-notifiction', [
            'title' => 'Task Updated',
            'message' => $task->projects->name . ' updated by ' . Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'image' => 'new-task.png',
            'link' => route('support.task.show', ['id' => $task->id])
        ]);

        $user->notify(new TaskNotification($assignData));
        return response()->json(['success' => 'Sub Task created Successfully.', 'data' => SubTask::find($sub_task->id), 'user_name' => auth()->user()->name . ' ' . auth()->user()->last_name, 'created_at' => $created_at]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function producionSubtaskAssign(Request $request){
        $request->validate([
            'sub_task' => 'required',            
        ]);

        $subtask = SubTask::Find($request->sub_task);

        foreach($request->members as $key => $value){
            if($value['assign_sub_task_user_id'] != ''){
                $assignMember = new ProductionMemberAssign();
                $assignMember->task_id = $subtask->task->id;
                $assignMember->subtask_id = $subtask->id;
                $assignMember->assigned_by = Auth::user()->id;
                $assignMember->assigned_to = $value['assign_sub_task_user_id'];
                $assignMember->comments = $value['comment'];
                $assignMember->duadate = $value['duadate'];
                $assignMember->status = 0;
                $assignMember->save();
                $assignData = [
                    'id' => $assignMember->id,
                    'task_id' => $subtask->task->id,
                    'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
                    'text' => $subtask->task->projects->name . '- Task Assigned',
                    'details' => \Illuminate\Support\Str::limit(preg_replace("/<\/?a( [^>]*)?>/i", "", strip_tags($subtask->description)), 50, $end='...')
                ];
                $user = User::find($value['assign_sub_task_user_id']);
                $user->notify(new TaskNotification($assignData));
            }
        }
        return redirect()->back()->with('success', 'Sub Task Assigned');
    }

    public function memberSubtaskUpdate($id, Request $request){
        $value = $request->value;
        $task = ProductionMemberAssign::find($id);
        $task->status = $value;
        $task->save();
        $status = '';
        if($value == 0){
            $status = 'Open';
        }else if($value == 1){
            $status = 'Re Open';
        }else if($value == 2){
            $status = 'Hold';
        }else if($value == 3){
            $status = 'Completed';
        }else if($value == 4){
            $status = 'In Progress';
        }else if($value == 5){
            $status = 'Sent for Approval';
        }else if($value == 6){
            $status = 'Incomplete Brief';
        }

        $description = $task->task->projects->name . " Marked as " . $status;
        $assignData = [
            'id' => Auth()->user()->id,
            'task_id' => $task->id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => $description,
            'details' => 'Updated by '. Auth()->user()->name . ' ' . Auth()->user()->last_name,
        ];
        $user = User::find($task->assigned_by);
        $user->notify(new SubTaskNotification($assignData));
        return response()->json(['status' => true, 'message' => 'Status Updated Successfully']);

    }

    public function producionSubtaskAssigned(Request $request){
        
        $category_id = Auth::user()->category_list();
        
        if(($request->category == null) || ($request->category == 0)){
            $subtasks = ProductionMemberAssign::whereHas('task', function ($query) use ($category_id){
                return $query->whereIn('category_id', $category_id);
            });
        }else{
            $cat_id = $request->category;
            $subtasks = ProductionMemberAssign::whereHas('task', function ($query) use ($cat_id){
                return $query->where('category_id', '=', $cat_id);
            });
        }

        if($request->status != null){
            $task = $subtasks->whereIn('status', $request->status);
        }else{
            $task = $subtasks->where('status', 0);
        }

        $subtasks = $subtasks->get();

        // $category_id = array();
        // foreach(Auth()->user()->category as $category){
        //     array_push($category_id, $category->id);
        // }
        // $subtasks = SubTask::whereNotNull('assign_id')->whereHas('task', function ($query) use ($category_id){
        //     return $query->where('category_id', '=', $category_id);
        // })->get();
        return view('production.subtask.index', compact('subtasks'));
    }

    public function memberSubTask($id, $notify = null){
        $subtask = ProductionMemberAssign::find($id);
        
        if($subtask->assigned_to == Auth::user()->id){
            if($notify != null){
                $Notification = Auth::user()->Notifications->find($notify);
                if($Notification){
                    $Notification->markAsRead();
                }   
            }
            return view('member.task.show', compact('subtask'));
        }else{
            redirect()->back();
        }
    }

    public function productionMemberSubtaskStore(Request $request){
        $request->validate([
            'production_member_assigns_id' => 'required',
        ]);
        $data = ProductionMemberAssign::find($request->production_member_assigns_id);
        $message = new ProductionMessage();
        $message->production_member_assigns_id = $data->id;
        $message->messages = $request->description;
        $message->user_id = Auth::user()->id;
        $message->save();
        $description = $data->task->projects->name . " - Sub Task Updated";
        $assignData = [
            'id' => Auth()->user()->id,
            'task_id' => $data->id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => $description,
            'details' => 'Updated by '. Auth()->user()->name . ' ' . Auth()->user()->last_name,
        ];
        $user = User::find($data->assigned_to);
        $user->notify(new SubTaskNotification($assignData));
        return response()->json(['success' => 'Sub Task Updateed Successfully.', 'data' => ProductionMessage::find($message->id), 'user_name' => auth()->user()->name . '' . auth()->user()->last_name, 'created_at' => $message->created_at]);

    }

    public function memberSubtaskStore(Request $request){
        $request->validate([
            'production_member_assigns_id' => 'required',
        ]);

        $data = ProductionMemberAssign::find($request->production_member_assigns_id);

        $message = new ProductionMessage();
        $message->production_member_assigns_id = $data->id;
        $message->messages = $request->description;
        $message->user_id = Auth::user()->id;
        $message->save();

        $description = $data->task->projects->name . " - Sub Task Updated";

        $assignData = [
            'id' => Auth()->user()->id,
            'task_id' => $data->id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => $description,
            'details' => 'Updated by '. Auth()->user()->name . ' ' . Auth()->user()->last_name,
        ];

        $user = User::find($data->assigned_by);
        $user->notify(new SubTaskNotification($assignData));

        return response()->json(['success' => 'Task Updateed Successfully.', 'data' => ProductionMessage::find($message->id), 'user_name' => auth()->user()->name . '' . auth()->user()->last_name, 'created_at' => $message->created_at]);
    }


    public function productionChangeDuedate(Request $request){
        $request->validate([
            'duedate' => 'required',
            'subtask_id' => 'required',
        ]);
        $subtask = SubTask::find($request->subtask_id);

        $data = new SubtasKDueDate();
        $data->subtask_id = $request->subtask_id;
        $data->duadate = $subtask->duedate;
        $data->user_id = Auth::user()->id;
        $data->save();

        $subtask->duedate = $request->duedate;
        $subtask->save();

        $description = $subtask->task->projects->name . " - Due Date Updated";

        $assignData = [
            'id' => Auth()->user()->id,
            'task_id' => $subtask->task->id,
            'name' => Auth()->user()->name . ' ' . Auth()->user()->last_name,
            'text' => $description,
            'details' => 'Updated by '. Auth()->user()->name . ' ' . Auth()->user()->last_name
        ];

        $user = User::find($data->user_id);
        $user->notify(new TaskNotification($assignData));
        return response()->json(['success' => true, 'data' => 'Due Date Updated Updateed Successfully.', 'duedate' => date('d M, y', strtotime($request->duedate)), 'id' => $request->subtask_id]);

    }
}
