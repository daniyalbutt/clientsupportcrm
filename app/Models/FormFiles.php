<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormFiles extends Model
{
    use HasFactory;

    public function logo_form(){
        return $this->hasOne(LogoForm::class, 'id', 'logo_form_id');
    }
}
