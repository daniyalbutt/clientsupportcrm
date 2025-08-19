<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    protected $table = 'sub_task';
    protected $fillable = ['task_id', 'description', 'user_id', 'duedate', 'created_at', 'assign_id', 'status', 'sub_task_id'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function subtask_message(){
        return $this->hasMany(SubTask::class, 'sub_task_id');
    }

    public function assign_members(){
        return $this->hasMany(ProductionMemberAssign::class, 'subtask_id', 'id');
    }

    public function duedateChange(){
        return $this->hasOne(SubtasKDueDate::class, 'subtask_id', 'id')->orderBy('id', 'desc');
    }

}
