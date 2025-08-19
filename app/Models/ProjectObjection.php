<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectObjection extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'support_reply', 'user_id', 'support_id', 'project_id', 'status', 'resolved_by'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}