<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'create_categories';

    protected $fillable = ['name', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
    
}
