<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    public function currency(){
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
