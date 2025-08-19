<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    const CLIENT_PAYMENT_STATUS = [
        1 => 'Unpaid',
        2 => 'Paid',
        3 => 'Partially Paid',
    ];

    const STATUS_COLOR = [
        0 => 'warning',
        1 => 'danger',
        2 => 'success',
        3 => 'info',
        4 => 'danger',
        5 => 'danger',
    ];

    const PAYMENT_STATUS = [
        0 => 'Drafted',
        1 => 'Unpaid',
        2 => 'Paid',
        3 => 'Partially Paid',
        4 => 'Cancelled',
        5 => 'Declined',
    ];

    public function sale(){
        return $this->hasOne(User::class, 'id', 'sales_agent_id');
    }

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function brands(){
        return $this->hasOne(Brand::class, 'id', 'brand');
    }

    public function currency_show(){
        return $this->hasOne(Currency::class, 'id', 'currency');
    }

    public function payment_type_show(){
        if($this->payment_type == 0){
            return "One-Time Charge";
        }else{
            return "Three-Time Charge";
        }
    }

    public function services($id){
        return Service::where('id', $id)->first();
    }

    public function merchant(){
        return $this->hasOne(Merchant::class, 'id', 'merchant_id');
    }

    public function invoice_logs(){
        return $this->hasOne(InvoiceLogs::class, 'invoice_id', 'id');
    }
}
