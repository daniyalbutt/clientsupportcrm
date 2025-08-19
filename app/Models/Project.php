<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'product_status', 'user_id', 'cost', 'client_id', 'brand_id', 'form_id', 'form_checker'];

    public function brand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
    
    public function client(){
        return $this->hasOne(User::class, 'id', 'client_id');
    }

    public function added_by(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function project_category(){
        return $this->belongsToMany(Category::class, 'category_project');
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
