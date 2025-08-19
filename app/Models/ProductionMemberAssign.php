<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionMemberAssign extends Model
{
    use HasFactory;

    public function assigned_by_user(){
        return $this->hasOne(User::class, 'id', 'assigned_by');
    }


    public function assigned_to_user(){
        return $this->hasOne(User::class, 'id', 'assigned_to');
    }

    public function get_status(){
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

    public function task(){
        return $this->hasOne(Task::class, 'id', 'task_id');
    }

    public function subtask(){
        return $this->hasOne(SubTask::class, 'id', 'subtask_id');
    }

    public function sub_tasks_message(){
        return $this->hasMany(ProductionMessage::class, 'production_member_assigns_id', 'id')->orderBy('id', 'desc');
    }
}
