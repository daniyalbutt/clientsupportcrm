<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['message', 'user_id', 'sender_id', 'task_id', 'role_id', 'client_id', 'created_at'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_name(){
        return $this->hasOne(Client::class, 'id', 'user_id');
    }   
    // sender_id = 0 for support
    // sender_id = 1 for client

    public function sended_client_files()
    {
        return $this->hasMany(ClientFile::class, 'message_id', 'id');
    }

    public function client_files(){
        return $this->hasMany(ClientFile::class, 'message_id', 'id');
    }
    
}
