<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoBrief extends Model
{
    use HasFactory;
    protected $table = 'logo_brief';
    protected $fillable = ['logo_info', 'selected_logo', 'brief_text', 'brief_tagline', 'brief_description', 'design_concept', 'existing_website', 'client_id', 'client_email'];
    
}