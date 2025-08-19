<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ClientAuthorizeCustomer extends Model
{
    use HasFactory;

    public function client_authorizes(){        
        return $this->hasMany(ClientAuthorize::class);
    }

    public function get_ccnumber(){
        $options = explode('&', $this->authorize_customer_profile_id);
        $ccnumber = explode('ccnumber=', $options[0]);
        return Crypt::decryptString($ccnumber[1]);
    }

    public function get_ccexp(){
        $options = explode('&', $this->authorize_customer_profile_id);
        $ccexp = explode('ccexp=', $options[1]);
        return Crypt::decryptString($ccexp[1]);
    }

    public function get_cvv(){
        $options = explode('&', $this->authorize_customer_profile_id);
        $cvv = explode('cvv=', $options[2]);
        return Crypt::decryptString($cvv[1]);
    }


}
