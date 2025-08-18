<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
    

    public function get_status(){
        $status = $this->status;
        if($status == 0){
            return 'PENDING';
        }elseif($status == 1){
            return 'DECLINED';
        }elseif($status == 2){
            return 'SUCCESS';
        }
    }

    public function get_badge_status(){
        $status = $this->status;
        if($status == 0){
            return 'badge-warning';
        }elseif($status == 1){
            return 'badge-danger';
        }elseif($status == 2){
            return 'badge-success';
        }
    }
    public function get_badge_invoice_status(){
        $status = $this->status;
        if($status == 0){
            return 'badge text-bg-warning text-white';
        }elseif($status == 1){
            return 'badge text-bg-danger text-white';
        }elseif($status == 2){
            return 'badge text-bg-success text-white';
        }
    }

    public function merchants(){
        return $this->hasOne(Merchant::class, 'id', 'merchant');
    }

    public function currency(){
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
