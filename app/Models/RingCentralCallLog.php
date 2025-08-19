<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RingCentralCallLog extends Model
{
    use HasFactory;

    protected $table = 'rc_call_logs';
    protected $fillable = [
        'started_at',
        'answered_at',
        'finished_at',
        'direction',
        'caller_number',
        'dest_number',
        'call_sec',
        'cld',
        'cli',
        'country_code',
    ];
}
