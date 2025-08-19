<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DateTime;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = ['project_id', 'category_id', 'description', 'status', 'user_id', 'brand_id', 'created_at', 'duedate', 'notes'];

    public function projects(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function brand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subtaskDueDate(){
        return $this->hasOne(SubTask::class, 'task_id', 'id')->whereNotNull('duedate')->orderBy('id', 'desc');
    }

    public function project_status(){
        // 0 for open
        // 1 for re_open
        // 2 for hold
        // 3 for completed
        // 4 for in_progress
        $status = $this->status;
        if($status == 0){
            return "<button class='btn btn-danger btn-sm'>Open</button>";
        }else if($status == 1){
            return "<button class='btn btn-primary btn-sm'>Re Open</button>";
        }else if($status == 2){
            return "<button class='btn btn-info btn-sm'>Hold</button>";
        }else if($status == 3){
            return "<button class='btn btn-success btn-sm'>Completed</button>";
        }else if($status == 4){
            return "<button class='btn btn-warning btn-sm'>In Progress</button>";
        }else if($status == 5){
            return "<button class='btn btn-info btn-sm'>Sent for Approval</button>";
        }else if($status == 6){
            return "<button class='btn btn-warning btn-sm'>Incomplete Brief</button>";
        }
    }

    public function client_files(){
        return $this->hasMany(ClientFile::class, 'task_id', 'id')->orderBy('id', 'desc')->where('message_id', 0);
    }

    public function client_files_support(){
        return $this->hasMany(ClientFile::class, 'task_id', 'id')->whereIn('production_check', [1,2])->where('message_id', 0)->orderBy('id', 'desc');
    }

    public function client_files_to_shown(){
        return $this->hasMany(ClientFile::class, 'task_id', 'id')->where('show_to_client', Auth::user()->id)->orderBy('id', 'desc');
    }

    public function count_files(){
        return $this->hasMany(ClientFile::class, 'task_id', 'id')->count();
    }

    public function sub_tasks(){
        return $this->hasMany(SubTask::class, 'task_id', 'id')->where('sub_task_id', 0)->orderBy('id', 'desc');
    }

    public function messages(){
        return $this->hasMany(Message::class, 'task_id', 'id')->orderBy('id', 'desc');
    }

    public function getDueDate(){
        $date_string = '';
        $date_now = new DateTime();
        if(count($this->sub_tasks) == 0){
            $date2 = new DateTime(date('d-m-Y', strtotime($this->duedate)));
            $date_string = $this->duedate;
        }else{
            $date_string = "";
            $date2 = "";
            if($this->getSubtaskDueDate != null){
                $date2 = new DateTime(date('d-m-Y', strtotime($this->getSubtaskDueDate->duedate)));
                $date_string = $this->getSubtaskDueDate->duedate;
            }else{
                $date2 = new DateTime(date('d-m-Y', strtotime($this->duedate)));
                $date_string = $this->duedate;
            }
            
            // if($this->subtaskDueDate != null){
            //     if($this->subtaskDueDate->duedateChange != null){
            //         $date2 = new DateTime(date('d-m-Y', strtotime($this->subtaskDueDate->duedateChange->duadate)));
            //         $date_string = $this->subtaskDueDate->duedateChange->duadate;
            //     }else{
            //         $date2 = new DateTime(date('d-m-Y', strtotime($this->subtaskDueDate->duedate)));
            //         $date_string = $this->subtaskDueDate->duedate;
            //     }
            // }else{
            //     $date2 = new DateTime(date('d-m-Y', strtotime($this->duedate)));
            //     $date_string = $this->duedate;
            // }
        }
        
        $button = '';
        if ($date_now > $date2){
            $button.= '<button class="btn btn-danger btn-sm">';
        }else{
            $button.= '<button class="btn btn-success btn-sm">';
        }

        $button .= date('d-m-Y', strtotime($date_string)) . '</button>';
        return $button;
    }
    public function todaySubtask(){
  
        return $this->hasMany(SubTask::class, 'task_id', 'id')->whereNotNull('duedate')->where('sub_task_id', 0)->where('duedate', date('Y-m-d'));
    }

    public function getSubtaskDueDate(){
        return $this->hasOne(SubTask::class, 'task_id', 'id')->whereNotNull('duedate')->where('sub_task_id', 0)->orderBy('duedate', 'desc');
    }

    public function member_list(){
        return $this->hasMany(TaskMemberList::class, 'task_id', 'id');
    }
}
