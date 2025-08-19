<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskMemberList extends Model
{
    protected $table = 'task_member_list';

    use HasFactory;

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
