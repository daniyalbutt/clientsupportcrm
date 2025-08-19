<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $table = 'merchants';
    protected $fillable = ['name', 'public_key', 'secret_key', 'status', 'login_id', 'is_authorized', 'live_mode', 'hold_merchant'];

    public function client_authorize_customers($client_id){
        return $this->hasMany(ClientAuthorizeCustomer::class)->where('client_id', $client_id);
    }

    public function get_merchant_name(){
        $merchant_id = $this->is_authorized;
        if($merchant_id == 1){
            return 'Stripe';
        }elseif($merchant_id == 2){
            return 'Authorize.net';
        }elseif($merchant_id == 3){
            return 'Converge Pay';
        }elseif($merchant_id == 4){
            return 'Thrifty Payments Inc.';
        }elseif($merchant_id == 5){
            return 'Nexio Pay';
        }elseif($merchant_id == 6){
            return 'PayPal';
        }elseif($merchant_id == 7){
            return 'Maverick';
        }elseif($merchant_id == 8){
            return 'Square';
        }elseif($merchant_id == 9){
            return 'NMI';
        }
    }

    // LIVE_MODE
    // 0 = SANDBOX
    // 1 = PRODUCTION

    // is_authorized
    // 1 = Stripe
    // 2 = Authorize.net
    // 3 = Converge Pay
    // 4 = Thrifty Payments Inc.

    public function hold_merchant(){
        if($this->hold_merchant == 1){
            return '<span class="badge badge-danger">HOLD</span>';
        }else{
            return '';
        }
    }

    public function brands(){
        return $this->belongsToMany(Brand::class);
    }
}
