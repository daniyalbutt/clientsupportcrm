<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BrandLeads extends Model
{
    // use HasFactory;

    protected $fillable = [
        'brand_name',
        'name',
        'email',
        'phone',
        'service',
        'message',
        'url',
        'ip_address',
        'city',
        'country',
        'internet_connection',
        'zipcode',
        'region',
        'created_at',
        'updated_at',
    ];
}
