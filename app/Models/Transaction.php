<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'status', 'amount', 'payment_date', 'name', 'email', 'phone', 'batch_id','last_4'
    ];
}
