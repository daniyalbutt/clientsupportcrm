<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadsData extends Model
{
    protected $fillable = [
        'lead_no','transaction_id', 'name', 'email', 'phone', 'source',
        'brand_id', 'invoice_id', 'client_id', 'call_log',
        'status', 'created_at', 'updated_at'
    ];

    public function brand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
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
