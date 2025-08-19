<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookMarketing extends Model
{
    use HasFactory;

    public function invoice(){
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }

    public function formfiles(){
        return $this->hasMany(FormFiles::class, 'logo_form_id', 'id')->where('form_code', 11);
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function project(){
        return $this->hasOne(Project::class, 'form_id', 'id')->where('form_checker', 11);
    }
}
