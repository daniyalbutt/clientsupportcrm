<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'last_name', 'email', 'contact', 'user_id', 'status', 'brand_id', 'assign_id'];

    public function brand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'client_id', 'id');
    }

    public function added_by(){
        return $this->hasOne(User::class, 'id', 'assign_id');
    }


    public function agent(){
        return $this->hasOne(User::class, 'id', 'assign_id');
    }

    public function invoice(){
        return $this->hasMany(Invoice::class)->orderBy('id', 'desc');
    }

    public function invoice_paid(){
        return $this->hasMany(Invoice::class)->where('payment_status', 2)->sum('amount');
    }

    public function invoice_unpaid(){
        return $this->hasMany(Invoice::class)->where('payment_status', 1)->sum('amount');
    }

    public function last_invoice_paid(){
        return $this->hasOne(Invoice::class)->where('payment_status', 2)->orderBy('id', 'desc');
    }
    
}
