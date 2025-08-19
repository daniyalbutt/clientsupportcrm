<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';
    protected $fillable = ['name', 'slug', 'actual_price', 'price', 'cut_price', 'details', 'addon', 'description', 'best_selling', 'on_landing', 'is_combo', 'brand_id', '	service_id'];

}
