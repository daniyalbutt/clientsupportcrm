<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'brand_name'];
    
    public function logo_brief(){
        return $this->hasMany(LogoBrief::class, 'client_id');
    }

    public function brand(){
        return $this->hasOne(Brand::class, 'id', 'brand_name');
    }

    public function payment(){
        return $this->hasMany(Payment::class);
    }
}
